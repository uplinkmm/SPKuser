<?php

namespace App\Repositories\Profile;

interface ProfileInterface
{

    public function getProfile($request);

    public function changePassword($request);

}
