<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight drop-shadow-sm">
                    {{ __('Manajemen Pengguna') }}
                </h2>
            </div>
            
            <!-- Top Header: Tabs & Actions -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Tabs Navigation -->
                <div x-data="{ activeTab: '{{ $activeTab }}' }">
                    <div class="sm:hidden mb-4 lg:mb-0">
                        <label for="tabs" class="sr-only">Pilih Tab</label>
                        <select id="tabs" name="tabs" class="block w-full rounded-2xl border-slate-300 py-3 pl-4 pr-10 text-base focus:border-blue-500 focus:ring-blue-500" x-model="activeTab" @change="window.history.replaceState(null, null, '?tab=' + activeTab + '&search={{ request('search') }}&sort={{ request('sort') }}'); $dispatch('tab-changed', activeTab)">
                            <option value="semua">Semua Pengguna</option>
                            <option value="staff">Staff (Admin/Mentor)</option>
                            <option value="siswa">Siswa Terdaftar</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav class="flex space-x-2 bg-white p-2 rounded-[20px] border border-slate-200/80 shadow-sm w-fit" aria-label="Tabs">
                            <button @click="activeTab = 'semua'; window.history.replaceState(null, null, '?tab=semua&search={{ request('search') }}&sort={{ request('sort') }}'); $dispatch('tab-changed', 'semua')"
                                    :class="{'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-700/10': activeTab === 'semua', 'text-slate-500 hover:text-slate-700 hover:bg-slate-50': activeTab !== 'semua'}"
                                    class="px-6 py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center gap-2.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Semua <span class="ml-1 px-2 py-0.5 rounded-md bg-white text-blue-600 text-[11px] border border-blue-100 shadow-sm">{{ $totalSemua }}</span>
                            </button>
                            
                            <button @click="activeTab = 'staff'; window.history.replaceState(null, null, '?tab=staff&search={{ request('search') }}&sort={{ request('sort') }}'); $dispatch('tab-changed', 'staff')"
                                    :class="{'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-700/10': activeTab === 'staff', 'text-slate-500 hover:text-slate-700 hover:bg-slate-50': activeTab !== 'staff'}"
                                    class="px-6 py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center gap-2.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Staff <span class="ml-1 px-2 py-0.5 rounded-md bg-white text-blue-600 text-[11px] border border-blue-100 shadow-sm">{{ $totalStaff }}</span>
                            </button>
                            
                            <button @click="activeTab = 'siswa'; window.history.replaceState(null, null, '?tab=siswa&search={{ request('search') }}&sort={{ request('sort') }}'); $dispatch('tab-changed', 'siswa')"
                                    :class="{'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-700/10': activeTab === 'siswa', 'text-slate-500 hover:text-slate-700 hover:bg-slate-50': activeTab !== 'siswa'}"
                                    class="px-6 py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center gap-2.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                Siswa <span class="ml-1 px-2 py-0.5 rounded-md bg-white text-blue-600 text-[11px] border border-blue-100 shadow-sm">{{ $totalSiswa }}</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Actions: Search & Sort -->
                <div class="flex items-center gap-3 self-end lg:self-auto">
                    <!-- Expandable Search -->
                    <form action="{{ route('admin.users.index') }}" method="GET" x-data="{ searchOpen: '{{ request('search') }}' !== '' }" class="flex items-center">
                        <div @click.away="if($refs.searchInput.value === '') searchOpen = false"
                             class="flex items-center bg-white border shadow-sm rounded-xl overflow-hidden transition-all duration-300 ease-out"
                             :class="searchOpen ? 'w-64 sm:w-80 border-blue-400 ring-4 ring-blue-500/10' : 'w-10 border-slate-200/60 hover:border-blue-300'">
                            <button type="button" @click="if(!searchOpen) { searchOpen = true; $nextTick(() => $refs.searchInput.focus()) } else if ($refs.searchInput.value) { $el.closest('form').submit() }" 
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center transition-colors bg-transparent z-10 cursor-pointer"
                                    :class="searchOpen ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600'">
                                <svg class="w-5 h-5 transition-transform duration-300 ease-out" :class="searchOpen ? 'scale-95' : 'scale-100 hover:scale-110'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                            <input x-ref="searchInput" @keydown.enter="$el.closest('form').submit()" type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." 
                                   class="bg-transparent border-none text-[13px] focus:ring-0 font-medium transition-all duration-300 ease-out flex-1 min-w-0"
                                   :class="searchOpen ? 'opacity-100 pr-3 pl-1 w-full translate-x-0' : 'opacity-0 w-0 p-0 -translate-x-2 pointer-events-none'">
                        </div>
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                    </form>

                    <!-- Sort Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200/60 shadow-sm text-slate-500 rounded-xl hover:text-blue-600 hover:border-blue-300 transition-colors" title="Sortir">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden">
                            <div class="px-4 py-3 text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50/50 border-b border-slate-100">Sortir Berdasarkan</div>
                            <div class="p-2">
                                <a href="?tab={{ $activeTab }}&sort=latest&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'latest' || !request('sort') ? 'opacity-100' : '' }}"></div>
                                    Terbaru
                                </a>
                                <a href="?tab={{ $activeTab }}&sort=oldest&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'oldest' ? 'opacity-100' : '' }}"></div>
                                    Terlama
                                </a>
                                <div class="mt-1 pt-1 border-t border-slate-50">
                                    <a href="?tab={{ $activeTab }}&sort=name_asc&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_asc' ? 'opacity-100' : '' }}"></div>
                                        Nama (A-Z)
                                    </a>
                                    <a href="?tab={{ $activeTab }}&sort=name_desc&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_desc' ? 'opacity-100' : '' }}"></div>
                                        Nama (Z-A)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ activeTab: '{{ $activeTab }}' }" @tab-changed.window="activeTab = $event.detail">

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Enrollment Approvals Banner -->
            <div class="mb-6 bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 lg:p-6 gap-4 relative group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-50 rounded-full blur-3xl pointer-events-none transition-all duration-500 group-hover:bg-blue-100"></div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-[16px] font-bold text-slate-800 leading-tight mb-0.5">Persetujuan Pendaftaran Kelas</h3>
                        <p class="text-[13px] font-medium text-slate-500">Kelola dan verifikasi siswa yang mendaftar ke kelas baru.</p>
                    </div>
                </div>

                <a href="{{ route('admin.enrollments.index') }}" class="relative z-10 shrink-0 inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold text-[13px] text-blue-700 bg-blue-50 hover:bg-blue-600 hover:text-white border border-blue-100 hover:border-blue-600 transition-all duration-300 gap-2 w-full sm:w-auto text-center shadow-sm hover:shadow-md">
                    Lihat Permintaan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @php
                        $tables = [
                            'semua' => $usersSemua,
                            'staff' => $usersStaff,
                            'siswa' => $usersSiswa
                        ];
                    @endphp

                    @foreach($tables as $tabKey => $users)
                    <div x-show="activeTab === '{{ $tabKey }}'" style="display: none;" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan (Role)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Didaftarkan</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-cyan-500 text-white flex items-center justify-center font-bold text-lg">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @foreach($user->roles as $role)
                                                    @php
                                                        $color = 'bg-gray-100 text-gray-800';
                                                        if($role->name == 'super-admin') $color = 'bg-purple-100 text-purple-800';
                                                        if($role->name == 'mentor') $color = 'bg-blue-100 text-blue-800';
                                                        if($role->name == 'agency-staff') $color = 'bg-amber-100 text-amber-800';
                                                    @endphp
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                        {{ $role->label ?? $role->name }}
                                                    </span>
                                                @endforeach
                                                @if($user->roles->isEmpty())
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500">
                                                        Tidak ada
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(in_array($user->id, $onlineUsersIds ?? []))
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                        <span class="relative flex h-2 w-2">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                        </span>
                                                        Online
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-500 border border-gray-200">
                                                        <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                                        Offline
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end gap-2" x-data="{ modalOpen: false }">
                                                    <!-- Info Button -->
                                                    <button @click="modalOpen = true" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors group" title="Lihat Profil">
                                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </button>
                                                    
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors group" title="Edit Pengguna">
                                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    
                                                    @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors group" title="Hapus Pengguna">
                                                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    <!-- Profile Modal Component -->
                                                    <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                        <!-- Backdrop -->
                                                        <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="modalOpen = false"></div>

                                                        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0 pointer-events-none">
                                                            <!-- Modal Panel -->
                                                            <div x-show="modalOpen" x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="pointer-events-auto relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100 flex flex-col max-h-[90vh]">
                                                                
                                                                <!-- Close Button -->
                                                                <div class="absolute top-4 right-4 z-10">
                                                                    <button @click="modalOpen = false" class="p-2 bg-white/50 hover:bg-slate-100 backdrop-blur-sm rounded-full text-slate-500 hover:text-slate-800 transition-colors shadow-sm border border-slate-200/50">
                                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                    </button>
                                                                </div>

                                                                <!-- Avatar & Info -->
                                                                <div class="px-8 pb-8 pt-10 relative flex-1 overflow-y-auto custom-scrollbar text-center">
                                                                    <div class="mx-auto w-24 h-24 mb-5 relative group">
                                                                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-cyan-400 rounded-full blur-md opacity-40 group-hover:opacity-60 transition-opacity"></div>
                                                                        <div class="relative w-full h-full bg-gradient-to-tr from-indigo-600 to-cyan-500 rounded-full flex items-center justify-center text-[40px] font-bold text-white shadow-lg border-4 border-white hover:scale-105 transition-transform duration-300">
                                                                            {{ substr($user->name, 0, 1) }}
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <h3 class="text-2xl font-bold text-slate-800 mb-1 tracking-tight">{{ $user->name }}</h3>
                                                                    <p class="text-slate-500 text-[15px] mb-4">{{ $user->email }}</p>
                                                                    
                                                                    <div class="flex flex-wrap justify-center gap-2 mb-8">
                                                                        @foreach($user->roles as $role)
                                                                            <span class="px-3 py-1 text-[13px] font-bold rounded-lg border {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-200' : ($role->name == 'mentor' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-slate-50 text-slate-700 border-slate-200') }}">
                                                                                {{ $role->label ?? $role->name }}
                                                                            </span>
                                                                        @endforeach
                                                                        @if(in_array($user->id, $onlineUsersIds ?? []))
                                                                            <span class="px-3 py-1 text-[13px] font-bold rounded-lg border bg-emerald-50 text-emerald-700 border-emerald-200 flex items-center gap-1.5">
                                                                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Online
                                                                            </span>
                                                                        @else
                                                                            <span class="px-3 py-1 text-[13px] font-bold rounded-lg border bg-slate-50 text-slate-500 border-slate-200 flex items-center gap-1.5">
                                                                                <span class="w-2 h-2 rounded-full bg-slate-400"></span> Offline
                                                                            </span>
                                                                        @endif
                                                                        <span class="px-3 py-1 text-[13px] font-bold rounded-lg border bg-indigo-50 text-indigo-700 border-indigo-200 flex items-center gap-1.5">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                            Sejak {{ $user->created_at->format('M Y') }}
                                                                        </span>
                                                                    </div>

                                                                    <div class="grid grid-cols-1 gap-4 text-left">
                                                                        @if($user->enrollments->count() > 0)
                                                                        <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-100">
                                                                            <div class="flex items-center gap-2 mb-4">
                                                                                <div class="p-1.5 bg-blue-100 text-blue-600 rounded-lg">
                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                                                </div>
                                                                                <h4 class="font-bold text-[15px] text-slate-800">Kelas Diikuti</h4>
                                                                            </div>
                                                                            <ul class="space-y-3">
                                                                                @foreach($user->enrollments as $enrollment)
                                                                                <li class="flex items-start gap-3 bg-white p-3 rounded-xl border border-slate-200/60 shadow-sm hover:shadow-md transition-shadow">
                                                                                    @if($enrollment->course->thumbnail)
                                                                                        <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="" class="w-12 h-12 rounded-lg object-cover shrink-0">
                                                                                    @else
                                                                                        <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                                                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div>
                                                                                        <p class="text-[14px] font-bold text-slate-800 line-clamp-1 leading-tight mb-1">{{ $enrollment->course->title }}</p>
                                                                                        <span class="text-[12px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">Aktif</span>
                                                                                    </div>
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                        @endif

                                                                        @if($user->orders->count() > 0)
                                                                        <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-100">
                                                                            <div class="flex items-center gap-2 mb-4">
                                                                                <div class="p-1.5 bg-purple-100 text-purple-600 rounded-lg">
                                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                                                </div>
                                                                                <h4 class="font-bold text-[15px] text-slate-800">Pesanan Layanan</h4>
                                                                            </div>
                                                                            <ul class="space-y-3">
                                                                                @foreach($user->orders as $order)
                                                                                <li class="flex items-center justify-between bg-white p-3 rounded-xl border border-slate-200/60 shadow-sm">
                                                                                    <div>
                                                                                        <p class="text-[14px] font-bold text-slate-800 mb-0.5">{{ $order->service->name ?? 'Layanan' }}</p>
                                                                                        <p class="text-[12px] text-slate-500">{{ $order->created_at->format('d M Y') }}</p>
                                                                                    </div>
                                                                                    <span class="text-[12px] font-bold px-2.5 py-1 rounded-md border 
                                                                                        {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                                                                        ($order->status === 'pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-slate-50 text-slate-700 border-slate-200') }}">
                                                                                        {{ ucfirst($order->status) }}
                                                                                    </span>
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 whitespace-nowrap">
                                                <div class="flex flex-col items-center justify-center text-center">
                                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                    </div>
                                                    <h3 class="text-sm font-medium text-gray-900">Belum ada pengguna</h3>
                                                    <p class="mt-1 text-sm text-gray-500">Tidak ada data pengguna yang ditemukan untuk tab ini.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button for New User -->
    <div x-data="{ scrolled: false, show: false }"
         x-init="
            if (document.referrer.split('?')[0] === window.location.href.split('?')[0] && document.referrer !== '') {
                show = true;
            } else {
                setTimeout(() => show = true, 500);
            }
         "
         x-show="show"
         @scroll.window="scrolled = (window.pageYOffset > 50)"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
         class="fixed bottom-5 left-[4.25rem] sm:left-auto sm:bottom-10 sm:right-10 z-[9999]" style="display: none; bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
        <a href="{{ route('admin.users.create') }}" 
           class="flex items-center h-11 w-11 sm:h-14 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 sm:hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] overflow-hidden"
           :class="scrolled ? 'w-11 sm:w-14' : 'w-11 sm:w-[215px]'">
            <div class="flex items-center justify-center w-11 h-11 sm:w-14 sm:h-14 shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <span class="hidden sm:inline font-bold text-[16px] whitespace-nowrap transition-opacity duration-500 pl-1 pr-6" :class="scrolled ? 'opacity-0' : 'opacity-100 delay-200'">Tambah Pengguna</span>
        </a>
    </div>
</x-app-layout>
