<x-front-layout>
    <div class="pt-32 pb-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Eksplorasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Creative Class</span>
                </h1>
                <p class="mt-4 text-xl text-slate-500 max-w-2xl mx-auto">
                    Kembangkan keahlian kreatif dan digital Anda bersama mentor profesional di industrinya.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse ($courses as $course)
                    <a href="{{ route('courses.show', $course) }}" class="group block rounded-3xl bg-white border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="relative h-56 bg-slate-100 overflow-hidden">
                            @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-cyan-50">
                                    <span class="text-blue-300 font-medium">No Image</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-blue-700 backdrop-blur-sm shadow-sm">
                                    {{ $course->category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $course->title }}
                            </h3>
                            <p class="text-slate-500 text-sm line-clamp-2 mb-4">
                                {{ $course->description }}
                            </p>
                            
                            <div class="flex items-center text-sm text-slate-500 mb-6 space-x-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-amber-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span>{{ $course->rating }} ({{ $course->students_count }})</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-slate-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    <span class="capitalize">{{ $course->level }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs mr-3">
                                        {{ substr($course->mentor->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $course->mentor->name }}</span>
                                </div>
                                <span class="font-bold text-lg text-slate-900">
                                    Rp{{ number_format($course->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-20 text-slate-500 bg-white rounded-3xl border border-slate-200">
                        Belum ada kursus yang tersedia saat ini.
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</x-front-layout>
