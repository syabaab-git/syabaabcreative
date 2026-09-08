<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                    Peserta Kelas: {{ $course->title }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border border-slate-200/60 rounded-[24px]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/80">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Peserta</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Kontak</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Peran</th>
                                <th scope="col" class="px-6 py-5 text-right text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Bergabung</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            <!-- Mentor Row -->
                            @if($course->mentor)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-200 group bg-indigo-50/30">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        @if($course->mentor->avatar)
                                            <img src="{{ asset('storage/' . $course->mentor->avatar) }}" alt="{{ $course->mentor->name }}" class="w-10 h-10 rounded-full object-cover border border-indigo-200 shadow-sm">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold border border-indigo-200 shadow-sm">
                                                {{ substr($course->mentor->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-[14px] font-bold text-slate-800">{{ $course->mentor->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-[13px] font-medium text-slate-600">{{ $course->mentor->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                        Mentor
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-[13px] font-semibold text-slate-800">-</div>
                                </td>
                            </tr>
                            @endif

                            <!-- Students Rows -->
                            @forelse ($enrollments as $enrollment)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            @if($enrollment->user->avatar)
                                                <img src="{{ asset('storage/' . $enrollment->user->avatar) }}" alt="{{ $enrollment->user->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200 shadow-sm">
                                                    {{ substr($enrollment->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-[14px] font-bold text-slate-800">{{ $enrollment->user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[13px] font-medium text-slate-600">{{ $enrollment->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            Siswa
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-[13px] font-semibold text-slate-800">{{ $enrollment->created_at->format('d M Y') }}</div>
                                        <div class="text-[11px] font-medium text-slate-400 mt-1">{{ $enrollment->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <p class="text-[14px] font-bold text-slate-600">Belum Ada Siswa</p>
                                            <p class="text-[13px] font-medium mt-1">Belum ada siswa yang disetujui untuk kelas ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($enrollments->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $enrollments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
