<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    private $notificationRepo;
    public function __construct(NotificationInterface $repo)
    {
        $this->notificationRepo=$repo;
    }

    public function index(Request $request){
        $data=$this->notificationRepo->notificationList($request);
        ResponseData($data);
    }

    public function create(Request $request){
        $users = $this->getUserByRole('HR', ['Manager']);
        $data = [
            'date' => now(),
            'title' => 'You have received a new PO to confirm',
            'body' => 'New Purchase Order',
        ];
        #send old notificaiton 
        #end
        if($users->isNotEmpty()){
            // $department_id=$users[0]->department_id;
            // dd($role_id.$department_id);
            // $data['role_id']=$role_id;
            $this->send($j, $users, $data);
        }
    }
}
