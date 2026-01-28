@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Audience Reports</h2>
            <p class="text-gray-500 mt-1 text-sm">User composition for <span class="font-semibold text-indigo-600">{{ $website->name }}</span></p>
        </div>
        @if(isset($latestDate))
        <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Data as of: {{ \Carbon\Carbon::parse($latestDate)->format('M d, Y') }}
        </div>
        @endif
    </div>

    @if(isset($no_data) || $audience->isEmpty())
        @include('reports._no_data')
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">User Type Distribution</h3>
                <div id="audienceChart" class="w-full h-80"></div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Detailed Breakdown</h3>
                <div class="space-y-4">
                    @foreach($audience as $row)
                    @php 
                        $total = $audience->sum('users');
                        $percent = $total > 0 ? ($row->users / $total) * 100 : 0;
                        $color = $row->user_type == 'new' ? 'indigo' : 'emerald';
                    @endphp
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-gray-600 uppercase">{{ $row->user_type }}</span>
                            <span class="text-sm font-bold text-gray-800">{{ number_format($row->users) }} users</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-{{ $color }}-500 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="text-right mt-1 text-xs text-gray-400">{{ number_format($percent, 1) }}% of total</div>
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
            var audienceOptions = {
                series: @json($audience->pluck('users')),
                labels: @json($audience->pluck('user_type')->map(fn($t) => ucfirst($t))),
                chart: { type: 'donut', height: 350, fontFamily: 'Outfit, sans-serif' },
                colors: ['#6366f1', '#10b981'],
                dataLabels: { enabled: true },
                legend: { position: 'bottom' },
                tooltip: { y: { formatter: val => val + " Users" } }
            };
            var audienceChart = new ApexCharts(document.querySelector("#audienceChart"), audienceOptions);
            audienceChart.render();
        });
    </script>
    @endpush
@endsection
