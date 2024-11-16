<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $messagesQuery = Message::getMessagesQueryBetweenTwoUsers($request, auth()->user()->id, $request->receiver_id);

        if($request->earlier_date) {
            $dateFormatted = (new \DateTime($request->earlier_date))->format("Y-m-d H:i:s");

            $messagesQuery->where("created_at", "<", $dateFormatted);
        }

        // display top 10 messages for user
        $result = $messagesQuery->orderBy('created_at', 'DESC')
                        ->limit($request->limit ?? 10)
                        ->get();

        if($result->count()) {
            foreach ($result as $msg) {
                if((int) $msg->receiver_id === auth()->user()->id) {
                    $msg->update(['seen' => 0]);
                }
            }
        }

        return response()->json(data: ['status' => true, 'messages' => $result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(!$request->message_content) {
            return response()->json(data: ['status' => false], status: 500);
        }

        $message = new Message();
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->message_content;
        $message->save();

        $updatedMessage = Message::with(['sender', 'receiver'])->find($message->id);

        // fire the message sent event
        MessageSent::dispatch($updatedMessage);

        return response()->json(data: ['status' => true, 'message' => $updatedMessage], status: 201);
    }

    public function update($id)
    {
        $message = Message::find($id);

        $message->seen = 0;

        $message->save();

        return response()->json(data: ['status' => true, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
