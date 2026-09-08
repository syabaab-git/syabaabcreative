<x-front-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="mb-12 text-center">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Hasil Pencarian</h1>
                @if($query)
                    <p class="mt-4 text-lg text-slate-500">
                        Menampilkan hasil pencarian untuk: <span class="font-bold text-blue-600">"{{ $query }}"</span>
                    </p>
                @else
                    <p class="mt-4 text-lg text-slate-500">
                        Silakan masukkan kata kunci pada kolom pencarian di atas.
                    </p>
                @endif
            </div>

            @if($query)
                @if(auth()->check() && auth()->user()->hasRole('super-admin'))
                <!-- Users Results -->
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm mr-3">{{ $users->count() }}</span>
                            Pengguna
                        </h2>
                    </div>
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($users as $u)
                                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold mr-4">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-900">{{ $u->name }}</h3>
                                        <p class="text-sm text-slate-500">{{ $u->email }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada pengguna</h3>
                            <p class="mt-1 text-sm text-slate-500">Maaf, kami tidak menemukan pengguna yang cocok.</p>
                        </div>
                    @endif
                </div>
                @endif

                @if(!auth()->check() || !auth()->user()->hasRole('agency-staff'))
                <!-- Courses Results -->
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm mr-3">{{ $courses->count() }}</span>
                            Creative Class
                        </h2>
                        @if($courses->count() > 0)
                            <a href="{{ route('courses.index', ['search' => $query]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Semua Kelas &rarr;</a>
                        @endif
                    </div>

                    @if($courses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($courses as $course)
                                <a href="{{ route('courses.show', $course->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col h-full transform hover:-translate-y-1">
                                    <div class="relative h-48 bg-slate-200 overflow-hidden">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-700 shadow-sm">
                                            {{ $course->category->name }}
                                        </div>
                                    </div>
                                    <div class="p-6 flex-1 flex flex-col">
                                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $course->title }}</h3>
                                        <p class="mt-2 text-slate-500 line-clamp-2 text-sm flex-1">{{ $course->description }}</p>
                                        <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                                                    {{ substr($course->mentor->name, 0, 1) }}
                                                </div>
                                                <span class="ml-2 text-sm font-medium text-slate-600">{{ $course->mentor->name }}</span>
                                            </div>
                                            <div class="font-bold text-lg text-slate-900">
                                                Rp {{ number_format($course->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada kursus</h3>
                            <p class="mt-1 text-sm text-slate-500">Maaf, kami tidak menemukan kursus yang cocok dengan pencarian Anda.</p>
                        </div>
                    @endif
                </div>
                @endif

                @if(!auth()->check() || auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('agency-staff'))
                <!-- Services Results -->
                <div>
                    <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm mr-3">{{ $services->count() }}</span>
                            Agency Services
                        </h2>
                        @if($services->count() > 0)
                            <a href="{{ route('services.index', ['search' => $query]) }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">Lihat Semua Layanan &rarr;</a>
                        @endif
                    </div>

                    @if($services->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($services as $service)
                                <a href="{{ route('services.show', $service->slug) }}" class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 flex flex-col h-full transform hover:-translate-y-1">
                                    <div class="relative h-48 bg-slate-200 overflow-hidden">
                                        @if($service->thumbnail)
                                            <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-orange-700 shadow-sm">
                                            {{ $service->category->name }}
                                        </div>
                                    </div>
                                    <div class="p-6 flex-1 flex flex-col">
                                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-orange-600 transition-colors">{{ $service->name }}</h3>
                                        <p class="mt-2 text-slate-500 line-clamp-2 text-sm flex-1">{{ $service->description }}</p>
                                        <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between">
                                            <div class="text-sm font-medium text-slate-500 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $service->estimated_days }} Hari
                                            </div>
                                            <div class="font-bold text-lg text-slate-900">
                                                Mulai Rp {{ number_format($service->base_price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada layanan</h3>
                            <p class="mt-1 text-sm text-slate-500">Maaf, kami tidak menemukan layanan yang cocok dengan pencarian Anda.</p>
                        </div>
                    @endif
                </div>
                @endif

                @if(auth()->check() && (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('agency-staff')))
                <!-- Orders Results -->
                <div class="mb-16 mt-16">
                    <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm mr-3">{{ $orders->count() }}</span>
                            Pesanan (Orders)
                        </h2>
                    </div>
                    @if($orders->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($orders as $order)
                                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-900">{{ $order->order_number }}</h3>
                                            <p class="text-sm text-slate-500">{{ $order->customer_name }} ({{ $order->email }})</p>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-slate-100 text-slate-600">{{ $order->status }}</span>
                                    </div>
                                    <p class="text-sm text-slate-600">Paket: {{ $order->package_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada pesanan</h3>
                        </div>
                    @endif
                </div>

                <!-- Projects Results -->
                <div class="mb-16 mt-16">
                    <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-800 flex items-center">
                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm mr-3">{{ $projects->count() }}</span>
                            Proyek (Projects)
                        </h2>
                    </div>
                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($projects as $project)
                                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $project->title }}</h3>
                                    <div class="w-full bg-slate-200 rounded-full h-2.5 mb-4">
                                      <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                                    </div>
                                    <p class="text-xs text-slate-500">Status: {{ $project->status }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
                            <h3 class="mt-2 text-sm font-medium text-slate-900">Tidak ada proyek</h3>
                        </div>
                    @endif
                </div>
                @endif
            @endif

        </div>
    </div>
</x-front-layout>
