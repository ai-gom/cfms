<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Services;
use App\Models\Form;
use Carbon\Carbon;

class UserController extends Controller
{
    public function dashboard()
    {
        $currentYear = Carbon::now()->year;

        // Get the logged-in user and their assigned services
        $user = Auth::user();
        $services = $user->services;

        // Handle users with no assigned services
        if ($services->isEmpty()) {
            return view('user.dashboard', [
                'serviceName' => 'No Service Assigned',
                'monthlySubmissions' => [],
                'quarterlySubmissions' => [],
                'biAnnualSubmissions' => [],
                'annualSubmissions' => 0,
                'sexBreakdown' => [],
                'ageBreakdown' => [],
                'municipalityBreakdown' => [],
                'categoryBreakdown' => [],
                'internalFormsCount' => 0,
                'externalFormsCount' => 0,
                'totalFormsCount' => 0,
            ]);
        }

        // Get the first assigned service
        $service = $services->first();
        $serviceName = $service->services_name;

        // Monthly submissions for the current service
        $monthlySubmissions = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySubmissions[] = Form::whereYear('date', $currentYear)
                ->whereMonth('date', $i)
                ->where('service_id', $service->id)
                ->count();
        }

        // Quarterly, Bi-annual, and Annual data
        $quarterlySubmissions = [
            array_sum(array_slice($monthlySubmissions, 0, 3)),
            array_sum(array_slice($monthlySubmissions, 3, 3)),
            array_sum(array_slice($monthlySubmissions, 6, 3)),
            array_sum(array_slice($monthlySubmissions, 9, 3)),
        ];
        $biAnnualSubmissions = [
            array_sum(array_slice($monthlySubmissions, 0, 6)),
            array_sum(array_slice($monthlySubmissions, 6, 6)),
        ];
        $annualSubmissions = array_sum($monthlySubmissions);

        // Fetch breakdowns for only forms related to the current user's services
        $serviceIds = $services->pluck('id'); // All services assigned to the user

        $sexBreakdown = $this->getClientSexBreakdown(1, 12, $currentYear, $serviceIds);
        $ageBreakdown = $this->getClientAgeBreakdown(1, 12, $currentYear, $serviceIds);
        $municipalityBreakdown = $this->getClientMunicipalityBreakdown(1, 12, $currentYear, $serviceIds);
        $categoryBreakdown = $this->getClientCategoryBreakdown(1, 12, $currentYear, $serviceIds);

        // Get internal, external, and total forms count for the logged-in user's assigned services
        $internalFormsCount = $this->getInternalFormsCount($serviceIds);
        $externalFormsCount = $this->getExternalFormsCount($serviceIds);
        $totalFormsCount = $this->getTotalFormsCount($serviceIds);

        return view('user.dashboard', compact(
            'serviceName',
            'monthlySubmissions',
            'quarterlySubmissions',
            'biAnnualSubmissions',
            'annualSubmissions',
            'sexBreakdown',
            'ageBreakdown',
            'municipalityBreakdown',
            'categoryBreakdown',
            'internalFormsCount',
            'externalFormsCount',
            'totalFormsCount'
        ));
    }

    // Helper methods for data breakdown
    public function getClientSexBreakdown($startMonth, $endMonth, $year, $serviceIds)
    {
        $forms = Form::whereYear('date', $year)
            ->whereMonth('date', '>=', $startMonth)
            ->whereMonth('date', '<=', $endMonth)
            ->whereIn('service_id', $serviceIds)
            ->get();

        $sexBreakdown = [
            'Male' => ['Internal' => 0, 'External' => 0],
            'Female' => ['Internal' => 0, 'External' => 0],
            'Other' => ['Internal' => 0, 'External' => 0],
        ];

        $internalCategories = ['faculty', 'Non-teaching staff'];
        $externalCategories = [
            'Student', 'Alumni', 'parents', 'Community_member',
            'industry_partner', 'supplier', 'Regulatory', 'Others',
        ];

        foreach ($forms as $form) {
            if (!isset($form->sex) || !isset($form->client_category)) {
                continue;
            }

            $sex = ucfirst(strtolower(trim($form->sex)));
            $clientCategory = trim($form->client_category);
            $clientType = in_array($clientCategory, $internalCategories) ? 'Internal' : (in_array($clientCategory, $externalCategories) ? 'External' : null);

            if ($clientType && isset($sexBreakdown[$sex])) {
                $sexBreakdown[$sex][$clientType]++;
            }
        }

        foreach ($sexBreakdown as $sex => &$counts) {
            $totalClients = $counts['Internal'] + $counts['External'];
            $counts['InternalPercentage'] = $totalClients > 0 ? ($counts['Internal'] / $totalClients) * 100 : 0;
            $counts['ExternalPercentage'] = $totalClients > 0 ? ($counts['External'] / $totalClients) * 100 : 0;
        }

        return $sexBreakdown;
    }

    public function getClientAgeBreakdown($startMonth, $endMonth, $year, $serviceIds)
    {
        $ageRanges = [
            '19 or lower' => [0, 19],
            '20-34' => [20, 34],
            '35-49' => [35, 49],
            '50-64' => [50, 64],
            '65 or higher' => [65, 150],
        ];

        $internalCategories = ['faculty', 'Non-teaching staff'];
        $externalCategories = [
            'Student', 'Alumni', 'parents', 'Community_member',
            'industry_partner', 'supplier', 'Regulatory', 'Others',
        ];

        $ageBreakdown = [];
        foreach ($ageRanges as $range => [$min, $max]) {
            $externalCount = Form::whereBetween('age', [$min, $max])
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->whereIn('client_category', $externalCategories)
                ->count();

            $internalCount = Form::whereBetween('age', [$min, $max])
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->whereIn('client_category', $internalCategories)
                ->count();

            $totalCount = $externalCount + $internalCount;
            $totalForms = Form::whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->count();

            $ageBreakdown[$range] = [
                'external' => ['count' => $externalCount, 'percentage' => $totalForms > 0 ? ($externalCount / $totalForms) * 100 : 0],
                'internal' => ['count' => $internalCount, 'percentage' => $totalForms > 0 ? ($internalCount / $totalForms) * 100 : 0],
                'total' => ['count' => $totalCount, 'percentage' => $totalForms > 0 ? ($totalCount / $totalForms) * 100 : 0],
            ];
        }

        return $ageBreakdown;
    }

    public function getClientMunicipalityBreakdown($startMonth, $endMonth, $year, $serviceIds)
    {
        $municipalities = [
            'Agno', 'Aguilar', 'Alaminos', 'Alcala', 'Anda', 'Bani', 'Binmaley',
            'Bolinao', 'Burgos', 'Dagupan', 'Dasol', 'Infanta', 'Lingayen', 'Mabini',
            'Mangaldan', 'Mangatarem', 'Rosales', 'Sta. Barbara', 'Sta. Maria',
            'Sual', 'Others',
        ];

        $internalCategories = ['faculty', 'Non-teaching staff'];
        $externalCategories = [
            'Student', 'Alumni', 'parents', 'Community_member',
            'industry_partner', 'supplier', 'Regulatory', 'Others',
        ];

        $municipalityBreakdown = [];
        foreach ($municipalities as $municipality) {
            $externalCount = Form::where('Municipality', $municipality)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->whereIn('client_category', $externalCategories)
                ->count();

            $internalCount = Form::where('Municipality', $municipality)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->whereIn('client_category', $internalCategories)
                ->count();

            $totalCount = $externalCount + $internalCount;
            $totalForms = Form::whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->count();

            $municipalityBreakdown[$municipality] = [
                'external' => ['count' => $externalCount, 'percentage' => $totalForms > 0 ? ($externalCount / $totalForms) * 100 : 0],
                'internal' => ['count' => $internalCount, 'percentage' => $totalForms > 0 ? ($internalCount / $totalForms) * 100 : 0],
                'total' => ['count' => $totalCount, 'percentage' => $totalForms > 0 ? ($totalCount / $totalForms) * 100 : 0],
            ];
        }

        return $municipalityBreakdown;
    }

    public function getClientCategoryBreakdown($startMonth, $endMonth, $year, $serviceIds)
    {
        $clientCategories = [
            'Student', 'Faculty', 'Non-teaching staff', 'Alumni', 'Parents',
            'Community_member', 'Industry_partner', 'Supplier', 'Regulatory', 'Others',
        ];

        $internalCategories = ['faculty', 'Non-teaching staff'];
        $externalCategories = [
            'Student', 'Alumni', 'parents', 'Community_member',
            'industry_partner', 'supplier', 'Regulatory', 'Others',
        ];

        $categoryBreakdown = [];
        foreach ($clientCategories as $category) {
            $externalCount = Form::where('client_category', $category)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->whereIn('client_category', $externalCategories)
                ->count();

            $internalCount = Form::where('client_category', $category)
                ->whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->whereIn('client_category', $internalCategories)
                ->count();

            $totalCount = $externalCount + $internalCount;
            $totalForms = Form::whereYear('date', $year)
                ->whereMonth('date', '>=', $startMonth)
                ->whereMonth('date', '<=', $endMonth)
                ->whereIn('service_id', $serviceIds)
                ->count();

            $categoryBreakdown[$category] = [
                'external' => ['count' => $externalCount, 'percentage' => $totalForms > 0 ? ($externalCount / $totalForms) * 100 : 0],
                'internal' => ['count' => $internalCount, 'percentage' => $totalForms > 0 ? ($internalCount / $totalForms) * 100 : 0],
                'total' => ['count' => $totalCount, 'percentage' => $totalForms > 0 ? ($totalCount / $totalForms) * 100 : 0],
            ];
        }

        return $categoryBreakdown;
    }

     // Helper methods for forms count
    public function getInternalFormsCount($serviceIds)
    {
        $internalCategories = ['faculty', 'Non-teaching staff'];
        return Form::whereIn('client_category', $internalCategories)
            ->whereIn('service_id', $serviceIds)
            ->count();
    }

    public function getExternalFormsCount($serviceIds)
    {
        $externalCategories = [
            'Student', 'Alumni', 'parents', 'Community_member',
            'industry_partner', 'supplier', 'Regulatory', 'Others'
        ];
        return Form::whereIn('client_category', $externalCategories)
            ->whereIn('service_id', $serviceIds)
            ->count();
    }

    public function getTotalFormsCount($serviceIds)
    {
        $internalCategories = ['faculty', 'Non-teaching staff'];
        $externalCategories = [
            'Student', 'Alumni', 'parents', 'Community_member',
            'industry_partner', 'supplier', 'Regulatory', 'Others'
        ];
        return Form::whereIn('client_category', array_merge($internalCategories, $externalCategories))
            ->whereIn('service_id', $serviceIds)
            ->count();
    }
}
