<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Repositories\Profile\ProfileInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    private $profileRepo;
    public function __construct(ProfileInterface $repo)
    {
        $this->profileRepo=$repo;
    }
    public function getProfile(Request $request){
        $data=$this->profileRepo->getProfile($request);
        ResponseData($data);
    }
    public function changePassword(ChangePasswordRequest $request){
        $this->profileRepo->changePassword($request);
    }
}
