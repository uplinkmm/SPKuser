<?php

namespace App\Repositories\Ads;

use App\Models\Ads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdsRepository implements AdsInterface
{
    public function list($request)
    {
        return Ads::orderBy("id", "desc")->take(3)->get();
    }
    
}