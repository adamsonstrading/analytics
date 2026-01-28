@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Realtime Report</h2>
            <p class="text-gray-500 mt-1 text-sm">Live data for <span class="font-semibold text-indigo-600">{{ $website->name }}</span> (Last 30 mins)</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="flex h-3 w-3 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
            <span class="text-xs font-bold text-red-500 uppercase tracking-wider">Live</span>
        </div>
    </div>

    @if(isset($no_data))
        @include('reports._no_data')
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Active Users by Country</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100">Country</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100 text-right">Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($realtime as $row)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4 text-gray-800 font-medium border-b border-gray-50">{{ $row['dimensions'][0] }}</td>
                                <td class="py-3 px-4 text-gray-800 font-bold border-b border-gray-50 text-right">{{ number_format($row['metrics'][0]) }}</td>
                            </tr>
                            @endforeach
                            @if(empty($realtime))
                                <tr>
                                    <td colspan="2" class="py-8 text-center text-gray-400">No active users in the last 30 minutes</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-indigo-600 p-8 rounded-2xl shadow-xl text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-indigo-100 font-medium mb-2 uppercase tracking-widest text-xs">Right Now</h3>
                    <div class="text-7xl font-black mb-4">
                        {{ collect($realtime)->sum(fn($r) => $r['metrics'][0]) }}
                    </div>
                    <div class="text-indigo-100">Active users on site</div>
                </div>
                <!-- Abstract Design Elements -->
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-white opacity-5 rounded-full"></div>
            </div>
        </div>
    @endif
@endsection
