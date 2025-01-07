<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Ads\AdsInterface;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    //
    private $adsRepo;
    public function __construct(AdsInterface $repo){
        $this->adsRepo=$repo;
    }

    public function index(Request $request){
        $data= $this->adsRepo->list($request);
        ResponseData($data);
    }

}
