<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Services\GA4Service;
use App\Models\DailyOverview;
use App\Models\DailyPage;
use App\Models\DailyDevice;
use App\Models\DailySource;
use App\Models\DailyGeo;
use App\Models\DailySystem;
use App\Models\DailyAudience;

class FetchGa4Reports extends Command
{
    protected $signature = 'ga4:fetch-daily {--date=yesterday}';
    protected $description = 'Fetch daily GA4 reports for all websites';

    public function handle(GA4Service $ga4)
    {
        $dateArg = $this->option('date');
        
        if ($dateArg === 'yesterday') {
            $date = now()->subDay()->toDateString();
        } elseif ($dateArg === 'today') {
            $date = now()->toDateString();
        } else {
            $date = $dateArg;
        }

        $this->info("Fetching reports for date: {$date}");

        $websites = Website::all();

        foreach ($websites as $website) {
            $this->info("Processing: {$website->name} ({$website->ga4_property_id})");

            // 1. Overview
            $data = $ga4->fetchDailyOverview($website->ga4_property_id, $date);
            if ($data) {
                foreach ($data as $row) {
                    $gaDate = $row['dimensions'][0];
                    $formattedDate = date('Y-m-d', strtotime($gaDate));
                    
                    DailyOverview::updateOrCreate(
                        [
                            'website_id' => $website->id,
                            'date' => $formattedDate
                        ],
                        [
                            'active_users' => $row['metrics'][0],
                            'sessions' => $row['metrics'][1],
                            'page_views' => $row['metrics'][2],
                            'engagement_rate' => $row['metrics'][3],
                            'conversions' => $row['metrics'][4]
                        ]
                    );
                }
            }

            // 2. Pages
            $data = $ga4->fetchPages($website->ga4_property_id, $date);
            if ($data) {
                // Clear existing for this date to avoid duplicates if re-fetched? 
                // Or just loop. Since we don't have unique constraint on pages easily (title changes), 
                // we might want to delete for this date first or just append. 
                // User requirement: "Handle API limits gracefully", "Save results".
                // I'll delete existing for this date/website to allow re-runs.
                DailyPage::where('website_id', $website->id)->where('date', $date)->delete();
                
                foreach ($data as $row) {
                    DailyPage::create([
                        'website_id' => $website->id,
                        'date' => $date,
                        'page_path' => $row['dimensions'][0],
                        'page_title' => $row['dimensions'][1],
                        'views' => $row['metrics'][0],
                        'avg_time' => $row['metrics'][1]
                    ]);
                }
            }

            // 3. Devices
            $data = $ga4->fetchDevices($website->ga4_property_id, $date);
            if ($data) {
                DailyDevice::where('website_id', $website->id)->where('date', $date)->delete();
                foreach ($data as $row) {
                    DailyDevice::create([
                        'website_id' => $website->id,
                        'date' => $date,
                        'device_category' => $row['dimensions'][0],
                        'users' => $row['metrics'][0]
                    ]);
                }
            }

            // 4. Sources
            $data = $ga4->fetchSources($website->ga4_property_id, $date);
            if ($data) {
                DailySource::where('website_id', $website->id)->where('date', $date)->delete();
                foreach ($data as $row) {
                    DailySource::create([
                        'website_id' => $website->id,
                        'date' => $date,
                        'source' => $row['dimensions'][0],
                        'medium' => $row['dimensions'][1],
                        'sessions' => $row['metrics'][0]
                    ]);
                }
            }

            // 5. Geo
            $data = $ga4->fetchGeo($website->ga4_property_id, $date);
            if ($data) {
                DailyGeo::where('website_id', $website->id)->where('date', $date)->delete();
                foreach ($data as $row) {
                    DailyGeo::create([
                        'website_id' => $website->id,
                        'date' => $date,
                        'country' => $row['dimensions'][0],
                        'users' => $row['metrics'][0]
                    ]);
                }
            }

            // 6. System
            $data = $ga4->fetchSystem($website->ga4_property_id, $date);
            if ($data) {
                DailySystem::where('website_id', $website->id)->where('date', $date)->delete();
                foreach ($data as $row) {
                    DailySystem::create([
                        'website_id' => $website->id,
                        'date' => $date,
                        'browser' => $row['dimensions'][0],
                        'os' => $row['dimensions'][1],
                        'users' => $row['metrics'][0]
                    ]);
                }
            }

            // 7. Audience
            $data = $ga4->fetchAudience($website->ga4_property_id, $date);
            if ($data) {
                DailyAudience::where('website_id', $website->id)->where('date', $date)->delete();
                foreach ($data as $row) {
                    DailyAudience::create([
                        'website_id' => $website->id,
                        'date' => $date,
                        'user_type' => $row['dimensions'][0],
                        'users' => $row['metrics'][0]
                    ]);
                }
            }
        }

        $this->info('Done fetching reports.');
    }
}
