<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    \Log::info('🔐 Channel auth', [
        'auth_user_id' => optional($user)->id,
        'receiverId' => $receiverId
    ]);

    if ($user && (int) $user->id === (int) $receiverId) {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    return false;
});
