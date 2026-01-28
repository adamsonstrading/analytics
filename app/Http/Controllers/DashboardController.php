<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\DailyOverview;
use App\Models\DailyPage;
use App\Models\DailyDevice;
use App\Models\DailySource;
use App\Models\DailyGeo;
use App\Models\DailySystem;
use App\Models\DailyAudience;
use App\Services\GA4Service;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $website = $this->getSelectedWebsite();
        
        // If no website, show empty state or guide
        if (!$website) {
            return view('dashboard', ['no_data' => true]);
        }
        
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        // Default to current date if no range is specified (User Request)
        if (!$startDate || !$endDate) {
            $today = now()->toDateString();
            $startDate = $today;
            $endDate = $today;
        }

        // 1. Overview (Aggregated)
        $overviewQuery = DailyOverview::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate]);
            
        $overview = (object)[
            'active_users' => $overviewQuery->sum('active_users'),
            'sessions' => $overviewQuery->sum('sessions'),
            'page_views' => $overviewQuery->sum('page_views'),
            'engagement_rate' => $overviewQuery->avg('engagement_rate') ?? 0,
            'conversions' => $overviewQuery->sum('conversions'),
        ];

        // 2. Traffic Chart
        $history = DailyOverview::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();
            
        // 3. Top Pages
        $topPages = DailyPage::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('page_title, page_path, SUM(views) as views')
            ->groupBy('page_title', 'page_path')
            ->orderByDesc('views')
            ->limit(5)
            ->get();
            
        // 4. Devices
        $devices = DailyDevice::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('device_category, CAST(SUM(users) AS UNSIGNED) as users')
            ->groupBy('device_category')
            ->get();

        // 5. Audience Summary
        $audience = DailyAudience::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('user_type, CAST(SUM(users) AS UNSIGNED) as users')
            ->groupBy('user_type')
            ->get();

        // 6. Geography Summary
        $geographies = DailyGeo::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('country, CAST(SUM(users) AS UNSIGNED) as users')
            ->groupBy('country')
            ->orderByDesc('users')
            ->limit(5)
            ->get();

        // 7. Acquisition Summary
        $sources = DailySource::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('source, medium, CAST(SUM(sessions) AS UNSIGNED) as sessions')
            ->groupBy('source', 'medium')
            ->orderByDesc('sessions')
            ->limit(5)
            ->get();

        // 8. System Summary
        $systems = DailySystem::where('website_id', $website->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->selectRaw('browser, os, CAST(SUM(users) AS UNSIGNED) as users')
            ->groupBy('browser', 'os')
            ->limit(5)
            ->get();
            
        return view('dashboard', compact(
            'website', 'overview', 'history', 'topPages', 'devices', 
            'audience', 'geographies', 'sources', 'systems', 'startDate', 'endDate'
        ));
    }

    public function exportCsv(Request $request)
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return back()->with('error', 'No website selected');

        $startDate = $request->query('start_date', now()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $fileName = 'full_report_' . str_replace(' ', '_', strtolower($website->name)) . '_' . $startDate . '_to_' . $endDate . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Fetch all data for the range
        $overview = DailyOverview::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'asc')->get();
        $pages = DailyPage::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->selectRaw('page_title, SUM(views) as views')->groupBy('page_title')->orderByDesc('views')->get();
        $sources = DailySource::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->selectRaw('source, medium, SUM(sessions) as sessions')->groupBy('source', 'medium')->orderByDesc('sessions')->get();
        $devices = DailyDevice::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->selectRaw('device_category, SUM(users) as users')->groupBy('device_category')->get();
        $geographies = DailyGeo::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->selectRaw('country, SUM(users) as users')->groupBy('country')->orderByDesc('users')->get();
        $systems = DailySystem::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->selectRaw('browser, os, SUM(users) as users')->groupBy('browser', 'os')->orderByDesc('users')->get();
        $audiences = DailyAudience::where('website_id', $website->id)->whereBetween('date', [$startDate, $endDate])->selectRaw('user_type, SUM(users) as users')->groupBy('user_type')->get();

        $callback = function() use($overview, $pages, $sources, $devices, $geographies, $systems, $audiences) {
            $file = fopen('php://output', 'w');
            
            // 1. Overview Section
            fputcsv($file, ['OVERVIEW REPORT']);
            fputcsv($file, ['Date', 'Active Users', 'Sessions', 'Page Views', 'Engagement Rate (%)', 'Conversions']);
            foreach ($overview as $row) {
                fputcsv($file, [$row->date, $row->active_users, $row->sessions, $row->page_views, number_format($row->engagement_rate * 100, 2), $row->conversions]);
            }
            fputcsv($file, []); // Empty row

            // 2. Top Pages Section
            fputcsv($file, ['TOP PAGES (AGGREGATED)']);
            fputcsv($file, ['Page Title', 'Total Views']);
            foreach ($pages as $row) { fputcsv($file, [$row->page_title, $row->views]); }
            fputcsv($file, []);

            // 3. Acquisition Section
            fputcsv($file, ['ACQUISITION SOURCES']);
            fputcsv($file, ['Source', 'Medium', 'Total Sessions']);
            foreach ($sources as $row) { fputcsv($file, [$row->source, $row->medium, $row->sessions]); }
            fputcsv($file, []);

            // 4. Devices Section
            fputcsv($file, ['DEVICE BREAKDOWN']);
            fputcsv($file, ['Device Category', 'Total Users']);
            foreach ($devices as $row) { fputcsv($file, [$row->device_category, $row->users]); }
            fputcsv($file, []);

            // 5. System Breakdown
            fputcsv($file, ['SYSTEM (BROWSERS & OS)']);
            fputcsv($file, ['Browser', 'OS', 'Total Users']);
            foreach ($systems as $row) { fputcsv($file, [$row->browser, $row->os, $row->users]); }
            fputcsv($file, []);

            // 6. Audience Types
            fputcsv($file, ['AUDIENCE TYPES']);
            fputcsv($file, ['User Type', 'Total Users']);
            foreach ($audiences as $row) { fputcsv($file, [ucfirst($row->user_type), $row->users]); }
            fputcsv($file, []);

            // 7. Geography Section
            fputcsv($file, ['GEOGRAPHY']);
            fputcsv($file, ['Country', 'Total Users']);
            foreach ($geographies as $row) { fputcsv($file, [$row->country, $row->users]); }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function switchWebsite(Request $request)
    {
        $request->validate(['website_id' => 'required|exists:websites,id']);
        Session::put('selected_website_id', $request->website_id);
        return back();
    }

    public function realtime(GA4Service $ga4)
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.realtime', ['no_data' => true]);

        $realtime = $ga4->fetchRealtime($website->ga4_property_id);
        return view('reports.realtime', compact('website', 'realtime'));
    }

    public function audience()
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.audience', ['no_data' => true]);

        $latestDate = DailyAudience::where('website_id', $website->id)->max('date');
        $audience = DailyAudience::where('website_id', $website->id)->where('date', $latestDate)->get();
        return view('reports.audience', compact('website', 'audience', 'latestDate'));
    }

    public function geography()
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.geography', ['no_data' => true]);

        $latestDate = DailyGeo::where('website_id', $website->id)->max('date');
        $geo = DailyGeo::where('website_id', $website->id)->where('date', $latestDate)->orderByDesc('users')->get();
        return view('reports.geography', compact('website', 'geo', 'latestDate'));
    }

    public function devices()
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.devices', ['no_data' => true]);

        $latestDate = DailyDevice::where('website_id', $website->id)->max('date');
        $devices = DailyDevice::where('website_id', $website->id)->where('date', $latestDate)->get();
        return view('reports.devices', compact('website', 'devices', 'latestDate'));
    }

    public function acquisition()
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.acquisition', ['no_data' => true]);

        $latestDate = DailySource::where('website_id', $website->id)->max('date');
        $sources = DailySource::where('website_id', $website->id)->where('date', $latestDate)->orderByDesc('sessions')->get();
        return view('reports.acquisition', compact('website', 'sources', 'latestDate'));
    }

    public function system()
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.system', ['no_data' => true]);

        $latestDate = DailySystem::where('website_id', $website->id)->max('date');
        $systems = DailySystem::where('website_id', $website->id)->where('date', $latestDate)->get();
        return view('reports.system', compact('website', 'systems', 'latestDate'));
    }

    public function pages()
    {
        $website = $this->getSelectedWebsite();
        if (!$website) return view('reports.pages', ['no_data' => true]);

        $latestDate = DailyPage::where('website_id', $website->id)->max('date');
        $pages = DailyPage::where('website_id', $website->id)->where('date', $latestDate)->orderByDesc('views')->get();
        return view('reports.pages', compact('website', 'pages', 'latestDate'));
    }

    public function createWebsite()
    {
        return view('websites.create');
    }

    public function storeWebsite(Request $request)
    {
        // Simple fix for common URL missing protocol
        if ($request->url && !preg_match("~^(?:f|ht)tps?://~i", $request->url)) {
            $request->merge(['url' => 'https://' . $request->url]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'ga4_property_id' => 'required|string|max:255|unique:websites,ga4_property_id',
        ], [
            'ga4_property_id.unique' => 'This GA4 Property ID is already registered.',
            'url.url' => 'Please enter a valid website URL (including https://).',
        ]);

        $website = Website::create($validated);

        Session::put('selected_website_id', $website->id);

        return redirect()->route('dashboard')->with('status', 'Website added successfully!');
    }

    protected function getSelectedWebsite()
    {
        $selectedWebsiteId = Session::get('selected_website_id');
        $website = $selectedWebsiteId ? Website::find($selectedWebsiteId) : null;
        
        if (!$website) {
            $website = Website::first();
            if ($website) {
                Session::put('selected_website_id', $website->id);
            }
        }
        
        return $website;
    }
}
