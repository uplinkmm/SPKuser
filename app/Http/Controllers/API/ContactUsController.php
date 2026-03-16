<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = ContactUs::latest()->get();
        ResponseData($data);
    }

}
