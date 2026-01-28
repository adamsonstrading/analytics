@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">System Reports</h2>
            <p class="text-gray-500 mt-1 text-sm">Browsers and OS breakdown for <span class="font-semibold text-indigo-600">{{ $website->name }}</span></p>
        </div>
        @if(isset($latestDate))
        <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            Data: {{ \Carbon\Carbon::parse($latestDate)->format('M d, Y') }}
        </div>
        @endif
    </div>

    @if(isset($no_data) || $systems->isEmpty())
        @include('reports._no_data')
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Browsers -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Browsers</h3>
                <div class="space-y-4">
                    @foreach($systems->groupBy('browser')->map->sum('users')->sortDesc() as $browser => $users)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $browser }}</span>
                            <span class="text-sm font-bold text-indigo-600">{{ number_format($users) }} users</span>
                        </div>
                        <div class="w-full bg-gray-50 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-indigo-400 h-full" style="width: {{ ($users / $systems->sum('users')) * 100 }}%"></div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Operating Systems -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Operating Systems</h3>
                <div class="space-y-4">
                    @foreach($systems->groupBy('os')->map->sum('users')->sortDesc() as $os => $users)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $os }}</span>
                            <span class="text-sm font-bold text-emerald-600">{{ number_format($users) }} users</span>
                        </div>
                         <div class="w-full bg-gray-50 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-emerald-400 h-full" style="width: {{ ($users / $systems->sum('users')) * 100 }}%"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
