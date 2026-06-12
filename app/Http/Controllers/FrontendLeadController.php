<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class FrontendLeadController extends Controller
{
    public function index(){
        $leads = Lead::query()->creator()->get();
        return view('lead',compact('leads'));
    }
}
