<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Http\Request;

class SendNotifyController extends Controller
{
    public function send_notify()
    {
        $admin = User::where('type','admin')->first();
        $admin->notify(new TestNotification());
        // dd($admin);
    }
    public function all_notify()
    {
        return view('all_notify');
    }
}
