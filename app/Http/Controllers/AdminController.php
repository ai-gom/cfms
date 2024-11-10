<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Services;

use Carbon\Carbon;

use App\Models\Form;



class AdminController extends Controller
{
    public function reports()
    {
     // Get the current year
    $currentYear = Carbon::now()->year;

    // Get the total number of form submissions for the current year
    $totalSubmissions = Form::whereYear('date', $currentYear)->count();

    // Get services data
    $data = Services::all();  // Fetch all services

    // Counts based on sex and service type (external)
    $maleExternalCount = Form::where('sex', 'male')
        ->whereHas('service', function ($query) {
            $query->where('service_type', 'external');
        })
        ->count();

    $femaleExternalCount = Form::where('sex', 'female')
        ->whereHas('service', function ($query) {
            $query->where('service_type', 'external');
        })
        ->count();

    $preferNotToSayExternalCount = Form::where('sex', 'prefer-not-to-say')
        ->whereHas('service', function ($query) {
            $query->where('service_type', 'external');
        })
        ->count();

    // Counts for internal service type
    $maleInternalCount = Form::where('sex', 'male')
        ->whereHas('service', function ($query) {
            $query->where('service_type', 'internal');
        })
        ->count();

    $femaleInternalCount = Form::where('sex', 'female')
        ->whereHas('service', function ($query) {
            $query->where('service_type', 'internal');
        })
        ->count();

    $preferNotToSayInternalCount = Form::where('sex', 'prefer-not-to-say')
        ->whereHas('service', function ($query) {
            $query->where('service_type', 'internal');
        })
        ->count();

    // Total counts for each sex
    $totalMale = $maleExternalCount + $maleInternalCount;
    $totalFemale = $femaleExternalCount + $femaleInternalCount;
    $totalPreferNotToSay = $preferNotToSayExternalCount + $preferNotToSayInternalCount;

    $totalForms = $totalMale + $totalFemale + $totalPreferNotToSay;

    // Calculate percentages for external service type
    $maleExternalPercentage = ($totalForms > 0) ? ($maleExternalCount / $totalForms) * 100 : 0;
    $femaleExternalPercentage = ($totalForms > 0) ? ($femaleExternalCount / $totalForms) * 100 : 0;
    $preferNotToSayExternalPercentage = ($totalForms > 0) ? ($preferNotToSayExternalCount / $totalForms) * 100 : 0;

    // Calculate percentages for internal service type
    $maleInternalPercentage = ($totalForms > 0) ? ($maleInternalCount / $totalForms) * 100 : 0;
    $femaleInternalPercentage = ($totalForms > 0) ? ($femaleInternalCount / $totalForms) * 100 : 0;
    $preferNotToSayInternalPercentage = ($totalForms > 0) ? ($preferNotToSayInternalCount / $totalForms) * 100 : 0;

    // Calculate overall percentages (sum of both external and internal)
    $maleOverallPercentage = ($totalForms > 0) ? ($totalMale / $totalForms) * 100 : 0;
    $femaleOverallPercentage = ($totalForms > 0) ? ($totalFemale / $totalForms) * 100 : 0;
    $preferNotToSayOverallPercentage = ($totalForms > 0) ? ($totalPreferNotToSay / $totalForms) * 100 : 0;

    // Age ranges counts and percentages
    $ageRanges = [
        '19 or lower' => [0, 0], 
        '20-34' => [0, 0], 
        '35-49' => [0, 0], 
        '50-64' => [0, 0], 
        '65 or higher' => [0, 0], 
        'Did not specify' => [0, 0]
    ];

    foreach ($ageRanges as $ageRange => $counts) {
        $externalCount = Form::whereBetween('age', $this->getAgeRange($ageRange))
            ->whereHas('service', function ($query) {
                $query->where('service_type', 'external');
            })
            ->count();

        $internalCount = Form::whereBetween('age', $this->getAgeRange($ageRange))
            ->whereHas('service', function ($query) {
                $query->where('service_type', 'internal');
            })
            ->count();

        $totalAgeRangeCount = $externalCount + $internalCount;
        $ageRanges[$ageRange] = [
            'external' => ['count' => $externalCount, 'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0],
            'internal' => ['count' => $internalCount, 'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0],
            'total' => ['count' => $totalAgeRangeCount, 'percentage' => ($totalForms > 0) ? ($totalAgeRangeCount / $totalForms) * 100 : 0],
        ];
    }

    // Municipality counts and percentages by service type
    $municipalities = [
        'Agno', 'Aguilar', 'Alaminos', 'Alcala', 'Anda', 'Bani', 'Binmaley', 'Bolinao', 'Burgos',
        'Dagupan', 'Dasol', 'Infanta', 'Lingayen', 'Mabini', 'Mangaldan', 'Mangatarem', 'Rosales',
        'Sta. Barbara', 'Sta. Maria', 'Sual'
    ];

    $municipalityData = [];
    foreach ($municipalities as $municipality) {
        // Get external count for the municipality
        $externalCount = Form::where('municipality', $municipality)
            ->whereHas('service', function ($query) {
                $query->where('service_type', 'external');
            })
            ->count();

        // Get internal count for the municipality
        $internalCount = Form::where('municipality', $municipality)
            ->whereHas('service', function ($query) {
                $query->where('service_type', 'internal');
            })
            ->count();

        // Total count for the municipality (external + internal)
        $totalMunicipalityCount = $externalCount + $internalCount;

        // Calculate percentages
        $municipalityData[$municipality] = [
            'external' => ['count' => $externalCount, 'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0],
            'internal' => ['count' => $internalCount, 'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0],
            'total' => ['count' => $totalMunicipalityCount, 'percentage' => ($totalForms > 0) ? ($totalMunicipalityCount / $totalForms) * 100 : 0],
        ];
    }

    // Fetch client categories data
    $clientCategories = [];
    foreach (['Student', 'faculty', 'Non-teaching staff', 'Alumni', 'parents', 'supplier', 'Community_member', 'industry_partner', 'Regulatory', 'Others'] as $category) {
        $externalCount = Form::where('client_category', $category)
            ->whereHas('service', function ($query) {
                $query->where('service_type', 'external');
            })
            ->count();

        $internalCount = Form::where('client_category', $category)
            ->whereHas('service', function ($query) {
                $query->where('service_type', 'internal');
            })
            ->count();

        $totalCategoryCount = $externalCount + $internalCount;

        $clientCategories[$category] = [
            'external' => ['count' => $externalCount, 'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0],
            'internal' => ['count' => $internalCount, 'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0],
            'total' => ['count' => $totalCategoryCount, 'percentage' => ($totalForms > 0) ? ($totalCategoryCount / $totalForms) * 100 : 0],
        ];
    }

    return view('admin.reports', compact(
        'totalSubmissions', 
        'data',  
        'maleExternalPercentage', 'femaleExternalPercentage', 'preferNotToSayExternalPercentage',
        'maleInternalPercentage', 'femaleInternalPercentage', 'preferNotToSayInternalPercentage',
        'maleOverallPercentage', 'femaleOverallPercentage', 'preferNotToSayOverallPercentage',
        'ageRanges', 'municipalityData', 'clientCategories' // Add clientCategories here
    ));
}

private function getAgeRange($range)
{
    switch ($range) {
        case '19 or lower':
            return [0, 19];
        case '20-34':
            return [20, 34];
        case '35-49':
            return [35, 49];
        case '50-64':
            return [50, 64];
        case '65 or higher':
            return [65, 200];  // Assuming 200 is the max age
        default:
            return [null, null];  // No age range specified
    }
}
    public function Account()
    {
        return view('admin.Account');
    }

    public function rankings()
    {
        return view('admin.rankings');
    }

    public function view_services()
    {
        $data = Services::all();

        return view('admin.services',compact('data'));
    }

    public function add_services(Request $request)
    {
        $services = new Services;

        $services->services_name = $request->services;

        $services->service_type = $request->service_type;

        $services->save();

        toastr()->addSuccess('Services Added Succesfully');

        return redirect()->back();
    }

    public function index()
    {
        $currentYear = Carbon::now()->year;

    // Assuming 'Service' is the model name for your services data
    $data = Services::all();

    // Monthly data
    $monthlySubmissions = [];
    for ($i = 1; $i <= 12; $i++) {
        $monthlySubmissions[] = Form::whereYear('date', $currentYear)
                                     ->whereMonth('date', $i)
                                     ->count();
    }

    // Quarterly data
    $quarterlySubmissions = [
        array_sum(array_slice($monthlySubmissions, 0, 3)),  // Q1
        array_sum(array_slice($monthlySubmissions, 3, 3)),  // Q2
        array_sum(array_slice($monthlySubmissions, 6, 3)),  // Q3
        array_sum(array_slice($monthlySubmissions, 9, 3))   // Q4
    ];

    // Bi-annual data
    $biAnnualSubmissions = [
        array_sum(array_slice($monthlySubmissions, 0, 6)),  // H1
        array_sum(array_slice($monthlySubmissions, 6, 6))   // H2
    ];

    // Annual data
    $annualSubmissions = array_sum($monthlySubmissions);

    return view('admin.index', compact('data', 'monthlySubmissions', 'quarterlySubmissions', 'biAnnualSubmissions', 'annualSubmissions'));

    }

    public function delete_services($id)
    {
        $data = Services::find($id);

    if ($data) {
        $data->delete();
    }

    // Redirect with success message
    return redirect()->back()->with('success', 'Service deleted successfully.');

    }

    public function reports_bi_quarterly()
    {
        return view('admin.reports_bi_quarterly');
    }
    

}
