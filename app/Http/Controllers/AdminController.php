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
    
        // Return the view with annual data
        return view('admin.reports', compact(
            'annualData',
            'annualResponses',
            'yourOptions',
            'expectationsBreakdown',
            'fieldLabels',
            'totals',
            'serviceAveragesAnnual' // Include annual averages in the view
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
        $currentYear = Carbon::now()->year;
        $januaryToAprilData = $this->fetchDataByPeriod(1, 4, $currentYear);
        $mayToAugustData = $this->fetchDataByPeriod(5, 8, $currentYear);
        $septemberToDecember = $this->fetchDataByPeriod(9, 12, $currentYear);

        $januaryToAprilResponses = $this->computeCcResponses(1, 4, $currentYear, $januaryToAprilData['totalForms']);
        $mayToAugustResponses = $this->computeCcResponses(5, 8, $currentYear, $mayToAugustData['totalForms']);
        $septemberToDecemberResponses = $this->computeCcResponses(9, 12, $currentYear, $septemberToDecember['totalForms']);

        // Compute averages per service for January to April
            $serviceAveragesJanToApr = $this->computeServiceAverages(1, 4, $currentYear);

// Compute averages per service for May to August
        $serviceAveragesMayToAug = $this->computeServiceAverages(5, 8, $currentYear);

// Compute averages per service for September to December
        $serviceAveragesSepToDec = $this->computeServiceAverages(9, 12, $currentYear); ////remove it if the table is wrong

        // Compute expectations breakdown for each bi-quarter
    $januaryToAprilExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        1,
        4
    );
    $mayToAugustExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        5,
        8
    );
    $septemberToDecemberExpectationsBreakdown = $this->aggregateExpectations(
        ['expectations_0', 'expectations_1', 'expectations_2', 'expectations_3', 'expectations_4', 'expectations_5', 'expectations_6', 'expectations_7', 'expectations_8'],
        $currentYear,
        9,
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
    $januaryToAprilTotals = $calculateTotals($januaryToAprilExpectationsBreakdown);
    $mayToAugustTotals = $calculateTotals($mayToAugustExpectationsBreakdown);
    $septemberToDecemberTotals = $calculateTotals($septemberToDecemberExpectationsBreakdown);

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

    
        return view('admin.reports_bi_quarterly', compact(
            'januaryToAprilData',
            'mayToAugustData',
            'septemberToDecember',
            'januaryToAprilResponses',
            'mayToAugustResponses',
            'septemberToDecemberResponses',
            'januaryToAprilExpectationsBreakdown',
            'mayToAugustExpectationsBreakdown',
            'septemberToDecemberExpectationsBreakdown',
            'januaryToAprilTotals',
            'mayToAugustTotals',
            'septemberToDecemberTotals',
            'fieldLabels',
            'serviceAveragesJanToApr',
            'serviceAveragesMayToAug',
            'serviceAveragesSepToDec',  
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
        'yourOptions'
    ));
}


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
                'percentage' => 0,  // Placeholder for percentage calculation
            ];
            $totalResponses += $count;
        }

        // Calculate percentages
        foreach ($breakdown as $option => &$data) {
            $data['percentage'] = ($totalResponses > 0) ? ($data['count'] / $totalResponses) * 100 : 0;
        }

        // Store total responses and overall percentage for each field
        $expectationsBreakdown[$field] = $breakdown;
        $expectationsBreakdown[$field]['total_responses'] = $totalResponses;
        $expectationsBreakdown[$field]['overall_percentage'] = ($totalResponses > 0) ? 100 : 0;
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
    

}

    




