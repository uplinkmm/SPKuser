<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DepositWithdrawTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositWithdrawTutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $depositWithdrawTutorials = DepositWithdrawTutorial::latest()->get();
        ResponseData($depositWithdrawTutorials);
    }

}
