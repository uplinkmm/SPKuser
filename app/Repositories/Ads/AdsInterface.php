<?php
namespace App\Repositories\Ads;
interface AdsInterface {

    public function list($request);

    public function getMarqueeAds($request);


}