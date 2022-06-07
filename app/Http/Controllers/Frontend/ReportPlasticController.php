<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportPlasticController extends Controller
{
    public function index()
    {
        return view('ui.frontend.report.plastic');
    }
}

