@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Acquisition</h2>
            <p class="text-gray-500 mt-1 text-sm">Where your traffic comes from for <span class="font-semibold text-indigo-600">{{ $website->name }}</span></p>
        </div>
        @if(isset($latestDate))
        <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Data: {{ \Carbon\Carbon::parse($latestDate)->format('M d, Y') }}
        </div>
        @endif
    </div>

    @if(isset($no_data) || $sources->isEmpty())
        @include('reports._no_data')
    @else
        <div class="grid grid-cols-1 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-6 text-lg">Top Traffic Sources</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100">Source</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100">Medium</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100 text-right">Sessions</th>
                                <th class="py-3 px-4 text-sm font-medium text-gray-500 border-b border-gray-100 text-right">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sources as $source)
                            @php $percent = ($source->sessions / $sources->sum('sessions')) * 100 @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-4 text-gray-800 font-bold border-b border-gray-50 truncate">{{ $source->source }}</td>
                                <td class="py-3 px-4 text-gray-500 text-sm border-b border-gray-50 italic">{{ $source->medium }}</td>
                                <td class="py-3 px-4 text-gray-800 font-bold border-b border-gray-50 text-right">{{ number_format($source->sessions) }}</td>
                                <td class="py-3 px-4 border-b border-gray-50 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-24 bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-indigo-500 h-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-500 min-w-[40px]">{{ number_format($percent, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
