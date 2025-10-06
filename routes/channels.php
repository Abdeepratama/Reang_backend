<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}.{dokterId}', function ($user, $userId, $dokterId) {
    return (int) $user->id === (int) $userId || (int) $user->id === (int) $dokterId;
});
