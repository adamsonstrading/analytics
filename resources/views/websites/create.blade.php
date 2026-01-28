@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Add New Website</h2>
            <p class="text-gray-500 mt-1 text-sm">Configure a new GA4 property to track.</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-12">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <h3 class="text-sm font-bold text-red-800 mb-2">Please correct the following errors:</h3>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('website.store') }}" method="POST" id="websiteForm" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Website Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           placeholder="e.g. Finda Property" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" required>
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="url" class="block text-sm font-semibold text-gray-700 mb-2">Website URL</label>
                    <input type="text" name="url" id="url" value="{{ old('url') }}" 
                           placeholder="https://example.com" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" required>
                    @error('url') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="ga4_property_id" class="block text-sm font-semibold text-gray-700 mb-2">GA4 Property ID</label>
                    <input type="text" name="ga4_property_id" id="ga4_property_id" value="{{ old('ga4_property_id') }}" 
                           placeholder="e.g. 497657805" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none" required>
                    <p class="mt-2 text-xs text-gray-400">You can find this in your Google Analytics Admin > Property Settings.</p>
                    @error('ga4_property_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div style="padding-top: 32px; display: flex; align-items: center; justify-content: flex-end; gap: 24px; border-top: 1px solid #f3f4f6; margin-top: 32px;">
                    <a href="{{ route('dashboard') }}" style="color: #9ca3af; font-weight: 700; font-size: 14px; text-decoration: none;">
                        Cancel
                    </a>
                    <button type="submit" 
                            style="background-color: #4f46e5 !important; color: #ffffff !important; padding: 16px 48px !important; border-radius: 12px !important; font-weight: 900 !important; font-size: 14px !important; border: none !important; cursor: pointer !important; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3) !important; letter-spacing: 0.05em !important; text-transform: uppercase !important;">
                        SAVE WEBSITE
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 p-6 bg-indigo-50 rounded-2xl border border-indigo-100 flex gap-4">
            <div class="text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold text-indigo-900 mb-1">Service Account Reminder</h4>
                <p class="text-xs text-indigo-700 leading-relaxed">Ensure the service account email has **Viewer** access to the new GA4 Property ID in the Google Analytics console.</p>
            </div>
        </div>
    </div>
@endsection
