<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;

use App\Models\VisitorLogs;

use App\Http\Controllers\Controller;
use App\Models\ComponentField;
use App\Models\ComponentMaster;
use App\Models\Contact;
use App\Models\Page;
use App\Models\PageComponent;
use App\Models\PageComponentStatus;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {

        $data['contacts_total'] = Contact::count();
        $data['contacts_this_month'] = Contact::whereMonth('created_at', Carbon::now()->month)->count();
        $data['contacts_unread'] = Contact::where('status', 0)->count();
        $data['contacts_details'] = Contact::latest()->limit(8)->get();

        $data['pages_total'] = Page::count();
        $data['active_pages'] = Page::where('status', 1)->count();
        $data['pages_missing_breadcrumb'] = Page::where('is_breadcrumb', 1)
            ->where(function ($query) {
                $query->whereNull('description')->orWhere('description', '');
            })
            ->count();

        $data['components_total'] = ComponentMaster::count();
        $data['page_components_total'] = PageComponent::count();
        $data['active_page_components'] = PageComponentStatus::where('status', 1)->count();
        $data['empty_component_fields'] = ComponentField::where(function ($query) {
                $query->whereNull('value')->orWhere('value', '');
            })
            ->count();

        $data['pages'] = Page::select('id', 'name', 'permalink', 'status', 'is_breadcrumb', 'description', 'updated_at')
            ->latest('updated_at')
            ->limit(6)
            ->get();

        // Get URLs visited today along with the number of visits per URL, ordered by most visited
        $data['urls'] = $pageVisits = VisitorLogs::selectRaw('url as name, count(url) as visit_count')
            ->groupBy('url')
            ->orderBy('visit_count', 'desc')
            ->whereDate('created_at', Carbon::today())
            ->get();

        // Count of visitors in the current month
        $data['visitors'] = $pageVisits = VisitorLogs::whereMonth('created_at', Carbon::now()->month)->count();

        // Total visitor count across all time
        $data['visitors_total'] = $pageVisits = VisitorLogs::count();

        // Calculate the percentage growth of visitors for the current month (custom method)
        $data['growth_percent'] = $this->getVisitorCurrentMonthIncaseLogs();

        // Get visitor counts grouped by month (e.g., Jan, Feb) for the available data, ordered by month ascending
        $data['month_wise_visitors'] = VisitorLogs::selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(platform) as count')
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->pluck('count', 'month');

        // Get visitor counts grouped by month and device type (e.g., mobile, desktop)
        $data['device_wise_visitors'] = VisitorLogs::selectRaw('
        DATE_FORMAT(created_at, "%b") as month,
        device,
        COUNT(*) as count
    ')
            ->groupByRaw('month, device')
            ->get();

        // Get browsers used by visitors today along with their usage counts, ordered by most used browser
        $data['browsers'] = $pageVisits = VisitorLogs::selectRaw('browser as name, count(browser) as count')
            ->groupBy('browser')
            ->orderBy('count', 'desc')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $data['activities'] = Activity::with('causer', 'subject')->latest()->limit(10)->get();
        

        return view('backend.dashboard', compact('data'));
    }



    public function getVisitorCurrentMonthIncaseLogs()
    {
        // Get current and previous months' start and end dates
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Get current month visitor count
        $data['visitors'] = $currentVisitors = VisitorLogs::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();

        // Get previous month visitor count
        $data['previous_visitors'] = $previousVisitors = VisitorLogs::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        // Calculate percentage increase or decrease
        return  $previousVisitors > 0
            ? round((($currentVisitors - $previousVisitors) / $previousVisitors) * 100, 2)
            : ($currentVisitors > 0 ? 0 : 0);
    }
}
