<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            Leaderboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Podium -->
            <div class="mb-12">
                <div class="flex flex-col md:flex-row justify-center items-end gap-4 md:gap-8 min-h-[300px]">
                    <!-- Rank 2 -->
                    @if(isset($topThree[1]))
                    <div class="flex flex-col items-center w-full md:w-1/4 order-2 md:order-1">
                        <div class="relative mb-4">
                            <img src="{{ $topThree[1]->user->avatar ? asset('storage/'.$topThree[1]->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($topThree[1]->user->name) }}" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-slate-300 object-cover">
                            <div class="absolute -bottom-3 -right-3 w-8 h-8 bg-slate-300 rounded-full flex items-center justify-center text-white font-bold border-2 border-white">2</div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-center line-clamp-1">{{ $topThree[1]->user->name }}</h3>
                        <p class="text-sm font-semibold text-slate-500 mb-2">{{ $topThree[1]->total_points }} pts</p>
                        <div class="w-full bg-slate-200 h-32 rounded-t-xl flex items-end justify-center pb-4">
                            <span class="text-4xl">🥈</span>
                        </div>
                    </div>
                    @endif

                    <!-- Rank 1 -->
                    @if(isset($topThree[0]))
                    <div class="flex flex-col items-center w-full md:w-1/3 order-1 md:order-2">
                        <div class="relative mb-4">
                            <img src="{{ $topThree[0]->user->avatar ? asset('storage/'.$topThree[0]->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($topThree[0]->user->name) }}" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-yellow-400 object-cover shadow-lg shadow-yellow-200">
                            <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-3xl">👑</div>
                            <div class="absolute -bottom-3 -right-3 w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white font-bold border-2 border-white text-lg">1</div>
                        </div>
                        <h3 class="font-bold text-lg text-slate-800 text-center line-clamp-1">{{ $topThree[0]->user->name }}</h3>
                        <p class="text-sm font-bold text-yellow-600 mb-2">{{ $topThree[0]->total_points }} pts</p>
                        <div class="w-full bg-gradient-to-t from-yellow-300 to-yellow-100 h-40 rounded-t-xl shadow-inner flex items-end justify-center pb-6">
                            <span class="text-5xl">🥇</span>
                        </div>
                    </div>
                    @endif

                    <!-- Rank 3 -->
                    @if(isset($topThree[2]))
                    <div class="flex flex-col items-center w-full md:w-1/4 order-3 md:order-3">
                        <div class="relative mb-4">
                            <img src="{{ $topThree[2]->user->avatar ? asset('storage/'.$topThree[2]->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($topThree[2]->user->name) }}" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-amber-600 object-cover">
                            <div class="absolute -bottom-3 -right-3 w-8 h-8 bg-amber-600 rounded-full flex items-center justify-center text-white font-bold border-2 border-white">3</div>
                        </div>
                        <h3 class="font-bold text-slate-800 text-center line-clamp-1">{{ $topThree[2]->user->name }}</h3>
                        <p class="text-sm font-semibold text-slate-500 mb-2">{{ $topThree[2]->total_points }} pts</p>
                        <div class="w-full bg-amber-100 h-24 rounded-t-xl flex items-end justify-center pb-2">
                            <span class="text-4xl">🥉</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Peringkat</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kursus Selesai</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Rata-rata Kuis</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($others as $index => $score)
                            <tr class="hover:bg-slate-50 transition-colors {{ $score->user_id == auth()->id() ? 'bg-indigo-50/50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                    {{ $index + 4 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $score->user->avatar ? asset('storage/'.$score->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($score->user->name) }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-slate-900">{{ $score->user->name }}</div>
                                            @if($score->user_id == auth()->id())
                                                <div class="text-xs text-indigo-600 font-semibold">Anda</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $score->courses_completed }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ number_format($score->quiz_avg_score, 1) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                    {{ number_format($score->total_points) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">
                                    Belum ada data peringkat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
