<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
 
    public function created(User $User)
    {
        Cache::flush();
    }

 
    public function updated(User $User)
    {
        Cache::flush();
    }

    public function deleted(User $User)
    {
        //
    }


    public function restored(User $User)
    {
        //
    }

 
    public function forceDeleted(User $User)
    {
        //
    }
}
