<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalLead = Lead::query()->creator()->count();
        $totalContactedLead = Lead::where('status',Lead::CONTACTED)->creator()->count();
        $totalConvertedLead = Lead::where('status',Lead::CONVERTED)->creator()->count();
        $totalLostLead = Lead::where('status',Lead::LOST)->creator()->count();
        return view('dashboard',compact('totalLead','totalContactedLead','totalConvertedLead','totalLostLead'));
    }
}
