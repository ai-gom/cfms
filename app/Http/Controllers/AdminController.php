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
        $currentYear = Carbon::now()->year;

        // Fetch data for the entire year (January to December)
        $annualData = $this->fetchDataByPeriod(1, 12, $currentYear);
        $annualResponses = $this->computeCcResponses(1, 12, $currentYear, $annualData['totalForms']);
    
        // Option descriptions for Citizen's Charter responses
        $yourOptions = [
            'cc1' => [
                '1' => 'I know what a CC is and I saw this Office\'s CC.',
                '2' => 'I know what a CC is but I did not see this office\'s CC.',
                '3' => 'I learned of the CC only when I saw the office\'s CC.',
                '4' => 'I did not know what a CC is and I did not see this office\'s CC.'
            ],
            'cc2' => [
                '1' => 'Easy to see',
                '2' => 'Somewhat easy to see',
                '3' => 'Difficult to see',
                '4' => 'Not Visible at all',
                '5' => 'N/A'
            ],
            'cc3' => [
                '1' => 'Helped very much',
                '2' => 'Somewhat helped',
                '3' => 'Did not help',
                '4' => 'N/A'
            ]
        ];
    
        // Return the view with annual data
        return view('admin.reports', compact('annualData', 'annualResponses', 'yourOptions'));
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
        $currentYear = Carbon::now()->year;
        $januaryToJuneData = $this->fetchDataByPeriod(1, 6, $currentYear);
        $julyToDecemberData = $this->fetchDataByPeriod(7, 12, $currentYear);

        $januaryToJuneResponses = $this->computeCcResponses(1, 6, $currentYear, $januaryToJuneData['totalForms']);
        $julyToDecemberResponses = $this->computeCcResponses(7, 12, $currentYear, $julyToDecemberData['totalForms']);

        // Option descriptions
    $yourOptions = [
        'cc1' => [
            '1' => 'I know what a CC is and I saw this Office\'s CC.',
            '2' => 'I know what a CC is but I did not see this office\'s CC.',
            '3' => 'I learned of the CC only when I saw the office\'s CC.',
            '4' => 'I did not know what a CC is and I did not see this office\'s CC.'
        ],
        'cc2' => [
            '1' => 'Easy to see',
            '2' => 'Somewhat easy to see',
            '3' => 'Difficult to see',
            '4' => 'Not Visible at all',
            '5' => 'N/A'
        ],
        'cc3' => [
            '1' => 'Helped very much',
            '2' => 'Somewhat helped',
            '3' => 'Did not help',
            '4' => 'N/A'
        ]
    ];

    
        return view('admin.reports_bi_quarterly', compact(
            'januaryToJuneData',
            'julyToDecemberData',
            'januaryToJuneResponses',
            'julyToDecemberResponses',
            'yourOptions'
        ));

        
    }

    private function fetchDataByPeriod($startMonth, $endMonth, $year)
    {
        $totalForms = Form::whereYear('date', $year)
                          ->whereMonth('date', '>=', $startMonth)
                          ->whereMonth('date', '<=', $endMonth)
                          ->count();

        return [
            'totalForms' => $totalForms,
            'maleExternalPercentage' => $this->calculatePercentage($startMonth, $endMonth, $year, 'male', 'external', $totalForms),
            'femaleExternalPercentage' => $this->calculatePercentage($startMonth, $endMonth, $year, 'female', 'external', $totalForms),
            'preferNotToSayExternalPercentage' => $this->calculatePercentage($startMonth, $endMonth, $year, 'prefer-not-to-say', 'external', $totalForms),
            'maleInternalPercentage' => $this->calculatePercentage($startMonth, $endMonth, $year, 'male', 'internal', $totalForms),
            'femaleInternalPercentage' => $this->calculatePercentage($startMonth, $endMonth, $year, 'female', 'internal', $totalForms),
            'preferNotToSayInternalPercentage' => $this->calculatePercentage($startMonth, $endMonth, $year, 'prefer-not-to-say', 'internal', $totalForms),
            'maleOverallPercentage' => $this->calculateOverallPercentage($startMonth, $endMonth, $year, 'male', $totalForms),
            'femaleOverallPercentage' => $this->calculateOverallPercentage($startMonth, $endMonth, $year, 'female', $totalForms),
            'preferNotToSayOverallPercentage' => $this->calculateOverallPercentage($startMonth, $endMonth, $year, 'prefer-not-to-say', $totalForms),
            'ageRanges' => $this->computeAgeRanges($startMonth, $endMonth, $year, $totalForms),
            'municipalityData' => $this->computeMunicipalityData($startMonth, $endMonth, $year, $totalForms),
            'clientCategories' => $this->computeClientCategories($startMonth, $endMonth, $year, $totalForms)
        ];
    }

    private function calculatePercentage($startMonth, $endMonth, $year, $sex, $serviceType, $totalForms)
    {
        $count = Form::where('sex', $sex)
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereHas('service', function ($query) use ($serviceType) {
                $query->where('service_type', $serviceType);
            })
            ->count();

        return ($totalForms > 0) ? ($count / $totalForms) * 100 : 0;
    }

    private function calculateOverallPercentage($startMonth, $endMonth, $year, $sex, $totalForms)
    {
        $externalCount = $this->calculatePercentage($startMonth, $endMonth, $year, $sex, 'external', $totalForms);
        $internalCount = $this->calculatePercentage($startMonth, $endMonth, $year, $sex, 'internal', $totalForms);

        return $externalCount + $internalCount;
    }

    private function computeAgeRanges($startMonth, $endMonth, $year, $totalForms)
    {
        $ageRanges = [
            '19 or lower' => [0, 19], 
            '20-34' => [20, 34], 
            '35-49' => [35, 49], 
            '50-64' => [50, 64], 
            '65 or higher' => [65, 150]
        ];
        $ageData = [];

        foreach ($ageRanges as $range => [$min, $max]) {
            $externalCount = Form::whereBetween('age', [$min, $max])
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereHas('service', function ($query) {
                    $query->where('service_type', 'external');
                })
                ->count();

            $internalCount = Form::whereBetween('age', [$min, $max])
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereHas('service', function ($query) {
                    $query->where('service_type', 'internal');
                })
                ->count();

            $total = $externalCount + $internalCount;

            $ageData[$range] = [
                'external' => ['count' => $externalCount, 'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0],
                'internal' => ['count' => $internalCount, 'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0],
                'total' => ['count' => $total, 'percentage' => ($totalForms > 0) ? ($total / $totalForms) * 100 : 0]
            ];
        }

        return $ageData;
    }

    private function computeMunicipalityData($startMonth, $endMonth, $year, $totalForms)
    {
        $municipalities = ['Agno', 'Aguilar', 'Alaminos', 'Alcala', 'Anda', 'Bani', 'Binmaley', 'Bolinao', 'Burgos', 'Dagupan', 'Dasol', 'Infanta', 'Lingayen', 'Mabini', 'Mangaldan', 'Mangatarem', 'Rosales', 'Sta. Barbara', 'Sta. Maria', 'Sual', 'Others'];
        $municipalityData = [];

        foreach ($municipalities as $municipality) {
            $externalCount = Form::where('municipality', $municipality)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereHas('service', function ($query) {
                    $query->where('service_type', 'external');
                })
                ->count();

            $internalCount = Form::where('municipality', $municipality)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereHas('service', function ($query) {
                    $query->where('service_type', 'internal');
                })
                ->count();

            $total = $externalCount + $internalCount;

            $municipalityData[$municipality] = [
                'external' => ['count' => $externalCount, 'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0],
                'internal' => ['count' => $internalCount, 'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0],
                'total' => ['count' => $total, 'percentage' => ($totalForms > 0) ? ($total / $totalForms) * 100 : 0]
            ];
        }

        return $municipalityData;
    }

    private function computeClientCategories($startMonth, $endMonth, $year, $totalForms)
    {
        $clientCategories = ['Student', 'Faculty', 'Non-teaching staff', 'Alumni', 'Parents', 'Supplier', 'Community_member', 'Industry_partner', 'Regulatory', 'Others'];
        $categoryData = [];

        foreach ($clientCategories as $category) {
            $externalCount = Form::where('client_category', $category)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereHas('service', function ($query) {
                    $query->where('service_type', 'external');
                })
                ->count();

            $internalCount = Form::where('client_category', $category)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereHas('service', function ($query) {
                    $query->where('service_type', 'internal');
                })
                ->count();

            $total = $externalCount + $internalCount;

            $categoryData[$category] = [
                'external' => ['count' => $externalCount, 'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0],
                'internal' => ['count' => $internalCount, 'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0],
                'total' => ['count' => $total, 'percentage' => ($totalForms > 0) ? ($total / $totalForms) * 100 : 0]
            ];
        }

        return $categoryData;
    }

    // Helper function for calculating responses and percentages
private function computeCcResponses($startMonth, $endMonth, $year, $totalForms)
{
    $ccResponses = [
        'cc1' => ['1' => 0, '2' => 0, '3' => 0, '4' => 0],
        'cc2' => ['1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0],
        'cc3' => ['1' => 0, '2' => 0, '3' => 0, '4' => 0]
    ];

    foreach (['cc1', 'cc2', 'cc3'] as $ccField) {
        foreach ($ccResponses[$ccField] as $option => &$count) {
            $count = Form::where($ccField, $option)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->count();

            // Calculate percentage
            $ccResponses[$ccField][$option] = [
                'count' => $count,
                'percentage' => ($totalForms > 0) ? ($count / $totalForms) * 100 : 0
            ];
        }
    }

    return $ccResponses;
}

    public function reports_quarterly()
    {
        $currentYear = Carbon::now()->year;

        $januaryToMarchData = $this->fetchDataByPeriod(1, 3, $currentYear);
        $aprilToJuneData = $this->fetchDataByPeriod(4, 6, $currentYear);
        $julyToSeptemberData = $this->fetchDataByPeriod(7, 9, $currentYear);
        $octoberToDecemberData = $this->fetchDataByPeriod(10, 12, $currentYear);

        $januaryToMarchResponses = $this->computeCcResponses(1, 3, $currentYear, $januaryToMarchData['totalForms']);
        $aprilToJuneResponses = $this->computeCcResponses(4, 6, $currentYear, $aprilToJuneData['totalForms']);
        $julyToSeptemberResponses = $this->computeCcResponses(7, 9, $currentYear, $julyToSeptemberData['totalForms']);
        $octoberToDecemberResponses = $this->computeCcResponses(10, 12, $currentYear, $octoberToDecemberData['totalForms']);
        // Option descriptions
    $yourOptions = [
        'cc1' => [
            '1' => 'I know what a CC is and I saw this Office\'s CC.',
            '2' => 'I know what a CC is but I did not see this office\'s CC.',
            '3' => 'I learned of the CC only when I saw the office\'s CC.',
            '4' => 'I did not know what a CC is and I did not see this office\'s CC.'
        ],
        'cc2' => [
            '1' => 'Easy to see',
            '2' => 'Somewhat easy to see',
            '3' => 'Difficult to see',
            '4' => 'Not Visible at all',
            '5' => 'N/A'
        ],
        'cc3' => [
            '1' => 'Helped very much',
            '2' => 'Somewhat helped',
            '3' => 'Did not help',
            '4' => 'N/A'
        ]
    ];

        return view('admin.reports_quarterly', compact('januaryToMarchData', 'aprilToJuneData', 'julyToSeptemberData', 'octoberToDecemberData','januaryToMarchResponses','aprilToJuneResponses','julyToSeptemberResponses','octoberToDecemberResponses','yourOptions'));
    }


}



