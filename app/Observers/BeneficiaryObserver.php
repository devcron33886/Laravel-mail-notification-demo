<?php

namespace App\Observers;
use App\Models\User;
use  App\Notifications\NotifySectorNotification;
use Illuminate\Support\Facades\Notification;

class BeneficiaryObserver
{
    public function created(\App\Models\Beneficiary $model)
    {
        $beneficiary  = ['action' => 'created', 'model_name' => 'Beneficiary'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'User');
        })->get();
        Notification::send($users, new NotifySectorNotification($beneficiary));
    }
}
