<aside class="w-64 bg-white border-r border-gray-100 min-h-screen fixed left-0 top-0 overflow-y-auto z-50 hidden md:block shadow-sm">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-indigo-600 flex items-center gap-2 tracking-tight">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Analytics
        </h1>
    </div>

    <nav class="mt-4 px-4 space-y-1">
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <a href="{{ route('pages') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('pages') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Pages
        </a>

        <a href="{{ route('realtime') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('realtime') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Realtime
        </a>

        <a href="{{ route('audience') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('audience') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Audience
        </a>
        
        <a href="{{ route('geography') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('geography') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Geography
        </a>

        <a href="{{ route('devices') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('devices') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            Devices
        </a>

        <a href="{{ route('acquisition') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('acquisition') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            Acquisition
        </a>
        
         <div class="px-4 mt-8 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
            System
        </div>
        
        <a href="{{ route('system') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('system') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            System Info
        </a>

        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600 font-bold shadow-sm' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profile
        </a>
    </nav>
</aside>
