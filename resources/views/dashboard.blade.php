@extends('layouts.app')

@section('content')
    <div class="relative z-10"> <!-- Main Content Container -->
        <!-- Header Section with Modern Gradient Text -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-indigo-600 tracking-tight mb-2">Dashboard</h2>
                <div class="flex items-center gap-2 text-gray-500 text-sm font-medium">
                     <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Overview</span>
                     <span>for</span>
                     <span class="text-gray-900 font-bold border-b-2 border-indigo-100 pb-0.5">{{ $website->name ?? 'Select a Website' }}</span>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <!-- Modern Date Range Picker -->
                <form id="dateRangeForm" action="{{ route('dashboard') }}" method="GET" class="relative group" onclick="document.getElementById('date_range_picker').click()">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl opacity-20 group-hover:opacity-100 transition duration-300 blur-sm"></div>
                    <div class="relative flex items-center gap-3 bg-white px-5 py-3 rounded-xl shadow-sm border border-gray-100 cursor-pointer">
                        <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-gray-400 leading-none mb-1">Period</span>
                            <input type="text" id="date_range_picker" class="text-sm font-bold text-gray-800 bg-transparent border-none p-0 focus:ring-0 cursor-pointer pointer-events-none w-48 font-mono" 
                                   value="{{ $startDate && $endDate ? \Carbon\Carbon::parse($startDate)->format('M d') . ' - ' . \Carbon\Carbon::parse($endDate)->format('M d, Y') : 'Select Dates' }}">
                        </div>
                    </div>
                     <input type="hidden" name="start_date" id="start_date_input" value="{{ $startDate }}">
                     <input type="hidden" name="end_date" id="end_date_input" value="{{ $endDate }}">
                </form>

                <!-- Premium Export Button -->
                <!-- Premium Export Button -->
                <a id="exportCsvBtn" 
                   href="{{ route('export.csv', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   style="display: flex !important; align-items: center !important; gap: 8px !important; background-color: #111827 !important; color: white !important; padding: 12px 24px !important; border-radius: 12px !important; text-decoration: none !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2) !important; transition: all 0.2s ease !important; font-weight: 800 !important; font-size: 13px !important; text-transform: uppercase !important; letter-spacing: 0.5px !important;"
                   onmouseover="this.style.backgroundColor='#312e81'; this.style.transform='translateY(-2px)'" 
                   onmouseout="this.style.backgroundColor='#111827'; this.style.transform='translateY(0)'">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Export Report</span>
                </a>
            </div>
        </div>

    @if(isset($no_data))
        <div class="bg-yellow-50 text-yellow-700 p-6 rounded-xl border border-yellow-200 text-center">
            <h3 class="text-lg font-bold mb-2">No Website Found</h3>
            <p>Please configure a website in the database or settings to view analytics.</p>
        </div>
    @elseif(isset($no_analytics) || $history->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border border-dashed border-gray-200 shadow-sm">
            <div class="bg-gray-50 p-6 rounded-full mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800">No Analytics Data for this Range</h3>
            <p class="text-gray-500 mt-2 max-w-sm text-center">We couldn't find any records between {{ \Carbon\Carbon::parse($startDate)->format('M d') }} and {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}.</p>
            <div class="mt-8 flex gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all text-sm">Reset Filter</a>
                <div class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all text-sm cursor-help" title="Data is fetched daily via background tasks.">Why is this empty?</div>
            </div>
        </div>
    @else

    <!-- KPI Cards -->
    <!-- KPI Cards - Modern Glassmorphism -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Active Users -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/50 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform"></div>
            
            <div class="flex items-center justify-between mb-4 relative">
                <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Active Users</div>
                <div class="bg-blue-100/50 text-blue-600 p-2.5 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="text-4xl font-black text-gray-800 tracking-tight mb-2 relative">{{ number_format($overview->active_users) }}</div>
            <div class="flex items-center gap-2 relative">
                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-md flex items-center shadow-sm">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    0%
                </span>
                <span class="text-gray-400 text-xs text-medium">vs yesterday</span>
            </div>
        </div>

        <!-- Sessions -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/50 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Sessions</div>
                <div class="bg-indigo-100/50 text-indigo-600 p-2.5 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                </div>
            </div>
            <div class="text-4xl font-black text-gray-800 tracking-tight mb-2 relative">{{ number_format($overview->sessions) }}</div>
             <div class="text-xs text-gray-400 font-medium relative">Total sessions</div>
        </div>

        <!-- Page Views -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/50 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Page Views</div>
                <div class="bg-purple-100/50 text-purple-600 p-2.5 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-all shadow-sm">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
            </div>
            <div class="text-4xl font-black text-gray-800 tracking-tight mb-2 relative">{{ number_format($overview->page_views) }}</div>
             <div class="text-xs text-gray-400 font-medium relative">All pages</div>
        </div>

        <!-- Engagement -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100/50 group relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center justify-between mb-4 relative">
                <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Engagement Rate</div>
                <div class="bg-orange-100/50 text-orange-600 p-2.5 rounded-xl group-hover:bg-orange-600 group-hover:text-white transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <div class="text-4xl font-black text-gray-800 tracking-tight mb-2 relative">{{ number_format($overview->engagement_rate * 100, 1) }}%</div>
             <div class="text-xs text-gray-400 font-medium relative">Average</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
         <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
             <div class="flex items-center justify-between mb-6">
                 <div>
                    <h3 class="font-bold text-gray-800 text-lg">Traffic Overview</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
                 </div>
                 <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full border border-indigo-100">Historical View</span>
             </div>
             <div id="trafficChart" class="w-full"></div>
         </div>
         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col">
             <div class="mb-6">
                <h3 class="font-bold text-gray-800 text-lg">Device Breakdown</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
             </div>
             <div id="deviceChart" class="w-full h-64 flex-1"></div>
         </div>
    </div>
    
    <!-- Top Pages & Acquisition Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Top Pages Table -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-full">
            <div class="mb-6">
                <h3 class="font-bold text-gray-800 text-lg">Top Performing Pages</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
            </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100">Page</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100 text-right">Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPages as $page)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 px-4 text-gray-800 font-medium border-b border-gray-50 truncate max-w-[200px]">{{ $page->page_title }}</td>
                            <td class="py-3 px-4 text-gray-800 font-bold border-b border-gray-50 text-right">{{ number_format($page->views) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('pages') }}" class="block text-center mt-4 text-sm font-bold text-indigo-600 hover:text-indigo-700">View All Pages</a>
            </div>

        <!-- Acquisition Sources -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-full">
            <div class="mb-6">
                <h3 class="font-bold text-gray-800 text-lg">Top Acquisition Sources</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
            </div>
            <div id="acquisitionChart" class="w-full"></div>
            @if($sources->isEmpty())
                <div class="text-center py-8 text-gray-400">No acquisition data</div>
            @endif
            <a href="{{ route('acquisition') }}" class="block text-center mt-4 text-sm font-bold text-indigo-600 hover:text-indigo-700">Detailed Acquisition</a>
        </div>
    </div>

    <!-- Geography & Audience Summary Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Geography -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Top Countries
            </h3>
            <div class="space-y-4">
                @foreach($geographies as $g)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-600">{{ $g->country }}</span>
                    <span class="text-sm font-bold text-gray-800">{{ number_format($g->users) }}</span>
                </div>
                @endforeach
            </div>
            <a href="{{ route('geography') }}" class="block text-center mt-6 py-2 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition-colors">See Geography Report</a>
        </div>

        <!-- Audience -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Audience Type
            </h3>
            <div id="audienceMiniChart" class="w-full"></div>
            <a href="{{ route('audience') }}" class="block text-center mt-2 py-2 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition-colors">See Audience Report</a>
        </div>

        <!-- System Summary -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-full">
            <h3 class="font-bold text-gray-800 mb-6 text-lg flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Top Browsers
            </h3>
            <div class="space-y-4">
                @foreach($systems->groupBy('browser')->take(3) as $browser => $rows)
                <div class="flex items-center gap-3">
                    <div class="flex-1 bg-gray-50 p-2 rounded-lg border border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-700">{{ $browser }}</span>
                        <span class="text-xs font-black text-purple-600">{{ number_format($rows->sum('users')) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('system') }}" class="block text-center mt-6 py-2 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition-colors">See System Info</a>
        </div>
    </div>

    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Flatpickr
            flatpickr("#date_range_picker", {
                mode: "range",
                dateFormat: "Y-m-d",
                maxDate: "today",
                defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const start = instance.formatDate(selectedDates[0], "Y-m-d");
                        const end = instance.formatDate(selectedDates[1], "Y-m-d");
                        
                        document.getElementById('start_date_input').value = start;
                        document.getElementById('end_date_input').value = end;
                        
                        // Auto-submit after selecting the range
                        setTimeout(() => {
                            document.getElementById('dateRangeForm').submit();
                        }, 500);
                    }
                }
            });

            // Traffic Chart
            var trafficDataUsers = @json($history->pluck('active_users')).map(Number);
            var trafficDataSessions = @json($history->pluck('sessions')).map(Number);

            var trafficOptions = {
                series: [{
                    name: 'Users',
                    data: trafficDataUsers
                }, {
                    name: 'Sessions',
                    data: trafficDataSessions
                }],
                chart: {
                    height: 380,
                    type: 'bar',
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 4,
                        endingShape: 'rounded'
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: {
                    categories: @json($history->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))),
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) { return val.toFixed(0); }
                    }
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        formatter: function (val) { return val + " count" }
                    }
                },
                colors: ['#3b82f6', '#10b981'],
                grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -10
                }
            };

            var trafficChart = new ApexCharts(document.querySelector("#trafficChart"), trafficOptions);
            trafficChart.render();
            
            // Device Chart
            var deviceLabels = @json($devices->pluck('device_category'));
            var deviceSeries = @json($devices->pluck('users')).map(Number);
            
            var deviceOptions = {
                series: deviceSeries,
                labels: deviceLabels,
                chart: {
                    type: 'donut',
                    height: 300,
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b'],
                plotOptions: {
                    pie: { donut: { size: '65%' } }
                },
                dataLabels: { enabled: false }
            };
            
            if(deviceSeries.length > 0) {
                var deviceChart = new ApexCharts(document.querySelector("#deviceChart"), deviceOptions);
                deviceChart.render();
            } else {
                document.querySelector("#deviceChart").innerHTML = '<div class="h-full flex items-center justify-center text-gray-400">No device data</div>';
            }

            // Audience Mini Chart
            var audienceOptions = {
                series: @json($audience->pluck('users')).map(Number),
                labels: @json($audience->pluck('user_type')->map(fn($t) => ucfirst($t))),
                chart: { type: 'donut', height: 200, fontFamily: 'Outfit, sans-serif', sparkline: { enabled: true } },
                colors: ['#6366f1', '#10b981'],
                stroke: { width: 0 },
                dataLabels: { enabled: false },
                legend: { show: false },
                tooltip: { y: { formatter: val => val + " Users" } }
            };
            var audienceMiniChart = new ApexCharts(document.querySelector("#audienceMiniChart"), audienceOptions);
            audienceMiniChart.render();

            // Acquisition Chart
            var acquisitionOptions = {
                series: [{
                    name: 'Sessions',
                    data: @json($sources->pluck('sessions')).map(Number)
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    fontFamily: 'Outfit, sans-serif',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                        distributed: true
                    }
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                dataLabels: { enabled: true },
                xaxis: {
                    categories: @json($sources->map(fn($s) => $s->source . ' (' . $s->medium . ')'))
                },
                legend: { show: false }
            };
            var acquisitionChart = new ApexCharts(document.querySelector("#acquisitionChart"), acquisitionOptions);
            acquisitionChart.render();
        });
    </script>
    </div> <!-- End Main Content Container -->
@endsection
