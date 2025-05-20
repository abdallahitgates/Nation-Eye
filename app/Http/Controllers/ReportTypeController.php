<?php

namespace App\Http\Controllers;

use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    public function index()
    {
        return response()->json(['types' => ReportType::select('id', 'name')->get()]);
    }
}
