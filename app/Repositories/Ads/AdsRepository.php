<?php

namespace App\Repositories\Ads;

use App\Models\Ads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdsRepository implements AdsInterface
{
    public function list($request)
    {
        
        return Ads::orderBy("id", "desc")
        ->where('type','ads')
        ->get();
    }

    public function getMarqueeAds($request){
        return Ads::orderBy("id", "desc")
        ->where('type','marquee')
        ->orderBy('id','desc')
        ->first();                                  
    }
    
}