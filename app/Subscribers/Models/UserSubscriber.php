<?php 

namespace App\Subscribers\Models;

use App\Events\Models\User\UserCreatedEvent;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber 
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreatedEvent::class, SendWelcomeEmail::class);
    }
}