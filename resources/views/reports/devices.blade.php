@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Devices Report</h2>
            <p class="text-gray-500 mt-1 text-sm">Hardware breakdown for <span class="font-semibold text-indigo-600">{{ $website->name }}</span></p>
        </div>
        @if(isset($latestDate))
        <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            Data as of: {{ \Carbon\Carbon::parse($latestDate)->format('M d, Y') }}
        </div>
        @endif
    </div>

    @if(isset($no_data) || $devices->isEmpty())
        @include('reports._no_data')
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center">
                 <h3 class="font-bold text-gray-800 mb-6 text-lg self-start">Device Category</h3>
                 <div id="deviceDonut" class="w-full"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Statistical Breakdown</h3>
                <div class="space-y-6">
                    @foreach($devices as $device)
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-gray-50 text-gray-400">
                            @if($device->device_category == 'mobile')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            @elseif($device->device_category == 'desktop')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M12 4V3m0 0a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2V5a2 2 0 012-2h4zm0 16a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2a2 2 0 012-2h4z"></path></svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between mb-1">
                                <span class="font-bold text-gray-700 uppercase text-xs tracking-wider">{{ $device->device_category }}</span>
                                <span class="text-sm font-bold text-indigo-600">{{ number_format($device->users) }} users</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($device->users / $devices->sum('users')) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: @json($devices->pluck('users')),
                labels: @json($devices->pluck('device_category')->map(fn($d) => ucfirst($d))),
                chart: { type: 'donut', height: 400, fontFamily: 'Outfit, sans-serif' },
                colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444'],
                legend: { position: 'bottom' }
            };
            var chart = new ApexCharts(document.querySelector("#deviceDonut"), options);
            chart.render();
        });
    </script>
    @endpush
@endsection
