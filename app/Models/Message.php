<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'content', 'seen'];

    protected $appends = ['time_ago', 'seen_status'];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the human-readable time difference for when the message was created.
     *
     * @return string
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Accessor for the 'seen' attribute.
     * Returns 'read' or 'unread'.
     *
     * @return string
     */
    public function getSeenStatusAttribute()
    {
        return $this->seen ? 'read' : 'unread';
    }

    /**
     * Query messages between two users.
     */
    public static function getMessagesQueryBetweenTwoUsers($request, $sender_id, $receiver_id)
    {
        $query = self::with(['sender', 'receiver'])->where(function ($q) use ($sender_id, $receiver_id) {
            $q->where(function ($sub) use ($sender_id, $receiver_id) {
                $sub->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id);
            })
              ->orWhere(function ($sub) use ($sender_id, $receiver_id) {
                  $sub->where('receiver_id', $sender_id)
                      ->where('sender_id', $receiver_id);
              });
        });

        return $query;
    }
}
