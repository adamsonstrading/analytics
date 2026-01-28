<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;

class GA4Service
{
    protected $client;

    public function __construct()
    {
        $path = env('GA4_CREDENTIALS_PATH', 'storage/app/analytics/service-account-credentials.json');
        $credentialsPath = base_path($path);
        
        if (file_exists($credentialsPath)) {
            $this->client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath
            ]);
        }
    }

    public function isConfigured()
    {
        return $this->client !== null;
    }

    /**
     * Fetch Daily Overview (Users, Sessions, PageViews, Engagement, Conversions)
     */
    public function fetchDailyOverview($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([new Dimension(['name' => 'date'])])
            ->setMetrics([
                new Metric(['name' => 'activeUsers']),
                new Metric(['name' => 'sessions']),
                new Metric(['name' => 'screenPageViews']),
                new Metric(['name' => 'engagementRate']),
                new Metric(['name' => 'conversions']),
            ]);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Fetch Top Pages
     */
    public function fetchPages($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([
                new Dimension(['name' => 'pagePath']),
                new Dimension(['name' => 'pageTitle']),
            ])
            ->setMetrics([
                new Metric(['name' => 'screenPageViews']),
                new Metric(['name' => 'userEngagementDuration']),
            ])
            ->setLimit(20);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Fetch Device Categories
     */
    public function fetchDevices($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([new Dimension(['name' => 'deviceCategory'])])
            ->setMetrics([new Metric(['name' => 'activeUsers'])]);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Fetch traffic sources
     */
    public function fetchSources($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([
                new Dimension(['name' => 'sessionSource']),
                new Dimension(['name' => 'sessionMedium']),
            ])
            ->setMetrics([new Metric(['name' => 'sessions'])]);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Fetch Geo data
     */
    public function fetchGeo($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([new Dimension(['name' => 'country'])])
            ->setMetrics([new Metric(['name' => 'activeUsers'])]);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Fetch System Info (Browser, OS)
     */
    public function fetchSystem($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([
                new Dimension(['name' => 'browser']),
                new Dimension(['name' => 'operatingSystem']),
            ])
            ->setMetrics([new Metric(['name' => 'activeUsers'])]);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Fetch Realtime Data (Last 30 mins)
     */
    public function fetchRealtime($propertyId)
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunRealtimeReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDimensions([new Dimension(['name' => 'country'])])
            ->setMetrics([new Metric(['name' => 'activeUsers'])]);

        return $this->processResponse($this->client->runRealtimeReport($request));
    }

    /**
     * Fetch Audience (New vs Returning)
     */
    public function fetchAudience($propertyId, $date = 'yesterday')
    {
        if (!$this->isConfigured()) return [];

        $request = (new RunReportRequest())
            ->setProperty('properties/' . $propertyId)
            ->setDateRanges([new DateRange(['start_date' => $date, 'end_date' => $date])])
            ->setDimensions([new Dimension(['name' => 'newVsReturning'])])
            ->setMetrics([new Metric(['name' => 'activeUsers'])]);

        return $this->processResponse($this->client->runReport($request));
    }

    /**
     * Helper to process GA4 response into a simple array
     */
    protected function processResponse($response)
    {
        $results = [];
        foreach ($response->getRows() as $row) {
            $dimensions = [];
            foreach ($row->getDimensionValues() as $dimValue) {
                $dimensions[] = $dimValue->getValue();
            }

            $metrics = [];
            foreach ($row->getMetricValues() as $metricValue) {
                $metrics[] = $metricValue->getValue();
            }

            $results[] = [
                'dimensions' => $dimensions,
                'metrics' => $metrics
            ];
        }
        return $results;
    }
}
