<?php

namespace App\Http\Controllers;

use App\Models\BlogCategories;
use App\Models\DynamicContent;
use App\Models\GenarelInfo;
use App\Models\SingleSection;
use App\Models\SocialIcon;
use App\Models\Team;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{ 
    public function __construct()
    {
        // $this->middleware('auth');
    }
}
