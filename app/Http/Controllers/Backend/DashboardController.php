<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;

use App\Models\VisitorLogs;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {

        // Count of blog posts created in the current month
        $data['blog_post'] = BlogPost::whereMonth('created_at', Carbon::now()->month)->count();

        // Count of unique subscriber emails created in the current month
        $data['subscribers'] = Subscriber::whereMonth('created_at', Carbon::now()->month)
            ->distinct('email')->count('email');

        // Count of contacts added in the current month
        $data['contacts'] = Contact::whereMonth('created_at', Carbon::now()->month)->count('email');

        // Retrieve latest subscriber details (one entry per unique email) created in current month
        // Group by email and get the max created_at for each
        $data['subscribers_details'] = DB::table('subscribers')
            ->select(DB::raw('MAX(created_at) as created_at, email'))
            ->whereMonth('created_at', now()->month)
            ->groupBy('email')
            ->orderByDesc('created_at') // Order by latest subscription date descending
            ->get();

        // Get all contact details created in the current month
        $data['contacts_details'] = Contact::whereMonth('created_at', Carbon::now()->month)->get();

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

        // Retrieve latest 20 activity logs with related user (causer) and subject information
        $data['activities'] = Activity::with('causer', 'subject')->latest()->limit(20)->get();
        

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
