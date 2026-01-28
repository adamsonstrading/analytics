@extends('layouts.app')

@section('content')
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Pages Report</h2>
            <p class="text-gray-500 mt-1 text-sm">Detailed performance by page for <span class="font-semibold text-indigo-600">{{ $website->name }}</span></p>
        </div>
        @if(isset($latestDate))
        <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg border border-gray-200 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Data: {{ \Carbon\Carbon::parse($latestDate)->format('M d, Y') }}
        </div>
        @endif
    </div>

    @if(isset($no_data) || $pages->isEmpty())
        @include('reports._no_data')
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-4 px-6 text-sm font-bold text-gray-500 border-b border-gray-100">Page Title</th>
                            <th class="py-4 px-6 text-sm font-bold text-gray-500 border-b border-gray-100">Path</th>
                            <th class="py-4 px-6 text-sm font-bold text-gray-500 border-b border-gray-100 text-right">Views</th>
                            <th class="py-4 px-6 text-sm font-bold text-gray-500 border-b border-gray-100 text-right">Avg. Time (s)</th>
                            <th class="py-4 px-6 text-sm font-bold text-gray-500 border-b border-gray-100 text-right">Visual Share</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $maxViews = $pages->max('views'); @endphp
                        @foreach($pages as $page)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="py-4 px-6 text-gray-800 font-semibold border-b border-gray-50">{{ $page->page_title }}</td>
                            <td class="py-4 px-6 text-gray-500 text-sm border-b border-gray-50">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ $page->page_path }}</span>
                            </td>
                            <td class="py-4 px-6 text-gray-900 font-black border-b border-gray-50 text-right">{{ number_format($page->views) }}</td>
                            <td class="py-4 px-6 text-gray-600 text-sm border-b border-gray-50 text-right">{{ number_format($page->avg_time, 1) }}s</td>
                            <td class="py-4 px-6 border-b border-gray-50 text-right w-48">
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-indigo-500 h-full" style="width: {{ ($page->views / $maxViews) * 100 }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
