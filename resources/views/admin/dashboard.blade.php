<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div class="-mt-[105px] bg-apple-parchment dark:bg-black min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-16 lg:pb-0 lg:h-screen" x-data="revenueChart()">
                
                <!-- Left Column -->
                <div class="lg:order-2 lg:col-span-2 space-y-8 lg:overflow-y-auto lg:pr-4 scrollbar-hide pt-[125px] pb-20 lg:pb-8">



            <!-- STAT CARDS ROW (3 columns) -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">

                <!-- Academy Card -->
                <div class="group relative bg-gradient-to-br from-white to-slate-50/50 rounded-[20px] p-5 border border-slate-200/60 hover:border-blue-300/80 hover:-translate-y-1 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-[0_8px_20px_rgba(59,130,246,0.05)]"
                   x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                   x-show="show"
                   x-transition:enter="transition ease-out duration-300 transform"
                   x-transition:enter-start="opacity-0 translate-y-2"
                   x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="absolute -right-10 -top-10 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <a href="{{ route('admin.courses.index') }}" class="block relative z-10">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Academy</p>
                            <span class="text-blue-500 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804z" /></svg>
                            </span>
                        </div>
                        
                        <!-- Metric -->
                        <div class="flex items-baseline gap-1.5 mb-4">
                            <h3 class="text-[28px] font-black text-slate-800 tracking-tight leading-none">{{ $activeCourses ?? 0 }}</h3>
                            <p class="text-[12px] font-bold text-slate-500">Kelas Aktif</p>
                        </div>

                        <!-- Footer Info -->
                        <div class="flex items-center gap-3 text-[11px] text-slate-500 font-bold mt-3 pt-3 border-t border-slate-100">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-500/80" fill="currentColor" viewBox="0 0 20 20"><path d="M10.384 1.108a.75.75 0 00-.768 0l-7.5 4.09A.75.75 0 002.5 5.86v4.75a.75.75 0 001.5 0v-4.1l2.5 1.363v4.613c0 .324.21.613.518.706 2.015.614 4.032.614 6.048 0a.75.75 0 00.518-.706V7.873l2.5-1.363v4.1a.75.75 0 001.5 0v-4.75a.75.75 0 00-.384-.662l-7.5-4.09z" /><path d="M10 13a4.978 4.978 0 00-3 .994v1.756A4.978 4.978 0 0010 16.75a4.978 4.978 0 003-.994v-1.756A4.978 4.978 0 0010 13z" /></svg>
                                {{ $activeStudents ?? 0 }} Siswa
                            </span>
                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-blue-500/80" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                {{ $activeMentors ?? 0 }} Mentor
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Agency Card -->
                <div class="group relative bg-gradient-to-br from-white to-slate-50/50 rounded-[20px] p-5 border border-slate-200/60 hover:border-orange-300/80 hover:-translate-y-1 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-[0_8px_20px_rgba(249,115,22,0.05)]"
                   x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
                   x-show="show"
                   x-transition:enter="transition ease-out duration-300 transform"
                   x-transition:enter-start="opacity-0 translate-y-2"
                   x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="absolute -right-10 -top-10 w-24 h-24 bg-orange-500/5 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <a href="{{ route('admin.services.index') }}" class="block relative z-10">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-3">
                            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Agency</p>
                            <span class="text-orange-500 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1.5 8.075c.164.015.328.025.493.03a11.95 11.95 0 002.014 0c.165-.005.33-.015.493-.03A21.95 21.95 0 0019 11.75V16a2 2 0 01-2 2H3a2 2 0 01-2-2v-4.25c.622.38 1.294.706 2 .969V12a1 1 0 102 0v-.375a23.44 23.44 0 004.5.45z" clip-rule="evenodd" /></svg>
                            </span>
                        </div>
                        
                        <!-- Metric -->
                        <div class="flex items-baseline gap-1.5 mb-4">
                            <h3 class="text-[28px] font-black text-slate-800 tracking-tight leading-none">{{ $activeServices ?? 0 }}</h3>
                            <p class="text-[12px] font-bold text-slate-500">Layanan Aktif</p>
                        </div>

                        <!-- Footer Info -->
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-500 font-bold mt-3 pt-3 border-t border-slate-100 h-[33px]">
                            <svg class="w-3.5 h-3.5 text-orange-500/80" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>
                            {{ $processingOrders ?? 0 }} Sedang Diproses
                        </div>
                    </a>
                </div>

                <!-- Users Activity Card -->
                <div class="group relative bg-gradient-to-br from-white to-slate-50/50 rounded-[20px] p-5 border border-slate-200/60 hover:border-emerald-300/80 hover:-translate-y-1 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-[0_8px_20px_rgba(16,185,129,0.05)]"
                   x-data="{ 
                       show: false,
                       onlineUsers: {{ json_encode($onlineUsers->map(function($u) {
                           $roleName = $u->roles->first()?->name;
                           $roleLabel = match($roleName) {
                               'super-admin' => 'Admin',
                               'mentor' => 'Mentor',
                               'agency-staff' => 'Staff',
                               'member' => 'Member',
                               default => 'User'
                           };
                           return [
                               'id' => $u->id,
                               'name' => $u->name,
                               'email' => $u->email,
                               'avatar' => $u->avatar ? asset('storage/' . $u->avatar) : null,
                               'initial' => strtoupper(substr($u->name, 0, 1)),
                               'role' => $roleLabel,
                           ];
                       })) }},
                       get onlineCount() { return this.onlineUsers.length; },
                       fetchOnlineUsers() {
                           fetch('{{ route('admin.online-users') }}')
                               .then(res => res.json())
                               .then(data => {
                                   this.onlineUsers = data.users;
                               })
                               .catch(err => console.error(err));
                       }
                   }" 
                   x-init="
                       setTimeout(() => show = true, 50);
                       setInterval(() => fetchOnlineUsers(), 10000);
                       if(window.Echo) {
                           window.Echo.join('online-users')
                               .here((users) => {
                                   this.onlineUsers = users.map(u => ({
                                       id: u.id,
                                       name: u.name,
                                       email: u.email || '',
                                       avatar: u.avatar || null,
                                       initial: u.name ? u.name.substring(0, 1).toUpperCase() : 'U',
                                       role: u.role || 'User'
                                   }));
                               })
                               .joining((user) => {
                                   if (!this.onlineUsers.find(u => u.id === user.id)) {
                                       this.onlineUsers.push({
                                           id: user.id,
                                           name: user.name,
                                           email: user.email || '',
                                           avatar: user.avatar || null,
                                           initial: user.name ? user.name.substring(0, 1).toUpperCase() : 'U',
                                           role: user.role || 'User'
                                       });
                                   }
                               })
                               .leaving((user) => {
                                   this.onlineUsers = this.onlineUsers.filter(u => u.id !== user.id);
                               });
                       }
                   "
                   x-show="show"
                   x-transition:enter="transition ease-out duration-300 transform"
                   x-transition:enter-start="opacity-0 translate-y-2"
                   x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="absolute -right-10 -top-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <a href="{{ route('admin.users.index') }}" class="block relative z-10">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-1.5">
                                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Aktivitas</p>
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                </span>
                            </div>
                            <span class="text-emerald-500 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                            </span>
                        </div>
                        
                        <!-- Metric -->
                        <div class="flex items-baseline gap-1.5 mb-4">
                            <h3 class="text-[28px] font-black text-slate-800 tracking-tight leading-none" x-text="onlineCount"></h3>
                            <p class="text-[12px] font-bold text-slate-500">Sedang Aktif</p>
                        </div>

                        <!-- Footer Info (Avatar Stack) -->
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-100 h-[33px]">
                            <!-- Stack -->
                            <div class="flex -space-x-1.5 py-0.5 pl-1.5">
                                <template x-for="user in onlineUsers.slice(0, 5)" :key="user.id">
                                    <div class="relative inline-block">
                                        <template x-if="user.avatar">
                                            <img :src="user.avatar" class="w-6 h-6 rounded-full object-cover border-2 border-white ring-1 ring-slate-100" :title="user.name + ' (' + user.role + ')'">
                                        </template>
                                        <template x-if="!user.avatar">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center text-[9px] font-black border-2 border-white ring-1 ring-slate-100" :title="user.name + ' (' + user.role + ')'" x-text="user.initial"></div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="onlineCount > 5">
                                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[8px] font-bold border-2 border-white ring-1 ring-slate-100" x-text="'+' + (onlineCount - 5)"></div>
                                </template>
                            </div>
                            
                            <!-- Status Text -->
                            <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider" x-show="onlineCount > 0">Live</span>
                            <span class="text-[11px] font-medium text-slate-400 italic" x-show="onlineCount === 0">Sepi saat ini</span>
                        </div>
                    </a>
                </div>

            </div>

            <!-- CHART MODAL POPUP -->
                <div x-show="isChartModalOpen" 
                     class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                     x-cloak>
                    <!-- Backdrop -->
                    <div x-show="isChartModalOpen" 
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
                         @click="isChartModalOpen = false"></div>

                    <!-- Modal Content -->
                    <div x-show="isChartModalOpen"
                         x-transition:enter="ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="ease-in duration-200 transform"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                         class="relative w-full max-w-4xl bg-white rounded-[24px] shadow-2xl border border-slate-100 overflow-hidden"
                         @click.stop>
                        
                        <!-- Modal Header -->
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="text-[18px] font-bold text-slate-900 flex items-center gap-2">
                                Grafik Pendapatan
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] uppercase font-bold px-2 py-0.5 rounded-md">Bulan Ini</span>
                            </h3>
                            <button @click="isChartModalOpen = false" class="text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 rounded-full p-2 transition-colors border border-slate-200/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 relative">
                            <!-- Background ambient inside modal -->
                            <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

                            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 relative z-10">
                                <div>
                                    <div class="flex items-end gap-6">
                                        <div>
                                            <p class="text-[13px] text-slate-500 font-medium mb-1">Total Pendapatan</p>
                                            <h3 class="text-[32px] font-black text-slate-900 leading-none tracking-tight">Rp{{ number_format($revenueThisMonth ?? 0, 0, ',', '.') }}</h3>
                                        </div>
                                        <div class="pb-1 border-l border-slate-200 pl-6">
                                            <p class="text-[13px] text-slate-500 font-medium mb-1">Pesanan Selesai</p>
                                            <h3 class="text-[20px] font-bold text-slate-800 leading-none">{{ $completedOrdersThisMonth ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- View Toggles -->
                                <div class="mt-4 md:mt-0 flex p-1 bg-slate-100 rounded-lg">
                                    <button @click="setView('month')" :class="view === 'month' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-1.5 text-[13px] font-bold rounded-md transition-all">Bulanan</button>
                                    <button @click="setView('week')" :class="view === 'week' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-1.5 text-[13px] font-bold rounded-md transition-all">Mingguan</button>
                                </div>
                            </div>

                            <!-- Chart Container -->
                            <div class="relative z-10 w-full h-[350px]">
                                <div id="revenueChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Recent Orders Table -->
                    <div class="bg-white dark:bg-slate-900 rounded-[20px] border border-slate-200/80 dark:border-slate-800/80 overflow-hidden"
                         x-data="{ show: false }" x-init="setTimeout(() => show = true, 250)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800/50 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-teal-600 dark:text-teal-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2v10h8V8h-3a1 1 0 01-1-1V4H6z" clip-rule="evenodd" /></svg>
                            </span>
                            <h3 class="text-[15px] font-bold text-slate-900 dark:text-slate-100">Pesanan Terbaru</h3>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 dark:text-blue-400 text-[13px] font-bold hover:text-blue-800 dark:hover:text-blue-300 transition-colors flex items-center gap-1">
                            Lihat Semua
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800/50">
                                    <th class="px-5 py-3 text-left text-[11px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">No Pesanan</th>
                                    <th class="px-5 py-3 text-left text-[11px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-5 py-3 text-left text-[11px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Total</th>
                                    <th class="px-5 py-3 text-left text-[11px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 text-left text-[11px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Estimasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800/30">
                                @forelse($recentOrders ?? [] as $order)
                                    <tr class="hover:bg-slate-50/40 dark:hover:bg-slate-800/20 transition-colors duration-200 cursor-pointer" onclick="window.location.href='{{ route('admin.orders.show', $order) }}'">
                                        <!-- Order Number -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A1.996 1.996 0 012 8V4a2 2 0 012-2h4c.53 0 1.039.21 1.414.586l7 7zM6 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                                                <span class="text-[14px] font-semibold text-slate-900 dark:text-slate-100">#{{ $order->order_number }}</span>
                                            </div>
                                        </td>
                                        <!-- Customer -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                                <span class="text-[14px] text-slate-655 dark:text-slate-300 truncate max-w-[150px]" title="{{ $order->customer_name }}">{{ $order->customer_name }}</span>
                                            </div>
                                        </td>
                                        <!-- Total -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                                                <span class="text-[14px] font-semibold text-slate-900 dark:text-slate-100">Rp{{ number_format($order->total_amount ?? $order->amount, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                        <!-- Status -->
                                        <td class="px-5 py-4 font-semibold">
                                            @php
                                                $statusColors = [
                                                    'completed' => 'bg-emerald-55 bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400',
                                                    'paid' => 'bg-blue-55 bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                                                    'processing' => 'bg-blue-55 bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
                                                    'pending' => 'bg-amber-55 bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
                                                    'cancelled' => 'bg-red-55 bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400',
                                                ];
                                                $colorClass = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400';
                                            @endphp
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $colorClass }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <!-- Estimation -->
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1-1H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V2a1 1 0 00-1-1h-2a1 1 0 00-1 1v1h-3V2a1 1 0 00-1-1H9a1 1 0 00-1 1v1H6V2zm8 6a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm-3 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zm-3 0a1 1 0 011-1h1a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                                                <div class="text-[13px] text-slate-600 dark:text-slate-300 leading-tight">
                                                    @if($order->estimation_date)
                                                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ \Carbon\Carbon::parse($order->estimation_date)->translatedFormat('d M Y') }}</span>
                                                        <span class="text-[11px] text-slate-400 dark:text-slate-500 block">{{ \Carbon\Carbon::parse($order->estimation_date)->translatedFormat('H:i') }} WIB</span>
                                                    @else
                                                        <span class="text-slate-400 dark:text-slate-500 italic">Belum diatur</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-12 text-center">
                                            <div class="w-10 h-10 bg-slate-50 dark:bg-slate-800/50 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                <svg class="w-5 h-5 text-slate-300 dark:text-slate-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7H5V5z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <p class="text-slate-400 dark:text-slate-500 text-[13px] font-medium">Belum ada pesanan terbaru</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>

                <!-- Right Column Sidebar: Users + CMS -->
                <div class="lg:order-1 space-y-6 lg:h-full lg:overflow-y-auto lg:pr-4 scrollbar-hide pt-[125px] pb-20 lg:pb-8">

                    <!-- CLOCK WIDGET (Compact for Sidebar) -->
                    <div x-data="clockWidget()" x-init="initClock()" 
                         class="relative rounded-[20px] overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-6 border border-white/5"
                         x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                         
                        <!-- Ambient Glow -->
                        <div class="absolute -top-10 -right-10 w-[200px] h-[200px] bg-blue-500/20 rounded-full blur-[60px] pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-[150px] h-[150px] bg-purple-500/15 rounded-full blur-[50px] pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Greeting & Name -->
                            <div class="mb-4">
                                <p class="text-blue-400 text-[11px] font-bold uppercase tracking-widest mb-1">
                                    <span x-text="greeting"></span>
                                </p>
                                <h2 class="text-[24px] font-bold text-white leading-tight tracking-tight">
                                    {{ explode(' ', Auth::user()->name)[0] }}<span class="text-blue-400">.</span>
                                </h2>
                            </div>

                            <!-- Time & Date (Stacked) -->
                            <div class="flex items-end justify-between border-t border-white/10 pt-4 mt-2">
                                <div>
                                    <p class="text-slate-400 text-[12px] uppercase tracking-wider mb-0.5" x-text="dateString"></p>
                                    <p class="text-slate-500 text-[10px] uppercase tracking-wider font-semibold">Local Time</p>
                                </div>
                                <div class="text-[36px] font-bold text-white leading-none tracking-tight tabular-nums" x-text="timeString"></div>
                            </div>
                        </div>
                    </div>

                    <!-- REVENUE WIDGET (Clock Style) -->
                    <div class="relative rounded-[20px] overflow-hidden bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 p-6 border border-white/5 cursor-pointer group transition-all duration-300"
                         x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                         x-show="show"
                         x-transition:enter="transition ease-out duration-500 transform"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         @click="window.location.href='{{ route('admin.finances.index') }}'">
                         
                        <!-- Ambient Glow -->
                        <div class="absolute -top-10 -right-10 w-[200px] h-[200px] bg-emerald-500/20 rounded-full blur-[60px] pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-[150px] h-[150px] bg-teal-500/15 rounded-full blur-[50px] pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Header & Icon -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-emerald-400 text-[11px] font-bold uppercase tracking-widest mb-1 flex items-center gap-1.5">
                                        Pendapatan
                                        <span class="bg-emerald-500/20 text-emerald-300 text-[8px] px-1.5 py-0.5 rounded-sm">Bulan Ini</span>
                                    </p>
                                    <h2 class="text-[28px] font-bold text-white leading-tight tracking-tight">
                                        Rp{{ number_format($revenueThisMonth ?? 0, 0, ',', '.') }}
                                    </h2>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10 group-hover:bg-emerald-500/20 group-hover:border-emerald-500/30 transition-all duration-300">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                            </div>

                            <!-- Footer (Orders & Expand) -->
                            <div class="flex items-end justify-between border-t border-white/10 pt-4 mt-2">
                                <div>
                                    <p class="text-emerald-200/60 text-[12px] uppercase tracking-wider mb-0.5 font-semibold">Pesanan Selesai</p>
                                    <div class="text-[20px] font-bold text-emerald-50 leading-none tabular-nums">{{ $completedOrdersThisMonth ?? 0 }}</div>
                                </div>
                                <button @click.stop="openModal()" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/10 flex items-center justify-center text-emerald-200 hover:text-white transition-colors border border-white/10 group-hover:border-emerald-400/30" title="Buka Grafik">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- Pending Enrollments Widget -->
                    @if(isset($pendingEnrollments) && $pendingEnrollments->count() > 0)
                    <a href="{{ route('admin.enrollments.index') }}" class="group block bg-white rounded-[20px] p-6 border border-slate-200/80 hover:border-blue-300 transition-all duration-300 relative overflow-hidden">
                        <!-- Glow effect -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
                        
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-[16px] font-bold text-slate-900 leading-tight">Persetujuan Kelas</h3>
                                    <p class="text-[12px] text-slate-500 font-medium">Menunggu Verifikasi</p>
                                </div>
                            </div>
                            <span class="bg-red-500 text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow-sm">{{ $pendingEnrollments->count() }} BARU</span>
                        </div>
                        
                        <div class="relative z-10">
                            <div class="flex -space-x-2 mb-4">
                                @foreach($pendingEnrollments->take(5) as $enrollment)
                                    <div class="relative w-8 h-8 rounded-full ring-2 ring-white overflow-hidden bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-600" title="{{ $enrollment->user->name }}">
                                        @if($enrollment->user->avatar)
                                            <img src="{{ asset('storage/' . $enrollment->user->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($enrollment->user->name, 0, 1) }}
                                        @endif
                                    </div>
                                @endforeach
                                @if($pendingEnrollments->count() > 5)
                                    <div class="relative w-8 h-8 rounded-full ring-2 ring-white bg-slate-50 flex items-center justify-center text-[10px] font-bold text-slate-500 border border-slate-200">
                                        +{{ $pendingEnrollments->count() - 5 }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center text-blue-600 text-[13px] font-bold gap-1 group-hover:text-blue-700 transition-colors">
                                Tinjau Sekarang
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>
                    @endif

                    <!-- Pending Orders Alert -->
                    @if(($pendingOrders ?? 0) > 0)
                    <a href="{{ route('admin.orders.index') }}?status=pending" class="group block bg-white rounded-[20px] p-6 border border-slate-200/80 hover:border-amber-300 transition-all duration-300 relative overflow-hidden"
                       x-data="{ 
                           pendingOrders: {{ $pendingOrders ?? 0 }},
                           init() {
                               if (window.Echo) {
                                   window.Echo.private('admin.dashboard')
                                       .listen('OrderPaid', (e) => {
                                           this.pendingOrders++;
                                       })
                                       .listen('NewServiceOrder', (e) => {
                                           this.pendingOrders++;
                                       });
                               }
                           }
                       }"
                       x-show="pendingOrders > 0">
                        <!-- Glow effect -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                        
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-[16px] font-bold text-slate-900 leading-tight">Menunggu Tindakan</h3>
                                    <p class="text-[12px] text-slate-500 font-medium">Konfirmasi Pembayaran</p>
                                </div>
                            </div>
                            <span class="bg-amber-500 text-white text-[11px] font-black px-2 py-0.5 rounded-full shadow-sm"><span x-text="pendingOrders"></span> PESANAN</span>
                        </div>
                        
                        <div class="relative z-10">
                            <p class="text-[13px] text-slate-500 mb-4">Ada <strong class="text-slate-700">{{ $pendingOrders }}</strong> pesanan layanan yang perlu ditinjau dan diproses.</p>
                            <div class="flex items-center text-amber-600 text-[13px] font-bold gap-1 group-hover:text-amber-700 transition-colors">
                                Proses Sekarang
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>
                    @endif

                    <!-- Personalisasi Link Card -->
                    <a href="{{ route('settings.landing') }}" class="group block bg-gradient-to-br from-slate-800 to-slate-900 rounded-[20px] p-6 border border-white/5 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" /></svg>
                            </div>
                            <h3 class="text-[16px] font-bold text-white">Personalisasi</h3>
                        </div>
                        <p class="text-[13px] text-slate-400">Atur tampilan platform mulai dari warna tema, logo, teks background login, slide hero, hingga tata letak struk.</p>
                        <div class="mt-4 flex items-center text-blue-400 text-[13px] font-semibold gap-1 group-hover:text-blue-300 transition-colors">
                            Atur Personalisasi
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

    <!-- Clock Widget Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('revenueChart', () => ({
                isChartModalOpen: false,
                chartRendered: false,
                view: 'month',
                chart: null,
                monthlyData: {!! $monthlyOrderData ?? '[]' !!},
                weeklyData: {!! $weeklyOrderData ?? '[]' !!},
                weeklyLabels: {!! $weeklyLabels ?? '[]' !!},
                
                openModal() {
                    this.isChartModalOpen = true;
                    if (!this.chartRendered) {
                        setTimeout(() => {
                            this.initChart();
                            this.chartRendered = true;
                        }, 100);
                    }
                },

                initChart() {
                    if (typeof ApexCharts === 'undefined') {
                        setTimeout(() => this.initChart(), 200);
                        return;
                    }
                    const options = {
                        series: [{
                            name: 'Pesanan Selesai',
                            data: this.monthlyData
                        }],
                        chart: {
                            type: 'area',
                            height: 300,
                            fontFamily: 'Inter, sans-serif',
                            toolbar: { show: false },
                            zoom: { enabled: false },
                            background: 'transparent'
                        },
                        colors: ['#10B981'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0,
                                stops: [0, 100]
                            }
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: { style: { colors: '#94A3B8', fontSize: '12px', fontWeight: 500 } }
                        },
                        yaxis: {
                            labels: { 
                                style: { colors: '#94A3B8', fontSize: '12px', fontWeight: 500 },
                                formatter: function(val) { return Math.floor(val); }
                            }
                        },
                        grid: {
                            borderColor: '#F1F5F9',
                            strokeDashArray: 4,
                            yaxis: { lines: { show: true } },
                            xaxis: { lines: { show: false } },
                            padding: { top: 0, right: 0, bottom: 0, left: 10 }
                        },
                        tooltip: {
                            theme: 'light',
                            y: { formatter: function (val) { return val + " pesanan" } }
                        }
                    };

                    this.chart = new ApexCharts(document.querySelector("#revenueChart"), options);
                    this.chart.render();
                },
                
                setView(newView) {
                    this.view = newView;
                    if (newView === 'month') {
                        this.chart.updateSeries([{ data: this.monthlyData }]);
                        this.chart.updateOptions({ xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'] } });
                    } else {
                        this.chart.updateSeries([{ data: this.weeklyData }]);
                        this.chart.updateOptions({ xaxis: { categories: this.weeklyLabels } });
                    }
                }
            }));

            Alpine.data('clockWidget', () => ({
                timeString: '',
                dateString: '',
                greeting: '',
                
                initClock() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                },
                
                updateClock() {
                    const now = new Date();
                    
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    this.timeString = `${hours}:${minutes}`;
                    
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    this.dateString = now.toLocaleDateString('id-ID', options);
                    
                    const hour = now.getHours();
                    if (hour >= 5 && hour < 11) this.greeting = 'Selamat Pagi';
                    else if (hour >= 11 && hour < 15) this.greeting = 'Selamat Siang';
                    else if (hour >= 15 && hour < 18) this.greeting = 'Selamat Sore';
                    else this.greeting = 'Selamat Malam';
                }
            }));
        });
    </script>
</x-app-layout>
