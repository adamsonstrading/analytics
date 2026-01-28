<header class="bg-white border-b border-gray-200 h-20 flex items-center justify-between px-6 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center gap-4">
        <button class="md:hidden text-gray-500 focus:outline-none hover:text-indigo-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <div class="relative group">
            <form action="{{ route('website.switch') }}" method="POST">
                @csrf
                <select name="website_id" onchange="this.form.submit()" class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 transition-all w-64 shadow-sm cursor-pointer hover:border-indigo-300">
                    <option value="">Select Website</option>
                    @foreach(\App\Models\Website::all() as $site)
                        <option value="{{ $site->id }}" {{ session('selected_website_id') == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                    @endforeach
                </select>
            </form>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 group-hover:text-indigo-600 transition-colors">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>

        <a href="{{ route('website.create') }}" 
           style="background-color: #4f46e5 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 8px !important; padding: 10px 24px !important; border-radius: 12px !important; font-weight: 800 !important; font-size: 13px !important; text-decoration: none !important; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1) !important; border: none !important; cursor: pointer !important; white-space: nowrap !important;"
           title="Add New Website">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            ADD SITE
        </a>
    </div>

    <div class="flex items-center gap-4">
        <div class="relative">
             <!-- Notification Bell Mockup -->
             <button class="text-gray-400 hover:text-indigo-600 transition-colors">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
             </button>
        </div>

        @auth
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 pl-4 border-l border-gray-200 group/profile">
            <div class="text-right hidden sm:block">
                <div class="text-sm font-semibold text-gray-800 group-hover/profile:text-indigo-600 transition-colors">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">Admin</div>
            </div>
            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-lg ring-2 ring-white transform group-hover/profile:scale-105 transition-transform">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </a>
        @endauth
    </div>
</header>
