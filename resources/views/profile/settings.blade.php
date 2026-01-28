@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-black text-gray-800 tracking-tight">Account Settings</h2>
            <p class="text-gray-500 mt-1 text-sm">Update your personal information and security credentials.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Basic Profile Information -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 h-full">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 tracking-tight">Profile Details</h3>
                        <p class="text-gray-400 text-xs font-medium mt-1">Manage your public information</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="group">
                        <label for="prof_name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-500 transition-colors">Full Name</label>
                        <input type="text" name="name" id="prof_name" value="{{ Auth::user()->name }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition-all outline-none font-semibold text-gray-700">
                    </div>
                    <div class="group">
                        <label for="prof_email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-500 transition-colors">Email Address</label>
                        <input type="email" name="email" id="prof_email" value="{{ Auth::user()->email }}" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:bg-white transition-all outline-none font-semibold text-gray-700">
                    </div>
                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-black rounded-2xl shadow-xl shadow-gray-100 hover:bg-black transform hover:-translate-y-0.5 transition-all text-sm uppercase tracking-widest">
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Security / Password Information -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 h-full">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 tracking-tight">Security Access</h3>
                        <p class="text-gray-400 text-xs font-medium mt-1">Change your login password</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="group">
                        <label for="prof_current_password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1 group-focus-within:text-emerald-500 transition-colors">Current Password</label>
                        <input type="password" name="current_password" id="prof_current_password" placeholder="Confirm current" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:bg-white transition-all outline-none font-semibold">
                    </div>
                    <div class="group">
                        <label for="prof_new_password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1 group-focus-within:text-emerald-500 transition-colors">New Password</label>
                        <input type="password" name="password" id="prof_new_password" placeholder="At least 8 chars" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:bg-white transition-all outline-none font-semibold">
                    </div>
                    <div class="group">
                        <label for="prof_password_confirmation" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1 group-focus-within:text-emerald-500 transition-colors">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="prof_password_confirmation" placeholder="Repeat new" class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:bg-white transition-all outline-none font-semibold">
                    </div>
                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transform hover:-translate-y-0.5 transition-all text-sm uppercase tracking-widest mt-2">
                        Update Password
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-12 p-8 bg-red-50 rounded-[2.5rem] border border-red-100 flex items-center justify-between">
            <div>
                <h4 class="text-lg font-black text-red-600 tracking-tight">Sign Out</h4>
                <p class="text-red-400 text-sm font-medium">Log out of your current session on this device.</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-8 py-4 bg-white text-red-600 font-bold rounded-2xl border border-red-200 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                    Terminate Session
                </button>
            </form>
        </div>
    </div>
@endsection
