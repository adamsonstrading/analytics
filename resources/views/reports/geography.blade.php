@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Geography Report</h2>
            <p class="text-gray-500 mt-1 text-sm">Visitor locations for <span class="font-semibold text-indigo-600">{{ $website->name }}</span></p>
        </div>
        @if(isset($latestDate))
        <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Data as of: {{ \Carbon\Carbon::parse($latestDate)->format('M d, Y') }}
        </div>
        @endif
    </div>

    @if(isset($no_data) || $geo->isEmpty())
        @include('reports._no_data')
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Top Countries</h3>
                <div class="space-y-4">
                    @foreach($geo->take(10) as $row)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($row->country, 0, 2) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $row->country }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($row->users) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Global Visitor Distribution</h3>
                <div id="geoChart" class="w-full h-96"></div>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var geoOptions = {
                series: [{
                    name: 'Users',
                    data: @json($geo->take(15)->pluck('users'))
                }],
                chart: { type: 'bar', height: 400, fontFamily: 'Outfit, sans-serif' },
                plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
                xaxis: { categories: @json($geo->take(15)->pluck('country')) },
                colors: ['#6366f1'],
                title: { text: 'Visitors by Country', align: 'center' }
            };
            var geoChart = new ApexCharts(document.querySelector("#geoChart"), geoOptions);
            geoChart.render();
        });
    </script>
    @endpush
@endsection
