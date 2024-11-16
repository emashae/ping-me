<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;
use Carbon\Carbon;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Fetch messages between the authenticated user and the receiver
        $messagesQuery = Message::getMessagesQueryBetweenTwoUsers($request, Auth::id(), $request->receiver_id);

        // Optional: Filter by date
        if ($request->earlier_date) {
            $dateFormatted = Carbon::parse($request->earlier_date)->format("Y-m-d H:i:s");
            $messagesQuery->where("created_at", "<", $dateFormatted);
        }

        // Display top messages for the user
        $result = $messagesQuery->orderBy('created_at', 'DESC')
                                ->limit($request->limit ?? 10)
                                ->get();

        // Mark messages as 'unseen' for the receiver
        $this->markMessagesAsUnseen($result);

        return response()->json(['status' => true, 'messages' => $result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MessageRequest $request)
    {
        // Create the message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->message_content,
        ]);

        // Load sender and receiver data
        $updatedMessage = $message->load(['sender', 'receiver']);

        // Dispatch the message sent event
        MessageSent::dispatch($updatedMessage);

        return response()->json(['status' => true, 'message' => $updatedMessage], 201);
    }

    /**
     * Update the specified message's 'seen' status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['status' => false, 'message' => 'Message not found'], 404);
        }

        // Update 'seen' status to 0
        $message->update(['seen' => 0]);

        return response()->json(['status' => true, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json(['status' => false, 'message' => 'Message not found'], 404);
        }

        // Delete the message
        $message->delete();

        return response()->json(['status' => true, 'message' => 'Message deleted successfully']);
    }

    /**
     * Mark all messages as unseen (for unread messages).
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $messages
     * @return void
     */
    private function markMessagesAsUnseen($messages)
    {
        $messages->where('receiver_id', Auth::id())
                 ->each(function ($msg) {
                     $msg->update(['seen' => 0]);
                 });
    }
}
