<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Action\Notifying;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    //
    public function testNoti(Request $request){
        foreach (User::all() as $user) {
            $data['title']='test';
            $data['body']='body';
            $data['date_time']=now();

            $user->notify(new Notifying($data));
        }
        ResponseMessage('Notificaion Send.....',200);
    }

    public function testRedis(){
        // Redis::set('name', 'kaungsattkhant');
        $values = Redis::command('lrange', ['name', 5, 10]);
        return $values;
        // Redis::set('name', 'Taylor');
        // $values = Redis::lrange('names', 5, 10);
        // return $values;
    }
}
