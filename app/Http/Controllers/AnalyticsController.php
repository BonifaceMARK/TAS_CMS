<?php

namespace App\Http\Controllers;
use App\Models\TasFile;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
   public function indexDataChart(){
    $tasFiles = TasFile::all();
    return view('caseAnalytics.dataChart', compact('tasFiles'));
   }
}
