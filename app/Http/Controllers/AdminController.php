<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Services;

use Carbon\Carbon;

use App\Models\Form;

use Barryvdh\DomPDF\Facade\Pdf;



class AdminController extends Controller
{
    public function reports()
    {
        $currentYear = Carbon::now()->year;
    
        // Fetch data for the entire year (January to December)
        $annualData = $this->fetchDataByPeriod(1, 12, $currentYear);
        $annualResponses = $this->computeCcResponses(1, 12, $currentYear, $annualData['totalForms']);
        
    
        $expectationsFields = [
            'expectations_0', 'expectations_1', 'expectations_2',
            'expectations_3', 'expectations_4', 'expectations_5',
            'expectations_6', 'expectations_7', 'expectations_8'
        ];
    
        $expectationsBreakdown = $this->aggregateExpectations($expectationsFields, $currentYear, 1, 12);
    
        // Totals Calculation
        $totals = [
            'strongly_agree' => 0,
            'agree' => 0,
            'neither' => 0,
            'disagree' => 0,
            'strongly_disagree' => 0,
            'na' => 0,
            'total_responses' => 0,
            'average_overall_score' => 0,
        ];
    
        $sumOverallScores = 0;
        $countOverallScores = 0;
    
        foreach ($expectationsBreakdown as $breakdown) {
            $totals['strongly_agree'] += $breakdown['strongly-agree']['count'];
            $totals['agree'] += $breakdown['agree']['count'];
            $totals['neither'] += $breakdown['neither']['count'];
            $totals['disagree'] += $breakdown['disagree']['count'];
            $totals['strongly_disagree'] += $breakdown['strongly-disagree']['count'];
            $totals['na'] += $breakdown['na']['count'];
            $totals['total_responses'] += $breakdown['total_responses'];
    
            $totalRelevantResponses = $breakdown['total_responses'] - $breakdown['na']['count'];
            $agreeResponses = $breakdown['strongly-agree']['count'] + $breakdown['agree']['count'];
            $overallScore = $totalRelevantResponses > 0 ? ($agreeResponses / $totalRelevantResponses) * 100 : 0;
    
            $sumOverallScores += $overallScore;
            $countOverallScores++;
        }
    
        $totals['average_overall_score'] = $countOverallScores > 0 ? $sumOverallScores / $countOverallScores : 0;
    
        // Compute annual averages per service
        $serviceAveragesAnnual = $this->computeServiceAverages(1, 12, $currentYear);
    
        // Custom field labels
        $fieldLabels = [
            'expectations_0' => 'Responsiveness',
            'expectations_1' => 'Reliability',
            'expectations_2' => 'Access and Facilities',
            'expectations_3' => 'Communication',
            'expectations_4' => 'Costs',
            'expectations_5' => 'Integrity',
            'expectations_6' => 'Assurance',
            'expectations_7' => 'Outcome',
            'expectations_8' => 'Overall'
        ];
    
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

       // Add the client classification breakdown with required parameters
    $clientSexBreakdown = $this->getClientSexBreakdown(1, 12, $currentYear);
        //age
    $clientAgeBreakdown = $this->getClientAgeBreakdown(1, 12, $currentYear);

    // Add municipality breakdown
    $municipalityBreakdown = $this->getClientMunicipalityBreakdown(1, 12, $currentYear);

    $categoryBreakdown = $this->getClientCategoryBreakdown(1, 12, $currentYear);
    
        // Return the view with annual data
        return view('admin.reports', compact(
            'annualData',
            'annualResponses',
            'yourOptions',
            'expectationsBreakdown',
            'fieldLabels',
            'totals',
            'clientSexBreakdown',
            'serviceAveragesAnnual', // Include annual averages in the view
            'clientAgeBreakdown',
            'municipalityBreakdown',
            'categoryBreakdown'
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

    public function rankings(Request $request)
{
    $currentYear = $request->input('year', Carbon::now()->year); // Default to current year
    $period = $request->input('period', 'Annual'); // Default to Annual

    $periods = [
        'Q1' => [1, 3],
        'Q2' => [4, 6],
        'Q3' => [7, 9],
        'Q4' => [10, 12],
        'H1' => [1, 6],
        'H2' => [7, 12],
        'Annual' => [1, 12],
    ];

    if (!isset($periods[$period])) {
        abort(404, 'Invalid period specified.');
    }

    [$startMonth, $endMonth] = $periods[$period];

    // Fetch service averages
    $serviceAverages = $this->computeServiceAverages($startMonth, $endMonth, $currentYear);

    if (empty($serviceAverages)) {
        logger('No service averages found for the selected period.');
    }

    // Sort rankings by overall AWM
    $rankings = collect($serviceAverages)->sortByDesc('overall_awm')->values()->all();

    // Sort most used services by total respondents
    $mostUsedServices = collect($serviceAverages)->sortByDesc('total_respondents')->values()->all();

    // Compute weighted rankings
    $totalRespondentsSum = array_sum(array_column($serviceAverages, 'total_respondents'));
    $weightedRankings = collect($serviceAverages)
        ->map(function ($service) use ($totalRespondentsSum) {
            $weightedAverage = $totalRespondentsSum > 0
                ? (($service['overall_awm'] ?? 0) * ($service['total_respondents'] ?? 0)) / $totalRespondentsSum
                : 0;

            return [
                'service_name' => $service['service_name'] ?? 'Unknown',
                'weighted_average' => $weightedAverage,
            ];
        })
        ->sortByDesc('weighted_average')
        ->values()
        ->all();

    $highlightedYear = Carbon::now()->year;

    return view('admin.rankings', compact(
        'rankings',
        'currentYear',
        'period',
        'serviceAverages',
        'highlightedYear',
        'mostUsedServices',
        'weightedRankings'
    ));
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

        toastr()->success('Services Succesfully Added.'); 

        return redirect()->back();
    }

    public function update_services(Request $request, $id)
{
    // Find the service by ID
    $service = Services::findOrFail($id);

    // Update the service fields
    $service->services_name = $request->services_name;
    $service->service_type = $request->service_type;

    // Save the updated service
    $service->save();

    // Toastr success message
    toastr()->success('Service updated successfully.');

    // Redirect back
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

    $genderResponses = [
        'annually' => $this->getGenderDataByPeriod(1, 12, $currentYear),
        'january-march' => $this->getGenderDataByPeriod(1, 3, $currentYear),
        'april-june' => $this->getGenderDataByPeriod(4, 6, $currentYear),
        'july-september' => $this->getGenderDataByPeriod(7, 9, $currentYear),
        'october-december' => $this->getGenderDataByPeriod(10, 12, $currentYear),
        'january-june' => $this->getGenderDataByPeriod(1, 6, $currentYear),
        'july-december' => $this->getGenderDataByPeriod(7, 12, $currentYear),
    ];


    // Fetch data for clients' age breakdown
    $ageBreakdown = $this->getClientAgeBreakdown(1, 12, $currentYear);

     // Fetch data for client municipalities
     $municipalityBreakdown = $this->getClientMunicipalityBreakdown(1, 12, $currentYear);

       // Category breakdown for card 3
    $categoryBreakdown = $this->getClientCategoryBreakdown(1, 12, $currentYear);

    

    return view('admin.index', compact('data', 'monthlySubmissions', 'quarterlySubmissions', 'biAnnualSubmissions', 'annualSubmissions','genderResponses','ageBreakdown','municipalityBreakdown','categoryBreakdown'));

    }

    private function getGenderDataByPeriod($startMonth, $endMonth, $year)
    {
        return [
            'male' => [
                Form::where('sex', 'male')
                    ->whereYear('date', $year)
                    ->whereMonth('date', '>=', $startMonth)
                    ->whereMonth('date', '<=', $endMonth)
                    ->whereHas('service', function ($query) {
                        $query->where('service_type', 'external');
                    })
                    ->count(),
                Form::where('sex', 'male')
                    ->whereYear('date', $year)
                    ->whereMonth('date', '>=', $startMonth)
                    ->whereMonth('date', '<=', $endMonth)
                    ->whereHas('service', function ($query) {
                        $query->where('service_type', 'internal');
                    })
                    ->count(),
            ],
            'female' => [
                Form::where('sex', 'female')
                    ->whereYear('date', $year)
                    ->whereMonth('date', '>=', $startMonth)
                    ->whereMonth('date', '<=', $endMonth)
                    ->whereHas('service', function ($query) {
                        $query->where('service_type', 'external');
                    })
                    ->count(),
                Form::where('sex', 'female')
                    ->whereYear('date', $year)
                    ->whereMonth('date', '>=', $startMonth)
                    ->whereMonth('date', '<=', $endMonth)
                    ->whereHas('service', function ($query) {
                        $query->where('service_type', 'internal');
                    })
                    ->count(),
            ],
        ];
    }

    public function delete_services($id)
    {
        $data = Services::find($id);

    if ($data) {
        $data->delete();
    
         // Toastr success message for successful deletion
         toastr()->success('Service deleted successfully.');
        } else {
            // If service not found, toastr error message
            toastr()->error('Service not found.');
        }

    // Redirect with success message
    return redirect()->back();

    }

    public function reports_bi_quarterly()
    {
        $currentYear = Carbon::now()->year;
        $januaryToJuneData = $this->fetchDataByPeriod(1, 6, $currentYear);
        $julyToDecember = $this->fetchDataByPeriod(7, 12, $currentYear);


    // Compute client sex breakdown for both periods using month ranges
    $clientSexBreakdownJanToJune = $this->getClientSexBreakdown(1, 6, $currentYear);
    $clientSexBreakdownJulToDec = $this->getClientSexBreakdown(7, 12, $currentYear);

        $januaryToJuneResponses = $this->computeCcResponses(1, 4, $currentYear, $januaryToJuneData['totalForms']);
        $julyToDecemberResponses = $this->computeCcResponses(9, 12, $currentYear, $julyToDecember['totalForms']);

        // Compute averages per service for January to April
            $serviceAveragesJanToJune = $this->computeServiceAverages(1, 6, $currentYear);

// Compute averages per service for September to December
        $serviceAveragesJulToDec = $this->computeServiceAverages(7, 12, $currentYear); ////remove it if the table is wrong

        // Compute expectations breakdown for each bi-quarter
    $januaryToJuneExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        1,
        6
    );
    $julyToDecemberExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        7,
        12
    );



    // Function to calculate totals for a breakdown
    $calculateTotals = function ($breakdown) {
        $totals = [
            'strongly_agree' => 0,
            'agree' => 0,
            'neither' => 0,
            'disagree' => 0,
            'strongly_disagree' => 0,
            'na' => 0,
            'total_responses' => 0,
            'average_overall_score' => 0,
        ];

        $sumOverallScores = 0;
        $countOverallScores = 0;

        foreach ($breakdown as $fieldBreakdown) {
            $totals['strongly_agree'] += $fieldBreakdown['strongly-agree']['count'];
            $totals['agree'] += $fieldBreakdown['agree']['count'];
            $totals['neither'] += $fieldBreakdown['neither']['count'];
            $totals['disagree'] += $fieldBreakdown['disagree']['count'];
            $totals['strongly_disagree'] += $fieldBreakdown['strongly-disagree']['count'];
            $totals['na'] += $fieldBreakdown['na']['count'];
            $totals['total_responses'] += $fieldBreakdown['total_responses'];

            $totalRelevantResponses = $fieldBreakdown['total_responses'] - $fieldBreakdown['na']['count'];
            $agreeResponses = $fieldBreakdown['strongly-agree']['count'] + $fieldBreakdown['agree']['count'];
            $overallScore = $totalRelevantResponses > 0 ? ($agreeResponses / $totalRelevantResponses) * 100 : 0;

            $sumOverallScores += $overallScore;
            $countOverallScores++;
        }

        $totals['average_overall_score'] = $countOverallScores > 0 ? $sumOverallScores / $countOverallScores : 0;

        return $totals;
    };

    // Calculate totals for each quarter
    $januaryToJuneTotals = $calculateTotals($januaryToJuneExpectationsBreakdown);
    $julyToDecemberTotals = $calculateTotals($julyToDecemberExpectationsBreakdown);

    // Custom field labels
    $fieldLabels = [
        'expectations_0' => 'Responsiveness',
        'expectations_1' => 'Reliability',
        'expectations_2' => 'Access and Facilities',
        'expectations_3' => 'Communication',
        'expectations_4' => 'Costs',
        'expectations_5' => 'Integrity',
        'expectations_6' => 'Assurance',
        'expectations_7' => 'Outcome',
        'expectations_8' => 'Overall'
    ];

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

    // H1: January to June
    $h1AgeBreakdown = $this->getClientAgeBreakdown(1, 6, $currentYear);
    $h1MunicipalityBreakdown = $this->getClientMunicipalityBreakdown(1, 6, $currentYear);
    $h1CategoryBreakdown = $this->getClientCategoryBreakdown(1, 6, $currentYear);

    // H2: July to December
    $h2AgeBreakdown = $this->getClientAgeBreakdown(7, 12, $currentYear);
    $h2MunicipalityBreakdown = $this->getClientMunicipalityBreakdown(7, 12, $currentYear);
    $h2CategoryBreakdown = $this->getClientCategoryBreakdown(7, 12, $currentYear);


    
        return view('admin.reports_bi_quarterly', compact(
            'januaryToJuneData',
            'julyToDecember',
            'januaryToJuneResponses',
            'julyToDecemberResponses',
            'januaryToJuneExpectationsBreakdown',
            'julyToDecemberExpectationsBreakdown',
            'januaryToJuneTotals',
            'julyToDecemberTotals',
            'fieldLabels',
            'serviceAveragesJanToJune',
            'serviceAveragesJulToDec',  
            'yourOptions',
            'clientSexBreakdownJanToJune',
        'clientSexBreakdownJulToDec',
        'h1AgeBreakdown',
        'h1MunicipalityBreakdown',
        'h1CategoryBreakdown',
        'h2AgeBreakdown',
        'h2MunicipalityBreakdown',
        'h2CategoryBreakdown'
            
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

    // Compute client sex breakdown for both periods using month ranges
    $clientSexBreakdownJanuaryToMarch = $this->getClientSexBreakdown(1, 3, $currentYear);
    $clientSexBreakdownAprilToJune = $this->getClientSexBreakdown(4, 6, $currentYear);
    $clientSexBreakdownJulyToSeptember = $this->getClientSexBreakdown(7, 10, $currentYear);
    $clientSexBreakdownOctoberToDecember = $this->getClientSexBreakdown(11, 12, $currentYear);

    // Fetch data for each quarter
    $januaryToMarchData = $this->fetchDataByPeriod(1, 3, $currentYear);
    $aprilToJuneData = $this->fetchDataByPeriod(4, 6, $currentYear);
    $julyToSeptemberData = $this->fetchDataByPeriod(7, 9, $currentYear);
    $octoberToDecemberData = $this->fetchDataByPeriod(10, 12, $currentYear);

    // Compute responses for each quarter
    $januaryToMarchResponses = $this->computeCcResponses(1, 3, $currentYear, $januaryToMarchData['totalForms']);
    $aprilToJuneResponses = $this->computeCcResponses(4, 6, $currentYear, $aprilToJuneData['totalForms']);
    $julyToSeptemberResponses = $this->computeCcResponses(7, 9, $currentYear, $julyToSeptemberData['totalForms']);
    $octoberToDecemberResponses = $this->computeCcResponses(10, 12, $currentYear, $octoberToDecemberData['totalForms']);

    // Compute averages per quarter
    $serviceAveragesQ1 = $this->computeServiceAverages(1, 3, $currentYear); // Q1: Jan to Mar
    $serviceAveragesQ2 = $this->computeServiceAverages(4, 6, $currentYear); // Q2: Apr to Jun
    $serviceAveragesQ3 = $this->computeServiceAverages(7, 9, $currentYear); // Q3: Jul to Sep
    $serviceAveragesQ4 = $this->computeServiceAverages(10, 12, $currentYear); // Q4: Oct to Dec


    // Compute expectations breakdown for each quarter
    $januaryToMarchExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        1,
        3
    );
    $aprilToJuneExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        4,
        6
    );
    $julyToSeptemberExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        7,
        9
    );
    $octoberToDecemberExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        10,
        12
    );

    $calculateTotals = function ($breakdown) {
        $totals = [
            'strongly_agree' => 0,
            'agree' => 0,
            'neither' => 0,
            'disagree' => 0,
            'strongly_disagree' => 0,
            'na' => 0,
            'total_responses' => 0,
            'average_overall_score' => 0,
        ];
    
        $sumOverallScores = 0;
        $countOverallScores = 0;
    
        foreach ($breakdown as $fieldBreakdown) {
            $totals['strongly_agree'] += $fieldBreakdown['strongly-agree']['count'];
            $totals['agree'] += $fieldBreakdown['agree']['count'];
            $totals['neither'] += $fieldBreakdown['neither']['count'];
            $totals['disagree'] += $fieldBreakdown['disagree']['count'];
            $totals['strongly_disagree'] += $fieldBreakdown['strongly-disagree']['count'];
            $totals['na'] += $fieldBreakdown['na']['count'];
            $totals['total_responses'] += $fieldBreakdown['total_responses'];
    
            $totalRelevantResponses = $fieldBreakdown['total_responses'] - $fieldBreakdown['na']['count'];
            $agreeResponses = $fieldBreakdown['strongly-agree']['count'] + $fieldBreakdown['agree']['count'];
            $overallScore = $totalRelevantResponses > 0 ? ($agreeResponses / $totalRelevantResponses) * 100 : 0;
    
            $sumOverallScores += $overallScore;
            $countOverallScores++;
        }
    
        $totals['average_overall_score'] = $countOverallScores > 0 ? $sumOverallScores / $countOverallScores : 0;
    
        return $totals;
    };

    // Calculate totals for each quarter
    $januaryToMarchTotals = $calculateTotals($januaryToMarchExpectationsBreakdown);
    $aprilToJuneTotals = $calculateTotals($aprilToJuneExpectationsBreakdown);
    $julyToSeptemberTotals = $calculateTotals($julyToSeptemberExpectationsBreakdown);
    $octoberToDecemberTotals = $calculateTotals($octoberToDecemberExpectationsBreakdown);

    // Custom field labels
    $fieldLabels = [
        'expectations_0' => 'Responsiveness',
        'expectations_1' => 'Reliability',
        'expectations_2' => 'Access and Facilities',
        'expectations_3' => 'Communication',
        'expectations_4' => 'Costs',
        'expectations_5' => 'Integrity',
        'expectations_6' => 'Assurance',
        'expectations_7' => 'Outcome',
        'expectations_8' => 'Overall'
    ];

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

    // Q1: January to March
    $q1AgeBreakdown = $this->getClientAgeBreakdown(1, 3, $currentYear);
    $q1MunicipalityBreakdown = $this->getClientMunicipalityBreakdown(1, 3, $currentYear);
    $q1CategoryBreakdown = $this->getClientCategoryBreakdown(1, 3, $currentYear);

    // Q2: April to June
    $q2AgeBreakdown = $this->getClientAgeBreakdown(4, 6, $currentYear);
    $q2MunicipalityBreakdown = $this->getClientMunicipalityBreakdown(4, 6, $currentYear);
    $q2CategoryBreakdown = $this->getClientCategoryBreakdown(4, 6, $currentYear);

    // Q3: July to September
    $q3AgeBreakdown = $this->getClientAgeBreakdown(7, 9, $currentYear);
    $q3MunicipalityBreakdown = $this->getClientMunicipalityBreakdown(7, 9, $currentYear);
    $q3CategoryBreakdown = $this->getClientCategoryBreakdown(7, 9, $currentYear);

    // Q4: October to December
    $q4AgeBreakdown = $this->getClientAgeBreakdown(10, 12, $currentYear);
    $q4MunicipalityBreakdown = $this->getClientMunicipalityBreakdown(10, 12, $currentYear);
    $q4CategoryBreakdown = $this->getClientCategoryBreakdown(10, 12, $currentYear);

    // Return the view with data for each quarter and their totals
    return view('admin.reports_quarterly', compact(
        'januaryToMarchData',
        'aprilToJuneData',
        'julyToSeptemberData',
        'octoberToDecemberData',
        'januaryToMarchResponses',
        'aprilToJuneResponses',
        'julyToSeptemberResponses',
        'octoberToDecemberResponses',
        'januaryToMarchExpectationsBreakdown',
        'aprilToJuneExpectationsBreakdown',
        'julyToSeptemberExpectationsBreakdown',
        'octoberToDecemberExpectationsBreakdown',
        'januaryToMarchTotals',
        'aprilToJuneTotals',
        'julyToSeptemberTotals',
        'octoberToDecemberTotals',
        'fieldLabels',
        'serviceAveragesQ1',
        'serviceAveragesQ2',
        'serviceAveragesQ3',
        'serviceAveragesQ4',
        'yourOptions',
        'clientSexBreakdownJanuaryToMarch',
        'clientSexBreakdownAprilToJune',
        'clientSexBreakdownJulyToSeptember',
        'clientSexBreakdownOctoberToDecember',
        'q1AgeBreakdown',
        'q1MunicipalityBreakdown',
        'q1CategoryBreakdown',
        'q2AgeBreakdown',
        'q2MunicipalityBreakdown',
        'q2CategoryBreakdown',
        'q3AgeBreakdown',
        'q3MunicipalityBreakdown',
        'q3CategoryBreakdown',
        'q4AgeBreakdown',
        'q4MunicipalityBreakdown',
        'q4CategoryBreakdown'
    ));
}


// private function aggregateExpectations($expectationsFields, $year, $startMonth, $endMonth)
// {
//     $responseOptions = ['strongly-agree', 'agree', 'neither', 'disagree', 'strongly-disagree', 'na'];

//     $expectationsBreakdown = [];

//     foreach ($expectationsFields as $field) {
//         $breakdown = [];
//         $totalResponses = 0;

//         foreach ($responseOptions as $option) {
//             $count = Form::whereYear('date', $year)
//                 ->whereMonth('date', '>=', $startMonth)
//                 ->whereMonth('date', '<=', $endMonth)
//                 ->where($field, $option)
//                 ->count();
//             $breakdown[$option] = [
//                 'count' => $count,
//                 'percentage' => 0,  
//             ];
//             $totalResponses += $count;
//         }

       
//         foreach ($breakdown as $option => &$data) {
//             $data['percentage'] = ($totalResponses > 0) ? ($data['count'] / $totalResponses) * 100 : 0;
//         }

        
//         $expectationsBreakdown[$field] = $breakdown;
//         $expectationsBreakdown[$field]['total_responses'] = $totalResponses;
//         $expectationsBreakdown[$field]['overall_percentage'] = ($totalResponses > 0) ? 100 : 0;
//     }

//     return $expectationsBreakdown;
// }


private function aggregateExpectations($expectationsFields, $year, $startMonth, $endMonth)
{
    $responseOptions = ['strongly-agree', 'agree', 'neither', 'disagree', 'strongly-disagree', 'na'];

    $expectationsBreakdown = [];

    foreach ($expectationsFields as $field) {
        $breakdown = [];
        $totalResponses = 0;

        foreach ($responseOptions as $option) {
            $count = Form::whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->where($field, $option)
                ->count();
            $breakdown[$option] = [
                'count' => $count,
                'percentage' => 0, // Placeholder for percentage calculation
            ];
            $totalResponses += $count;
        }

        // Calculate percentages
        foreach ($breakdown as $option => &$data) {
            $data['percentage'] = ($totalResponses > 0) ? ($data['count'] / $totalResponses) * 100 : 0;
        }

        // Calculate overall score
        $totalRelevantResponses = $totalResponses - ($breakdown['na']['count'] ?? 0);
        $strongAgreeResponses = ($breakdown['strongly-agree']['count'] ?? 0) + ($breakdown['agree']['count'] ?? 0);

        $overallScore = $totalRelevantResponses > 0
            ? ($strongAgreeResponses / $totalRelevantResponses) * 100
            : 0;

        // Store total responses and overall score for each field
        $expectationsBreakdown[$field] = $breakdown;
        $expectationsBreakdown[$field]['total_responses'] = $totalResponses;
        $expectationsBreakdown[$field]['overall_score'] = $overallScore; // Store the overall score
    }

    return $expectationsBreakdown;
}




    private function computeServiceAverages($startMonth, $endMonth, $year)
    {
        $services = Services::all();
        $expectationsFields = [
            'expectations_0', 'expectations_1', 'expectations_2',
            'expectations_3', 'expectations_4', 'expectations_5',
            'expectations_6', 'expectations_7', 'expectations_8'
        ];
    
        $serviceAverages = [];
    
        foreach ($services as $service) {
            $averages = [];
            $overallSum = 0;
            $overallCount = 0;
    
            // Fetch total respondents for the service
            $totalRespondents = Form::where('service_id', $service->id)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->distinct('id') // Use a unique respondent identifier column
                ->count();
    
            foreach ($expectationsFields as $field) {
                // Sum of responses for this expectation field
                $sum = Form::where('service_id', $service->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', '>=', $startMonth)
                    ->whereMonth('date', '<=', $endMonth)
                    ->sum($field);
    
                // Count of responses for this expectation field
                $count = Form::where('service_id', $service->id)
                    ->whereYear('date', $year)
                    ->whereMonth('date', '>=', $startMonth)
                    ->whereMonth('date', '<=', $endMonth)
                    ->count();
    
                // Calculate the average for this expectation field
                $average = $count > 0 ? $sum / $count : 0;
    
                $averages[$field] = $average;
                $overallSum += $sum;
                $overallCount += $count;
            }
    
            // Calculate Overall Arithmetic Weighted Mean (AWM)
            $overallAWM = $overallCount > 0 ? ($overallSum / $overallCount) * 20 : 0;
    
            // Determine the descriptive rating
            $descriptiveRating = $this->getDescriptiveRating($overallAWM);
    
            $serviceAverages[] = [
                'service_name' => $service->services_name,
                'service_type' => $service->service_type, // Include service type
                'averages' => $averages,
                'overall_awm' => $overallAWM,
                'descriptive_rating' => $descriptiveRating,
                'total_respondents' => $totalRespondents
            ];
        }
    
        return $serviceAverages;
    }
    
    private function getDescriptiveRating($score)
    {
        if ($score < 60) {
            return 'Poor';
        } elseif ($score >= 60 && $score < 80) {
            return 'Fair';
        } elseif ($score >= 80 && $score < 90) {
            return 'Satisfactory';
        } elseif ($score >= 90 && $score < 95) {
            return 'Very Satisfactory';
        } elseif ($score >= 95) {
            return 'Outstanding';
        }
    
        return 'Not Rated';
    }

    
    public function printQuarterReport($quarter)
    {
        $currentYear = Carbon::now()->year;
    
        // Define the month ranges for each quarter, including additional quarters
        $quarters = [
            'Q1' => [1, 3],
            'Q2' => [4, 6],
            'Q3' => [7, 9],
            'Q4' => [10, 12],
            'H1' => [1, 6],
            'H2' => [7, 12],
            'Annually' => [1, 12],
        ];
    
        if (!isset($quarters[$quarter])) {
            abort(404, "Invalid quarter specified.");
        }
    
        [$startMonth, $endMonth] = $quarters[$quarter];
    
        // Fetch data for the specified quarter
        $quarterData = $this->fetchDataByPeriod($startMonth, $endMonth, $currentYear);
    
        // Calculate total forms for the given period
        $totalForms = Form::whereYear('date', $currentYear)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->count();
    
        if ($totalForms === 0) {
            // If no data, return a view with "No Data Available"
            return view('admin.no_data', ['message' => 'Try Again if there is Data Available.']);
        }
    
        // Compute additional breakdowns
        $ageBreakdown = $this->getClientAgeBreakdown($startMonth, $endMonth, $currentYear);
        $municipalityBreakdown = $this->getClientMunicipalityBreakdown($startMonth, $endMonth, $currentYear);
        $clientCategoryBreakdown = $this->getClientCategoryBreakdown($startMonth, $endMonth, $currentYear);
        $sexBreakdown = $this->getClientSexBreakdown($startMonth, $endMonth, $currentYear);
    
        $responses = $this->computeCcResponses($startMonth, $endMonth, $currentYear, $totalForms);
        $quarterData['cc1'] = $responses['cc1'];
        $quarterData['cc2'] = $responses['cc2'];
        $quarterData['cc3'] = $responses['cc3'];
    
        $quarterExpectations = $this->aggregateExpectations(
            [
                'expectations_0', 'expectations_1', 'expectations_2',
                'expectations_3', 'expectations_4', 'expectations_5',
                'expectations_6', 'expectations_7', 'expectations_8'
            ],
            $currentYear,
            $startMonth,
            $endMonth
        );
    
        // Calculate totals for Client Overall Satisfaction
        $quarterTotals = [
            'strongly_agree' => 0,
            'agree' => 0,
            'neither' => 0,
            'disagree' => 0,
            'strongly_disagree' => 0,
            'na' => 0,
            'total_responses' => 0,
            'average_overall_score' => 0,
        ];
    
        foreach ($quarterExpectations as $fieldBreakdown) {
            $quarterTotals['strongly_agree'] += $fieldBreakdown['strongly-agree']['count'];
            $quarterTotals['agree'] += $fieldBreakdown['agree']['count'];
            $quarterTotals['neither'] += $fieldBreakdown['neither']['count'];
            $quarterTotals['disagree'] += $fieldBreakdown['disagree']['count'];
            $quarterTotals['strongly_disagree'] += $fieldBreakdown['strongly-disagree']['count'];
            $quarterTotals['na'] += $fieldBreakdown['na']['count'];
            $quarterTotals['total_responses'] += $fieldBreakdown['total_responses'];
        }
    
        $quarterTotals['average_overall_score'] = $quarterTotals['total_responses'] > 0
            ? (($quarterTotals['strongly_agree'] + $quarterTotals['agree']) / ($quarterTotals['total_responses'] - $quarterTotals['na'])) * 100
            : 0;
    
        // Fetch service averages for this quarter
        $serviceAverages = $this->computeServiceAverages($startMonth, $endMonth, $currentYear);
    
        // Separate external and internal services
        $externalServices = array_filter($serviceAverages, fn($service) => $service['service_type'] === 'external');
        $internalServices = array_filter($serviceAverages, fn($service) => $service['service_type'] === 'internal');
    
        // Prepare field labels for expectations
        $fieldLabels = [
            'expectations_0' => 'Responsiveness',
            'expectations_1' => 'Reliability',
            'expectations_2' => 'Access and Facilities',
            'expectations_3' => 'Communication',
            'expectations_4' => 'Costs',
            'expectations_5' => 'Integrity',
            'expectations_6' => 'Assurance',
            'expectations_7' => 'Outcome',
            'expectations_8' => 'Overall',
        ];
    
        // Generate PDF with the collected data
        $pdf = Pdf::loadView('admin.report_template', [
            'quarter' => $quarter,
            'quarterData' => $quarterData,
            'responses' => $responses,
            'quarterExpectations' => $quarterExpectations,
            'quarterTotals' => $quarterTotals,
            'ageBreakdown' => $ageBreakdown,
            'municipalityBreakdown' => $municipalityBreakdown,
            'clientCategoryBreakdown' => $clientCategoryBreakdown,
            'sexBreakdown' => $sexBreakdown,
            'fieldLabels' => $fieldLabels,
            'serviceAverages' => $serviceAverages,
            'externalServices' => $externalServices,
            'internalServices' => $internalServices,
            'totalForms' => $totalForms,
        ]);
    
        // Stream or download the PDF
        return $pdf->stream("{$quarter}_Report.pdf");
    }
    


/**
 * Helper function to calculate totals for external, internal, and overall counts.
 */
private function calculateTotals($data)
{
    $totals = [
        'external' => 0,
        'internal' => 0,
        'total' => 0,
    ];

    foreach ($data as $item) {
        $totals['external'] += $item['external']['count'];
        $totals['internal'] += $item['internal']['count'];
        $totals['total'] += $item['total']['count'];
    }

    return $totals;
}


public function pastReports(Request $request)
{
    $selectedYear = $request->input('year', now()->year);
    $selectedPeriod = $request->input('period', 'annual');

    // Define periods
    $periods = [
        'Q1' => [1, 3],
        'Q2' => [4, 6],
        'Q3' => [7, 9],
        'Q4' => [10, 12],
        'H1' => [1, 6],
        'H2' => [7, 12],
        'annual' => [1, 12],
    ];

    if (!isset($periods[$selectedPeriod])) {
        abort(404, 'Invalid period selected.');
    }

    [$startMonth, $endMonth] = $periods[$selectedPeriod];

    // Fetch the data for the selected period
    $data = $this->fetchDataByPeriod($startMonth, $endMonth, $selectedYear);

    if ($data['totalForms'] === 0) {
        return view('admin.no_data', ['message' => 'No data available for the selected period.']);
    }

    // Citizen's Charter Responses
    $annualResponses = $this->computeCcResponses($startMonth, $endMonth, $selectedYear, $data['totalForms']);

    // Compute breakdowns
    $ageBreakdown = $this->getClientAgeBreakdown($startMonth, $endMonth, $selectedYear);
    $municipalityBreakdown = $this->getClientMunicipalityBreakdown($startMonth, $endMonth, $selectedYear);
    $clientCategoryBreakdown = $this->getClientCategoryBreakdown($startMonth, $endMonth, $selectedYear);
    $sexBreakdown = $this->getClientSexBreakdown($startMonth, $endMonth, $selectedYear);

    // Compute breakdown for expectations (replace 'expectations' fields with actual fields)
    $expectationsFields = [
        'expectations_0', 'expectations_1', 'expectations_2',
        'expectations_3', 'expectations_4', 'expectations_5',
        'expectations_6', 'expectations_7', 'expectations_8'
    ];
    $breakdown = $this->aggregateExpectations($expectationsFields, $selectedYear, $startMonth, $endMonth);

    // Totals Calculation
    $totals = [
        'strongly_agree' => 0,
        'agree' => 0,
        'neither' => 0,
        'disagree' => 0,
        'strongly_disagree' => 0,
        'na' => 0,
        'total_responses' => 0,
        'average_overall_score' => 0,
    ];

    foreach ($breakdown as $fieldBreakdown) {
        $totals['strongly_agree'] += $fieldBreakdown['strongly-agree']['count'];
        $totals['agree'] += $fieldBreakdown['agree']['count'];
        $totals['neither'] += $fieldBreakdown['neither']['count'];
        $totals['disagree'] += $fieldBreakdown['disagree']['count'];
        $totals['strongly_disagree'] += $fieldBreakdown['strongly-disagree']['count'];
        $totals['na'] += $fieldBreakdown['na']['count'];
        $totals['total_responses'] += $fieldBreakdown['total_responses'];
    }

    $totals['average_overall_score'] = $totals['total_responses'] > 0
        ? (($totals['strongly_agree'] + $totals['agree']) / $totals['total_responses']) * 100
        : 0;

    // Service Averages
    $services = $this->computeServiceAverages($startMonth, $endMonth, $selectedYear);

    // Option Descriptions
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

    $fieldLabels = [
        'expectations_0' => 'Responsiveness',
        'expectations_1' => 'Reliability',
        'expectations_2' => 'Access and Facilities',
        'expectations_3' => 'Communication',
        'expectations_4' => 'Costs',
        'expectations_5' => 'Integrity',
        'expectations_6' => 'Assurance',
        'expectations_7' => 'Outcome',
        'expectations_8' => 'Overall'
    ];
    

    // Return the view with data
    return view('admin.past_reports', compact(
        'data',
        'selectedYear',
        'selectedPeriod',
        'annualResponses',
        'totals',
        'services',
        'yourOptions',
        'breakdown',
        'fieldLabels',
        'ageBreakdown',
        'municipalityBreakdown',
        'clientCategoryBreakdown',
        'sexBreakdown'
    ));
}

public function determineCustomerType($category)
{
    // Define internal and external categories
    $internalCategories = ['faculty', 'non teaching'];
    $externalCategories = ['student', 'alumni', 'parents', 'Community Member', 'industry Partner', 'Supplier', 'Regulatory', 'others'];

    // Check if the category is in the internal categories array
    if (in_array(strtolower($category), $internalCategories)) {
        return 'Internal Customer';
    }

    // Check if the category is in the external categories array
    if (in_array(strtolower($category), $externalCategories)) {
        return 'External Customer';
    }

    // Default return if category is unknown
    return 'Unknown Customer Type';
}

public function getClientSexBreakdown($startMonth, $endMonth, $year)
{
    // Fetch forms within the given month range
    $forms = Form::whereYear('date', $year)
        ->whereMonth('date', '>=', $startMonth)
        ->whereMonth('date', '<=', $endMonth)
        ->get();

    $sexBreakdown = [
        'Male' => ['Internal' => 0, 'External' => 0],
        'Female' => ['Internal' => 0, 'External' => 0],
        'Other' => ['Internal' => 0, 'External' => 0],
    ];

    // Match the enum values exactly
    $internalCategories = ['faculty', 'Non-teaching staff']; // Internal categories
    $externalCategories = [
        'Student',
        'Alumni',
        'parents',
        'Community_member',
        'industry_partner',
        'supplier',
        'Regulatory',
        'Others'
    ]; // External categories

    foreach ($forms as $form) {
        if (!isset($form->sex) || !isset($form->client_category)) {
            continue; // Skip rows without these fields
        }

        // Normalize and trim values
        $sex = ucfirst(strtolower(trim($form->sex)));
        $clientCategory = trim($form->client_category);

        // Classify the client into Internal or External
        $clientType = in_array($clientCategory, $internalCategories) ? 'Internal' : (in_array($clientCategory, $externalCategories) ? 'External' : null);

        if (!$clientType || !isset($sexBreakdown[$sex])) {
            continue; // Skip if client type or sex is invalid
        }

        // Increment the appropriate counter
        $sexBreakdown[$sex][$clientType]++;
    }

    foreach ($sexBreakdown as $sex => &$counts) {
        $totalClients = $counts['Internal'] + $counts['External'];
        $counts['InternalPercentage'] = $totalClients > 0 ? ($counts['Internal'] / $totalClients) * 100 : 0;
        $counts['ExternalPercentage'] = $totalClients > 0 ? ($counts['External'] / $totalClients) * 100 : 0;
    }

    return $sexBreakdown;
}


public function getClientAgeBreakdown($startMonth, $endMonth, $year)
{
    // Define age ranges
    $ageRanges = [
        '19 or lower' => [0, 19],
        '20-34' => [20, 34],
        '35-49' => [35, 49],
        '50-64' => [50, 64],
        '65 or higher' => [65, 150],
    ];

    // Define internal and external categories
    $internalCategories = ['faculty', 'Non-teaching staff']; // Internal categories
    $externalCategories = [
        'Student',
        'Alumni',
        'parents',
        'Community_member',
        'industry_partner',
        'supplier',
        'Regulatory',
        'Others'
    ]; // External categories

    $ageBreakdown = [];

    foreach ($ageRanges as $range => [$min, $max]) {
        // Count external clients in this age range
        $externalCount = Form::whereBetween('age', [$min, $max])
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('client_category', $externalCategories) // Directly use whereIn
            ->count();

        // Count internal clients in this age range
        $internalCount = Form::whereBetween('age', [$min, $max])
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('client_category', $internalCategories) // Directly use whereIn
            ->count();

        // Total for this age range
        $totalCount = $externalCount + $internalCount;

        // Calculate percentages
        $totalForms = Form::whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->count();

        $ageBreakdown[$range] = [
            'external' => [
                'count' => $externalCount,
                'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0,
            ],
            'internal' => [
                'count' => $internalCount,
                'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0,
            ],
            'total' => [
                'count' => $totalCount,
                'percentage' => ($totalForms > 0) ? ($totalCount / $totalForms) * 100 : 0,
            ],
        ];
    }

    return $ageBreakdown;
}

public function getClientMunicipalityBreakdown($startMonth, $endMonth, $year)
{
    // Define municipalities
    $municipalities = [
        'Agno', 'Aguilar', 'Alaminos', 'Alcala', 'Anda', 'Bani', 'Binmaley', 'Bolinao',
        'Burgos', 'Dagupan', 'Dasol', 'Infanta', 'Lingayen', 'Mabini', 'Mangaldan',
        'Mangatarem', 'Rosales', 'Sta. Barbara', 'Sta. Maria', 'Sual', 'Others'
    ];

    // Define internal and external categories
    $internalCategories = ['faculty', 'Non-teaching staff']; // Internal categories
    $externalCategories = [
        'Student', 'Alumni', 'parents', 'Community_member', 'industry_partner',
        'supplier', 'Regulatory', 'Others'
    ]; // External categories

    $municipalityBreakdown = [];

    foreach ($municipalities as $municipality) {
        // Count external clients from this municipality
        $externalCount = Form::where('Municipality', $municipality)
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('client_category', $externalCategories)
            ->count();

        // Count internal clients from this municipality
        $internalCount = Form::where('Municipality', $municipality)
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('client_category', $internalCategories)
            ->count();

        // Total for this municipality
        $totalCount = $externalCount + $internalCount;

        // Calculate percentages
        $totalForms = Form::whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->count();

        $municipalityBreakdown[$municipality] = [
            'external' => [
                'count' => $externalCount,
                'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0,
            ],
            'internal' => [
                'count' => $internalCount,
                'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0,
            ],
            'total' => [
                'count' => $totalCount,
                'percentage' => ($totalForms > 0) ? ($totalCount / $totalForms) * 100 : 0,
            ],
        ];
    }

    return $municipalityBreakdown;
}

public function getClientCategoryBreakdown($startMonth, $endMonth, $year)
{
    // Define client categories
    $clientCategories = [
        'Student', 'Faculty', 'Non-teaching staff', 'Alumni', 'Parents',
        'Community_member', 'Industry_partner', 'Supplier', 'Regulatory', 'Others'
    ];

    // Define internal and external categories
    $internalCategories = ['faculty', 'Non-teaching staff']; // Internal categories
    $externalCategories = [
        'Student', 'Alumni', 'parents', 'Community_member', 'industry_partner',
        'supplier', 'Regulatory', 'Others'
    ]; // External categories

    $categoryBreakdown = [];

    foreach ($clientCategories as $category) {
        // Count external clients in this category
        $externalCount = Form::where('client_category', $category)
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('client_category', $externalCategories)
            ->count();

        // Count internal clients in this category
        $internalCount = Form::where('client_category', $category)
            ->whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('client_category', $internalCategories)
            ->count();

        // Total for this category
        $totalCount = $externalCount + $internalCount;

        // Calculate percentages
        $totalForms = Form::whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->count();

        $categoryBreakdown[$category] = [
            'external' => [
                'count' => $externalCount,
                'percentage' => ($totalForms > 0) ? ($externalCount / $totalForms) * 100 : 0,
            ],
            'internal' => [
                'count' => $internalCount,
                'percentage' => ($totalForms > 0) ? ($internalCount / $totalForms) * 100 : 0,
            ],
            'total' => [
                'count' => $totalCount,
                'percentage' => ($totalForms > 0) ? ($totalCount / $totalForms) * 100 : 0,
            ],
        ];
    }

    return $categoryBreakdown;
}


}

    



