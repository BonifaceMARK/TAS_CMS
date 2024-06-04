<?php

namespace App\Http\Controllers;
use App\Models\TasFile;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
   public function vehicleBarChart()
   {
      $vehicleCounts = TasFile::select('typeofvehicle', \DB::raw('count(*) as total'))
      ->groupBy('typeofvehicle')
      ->pluck('total', 'typeofvehicle')
      ->toArray();

      return view('analytics', compact('vehicleCounts'));

   }
}
