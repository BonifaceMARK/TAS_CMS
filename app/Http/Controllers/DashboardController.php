<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\TasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function indexa()
    {
        $recentActivity = TasFile::whereDate('created_at', today())->latest()->take(5)->get();
        
        // Fetch sales for today
        $salesToday = TasFile::whereDate('created_at', today())->count();

        // Fetch revenue for this month
        $revenueThisMonth = TasFile::whereMonth('created_at', now())->count();

        // Fetch customers for this year
        $customersThisYear = TasFile::whereYear('created_at', now())->count();

        $recentSalesToday = TasFile::whereDate('created_at', today())->latest()->take(5)->get();
        $recentViolationsToday = $this->getRecentViolationsToday();
        return view('index', compact('recentActivity', 'recentViolationsToday','recentSalesToday','salesToday', 'revenueThisMonth', 'customersThisYear'));
        }
        public function getRecentViolationsToday()
        {
            // Retrieve all recent violations, regardless of the date
            $recentViolationsToday = TasFile::orderBy('transaction_date', 'desc')
                ->get();
        
            return $recentViolationsToday;
        }
        
    public function tables()
    {
        return view('layout');
    }

    public function tasManage()
    {
        return view('tas.manage');
    }

    public function tasView()
    {
        $tasFiles = TasFile::paginate(10);
        return view('tas.view', compact('tasFiles'));
    }

    public function saveRemarks(Request $request)
    {
        $request->validate([
            'remarks' => 'required|string|max:255',
            'tas_file_id' => 'required|exists:tas_files,id', // Add validation for tas_file_id
        ]);

        try {
            // Retrieve the TasFile ID from the request
            $id = $request->input('tas_file_id');

            // Retrieve the TasFile object
            $tasFile = TasFile::findOrFail($id);

            // Update the REMARKS attribute with the input value
            $tasFile->REMARKS = $request->input('remarks');

            // Save the TasFile object
            $tasFile->save();

            // Redirect back with a success message
            return back()->with('success', 'Remarks saved successfully!');
        } catch (\Throwable $th) {
            // Log the error
            logger()->error('Error saving remarks: ' . $th->getMessage());

            // Redirect back with an error message
            return back()->with('error', 'Failed to save remarks. Please try again later.');
        }
    }

    public function submitForm(Request $request)
{
    try {
        $validatedData = $request->validate([
            'case_no' => 'required|string',
            'top' => 'required|string',
            'name' => 'required|string',
            'violation' => 'required|string',
            'transaction_no' => 'required|string',
            'transaction_date' => 'required|date',
            'file_attachment' => 'nullable|array', 
            'file_attachment.*' => 'nullable|file|max:5120', 
        ]);
        DB::beginTransaction();
        
        if ($request->hasFile('file_attachment')) {
            $filePaths = []; 
            $cx = 1;
            foreach ($request->file('file_attachment') as $file) {
                $x = $validatedData['case_no']. "_documents_" . $cx . "_";
                $fileName = $x . time();
                $file->storeAs('attachments', $fileName, 'public'); 
                $filePaths[] = 'attachments/' . $fileName; 
                $cx++; // Increment the counter for the next file
            }
            $tasFile = new TasFile([
                'case_no' => $validatedData['case_no'],
                'top' => $validatedData['top'],
                'name' => $validatedData['name'],
                'violation' => $validatedData['violation'],
                'transaction_no' => $validatedData['transaction_no'],
                'transaction_date' => $validatedData['transaction_date'],
                'file_attach' => json_encode($filePaths), 
            ]);
        } else {
            $tasFile = new TasFile([
                'case_no' => $validatedData['case_no'],
                'top' => $validatedData['top'],
                'name' => $validatedData['name'],
                'violation' => $validatedData['violation'],
                'transaction_no' => $validatedData['transaction_no'],
                'transaction_date' => $validatedData['transaction_date'],
            ]);
        }
        $tasFile->save();
        DB::commit();
        return redirect()->back()->with('success', 'Form submitted successfully!');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors());
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', $e->getMessage());
    }
}
public function getChartData()
{
    // Fetch data from the database
    $tasFiles = TasFile::all();

    // Transform the data into the format expected by ApexCharts
    $chartData = $tasFiles->map(function ($tasFile) {
        return [
            'name' => $tasFile->violation,
            'data' => [$tasFile->case_no], // Use the case_no field as the value
        ];
    });

    return response()->json($chartData);
}







}
