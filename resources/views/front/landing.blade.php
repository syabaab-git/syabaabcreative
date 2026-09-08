@php
    $colors = $settings['landing_colors'] ?? [];
    $texts = $settings['landing_texts'] ?? [];
    $slides = $settings['landing_hero_slides'] ?? [];
@endphp
<x-front-layout>
    <!-- HERO SECTION: True Black -->
    <section class="relative min-h-[90vh] bg-black flex flex-col justify-center pb-24 overflow-hidden"
        x-data="{ 
            activeSlide: 0, 
            slides: {{ json_encode($slides) }},
            mouseX: 0,
            mouseY: 0,
            nextSlide() {
                if(this.slides.length === 0) return;
                this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
            },
            init() {
                if(this.slides.length > 1) {
                    setInterval(() => this.nextSlide(), 6000);
                }
            }
        }"
        @mousemove.window="mouseX = $event.clientX; mouseY = $event.clientY">
        
        <!-- Ambient decorative blur for Hybrid mode with Parallax -->
        <div class="absolute top-1/4 -right-1/4 w-[800px] h-[800px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none z-0 transition-transform duration-1000 ease-out"
             :style="`transform: translate(${(mouseX - window.innerWidth/2) * -0.02}px, ${(mouseY - window.innerHeight/2) * -0.02}px)`"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[120px] pointer-events-none z-0 transition-transform duration-1000 ease-out"
             :style="`transform: translate(${(mouseX - window.innerWidth/2) * 0.03}px, ${(mouseY - window.innerHeight/2) * 0.03}px)`"></div>

        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition opacity-100 duration-1000" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition opacity-0 duration-1000" 
                 class="absolute inset-0 z-0 pointer-events-none">
                <template x-if="slide.image">
                    <img :src="'/storage/' + slide.image" class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay">
                </template>
            </div>
        </template>

        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full text-center h-[300px] flex flex-col justify-center mt-20">
            <!-- Content that changes based on slide -->
            <template x-if="slides.length > 0">
                <div class="relative w-full h-full flex items-center justify-center">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index" 
                            x-transition:enter="transition ease-out duration-500 transform" 
                            x-transition:enter-start="opacity-0 translate-y-4 scale-95" 
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                            x-transition:leave="transition ease-in duration-300 absolute inset-0 transform"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 -translate-y-4 scale-105"
                            class="absolute inset-x-0 flex flex-col items-center justify-center">
                            
                            <h1 class="text-[48px] md:text-[64px] font-bold leading-[1.05] tracking-[-1px] text-white mb-6 drop-shadow-lg" x-text="slide.title"></h1>
                            <p class="text-[20px] md:text-[28px] font-normal leading-[1.3] text-gray-300 max-w-3xl mx-auto mb-10" x-text="slide.subtitle"></p>
                            
                            <template x-if="slide.button_text && slide.button_url">
                                <div class="flex justify-center gap-4">
                                    <a :href="slide.button_url" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white text-[17px] font-medium rounded-full hover:bg-blue-500 hover:scale-105 transition-all shadow-[0_0_30px_rgba(37,99,235,0.4)]" x-text="slide.button_text"></a>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Fallback if no slides -->
            <template x-if="slides.length === 0">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)" 
                     x-show="show"
                     x-transition:enter="transition ease-out duration-700 transform"
                     x-transition:enter-start="opacity-0 translate-y-12 blur-sm"
                     x-transition:enter-end="opacity-100 translate-y-0 blur-0">
                    <h1 class="text-[48px] md:text-[72px] font-bold leading-[1.05] tracking-[-1.5px] text-white mb-6 drop-shadow-lg">
                        Bangun Skill Digital & <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">Wujudkan Proyek Masa Depan</span>
                    </h1>
                    <p class="text-[20px] md:text-[24px] font-normal leading-[1.4] text-gray-400 max-w-3xl mx-auto mb-10">
                        Satu platform inovatif untuk belajar keahlian digital masa depan sekaligus memesan layanan agensi profesional.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="#courses" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white text-[17px] font-medium rounded-full hover:bg-blue-500 hover:-translate-y-1 transition-all duration-300 shadow-[0_10px_30px_rgba(37,99,235,0.3)] hover:shadow-[0_15px_40px_rgba(37,99,235,0.5)] relative overflow-hidden group">
                            <span class="relative z-10">Mulai Belajar</span>
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <a href="#services" class="inline-flex items-center justify-center px-8 py-4 bg-white/5 backdrop-blur-xl border border-white/10 text-white text-[17px] font-medium rounded-full hover:bg-white/10 hover:-translate-y-1 hover:border-white/30 transition-all duration-300 group">
                            Pesan Layanan
                            <svg class="w-5 h-5 ml-2 opacity-70 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <!-- Slide Navigators -->
        <div class="absolute bottom-20 left-0 right-0 flex justify-center space-x-3 z-20" x-show="slides.length > 1">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" :class="{'bg-white w-8 shadow-[0_0_15px_rgba(255,255,255,0.8)]': activeSlide === index, 'bg-white/30 w-2 hover:bg-white/60': activeSlide !== index}" class="h-2 rounded-full transition-all duration-500 focus:outline-none"></button>
            </template>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center justify-center animate-bounce z-20 cursor-pointer" onclick="document.getElementById('courses').scrollIntoView({behavior: 'smooth'})">
            <span class="text-[9px] text-gray-400 uppercase tracking-[0.2em] font-bold mb-2 opacity-70">Scroll</span>
            <div class="w-[20px] h-[32px] border-2 border-gray-500/50 rounded-full flex justify-center p-1">
                <div class="w-1 h-2 bg-white rounded-full animate-pulse"></div>
            </div>
        </div>
    </section>

    <!-- GRADIENT TRANSITION: Dark to Light -->
    <div class="h-32 bg-gradient-to-b from-black to-slate-50 w-full"></div>

    <!-- SECTION: ACADEMY (Light Section) -->
    <section id="courses" class="py-[100px] bg-slate-50 text-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <h2 class="reveal-up text-[44px] md:text-[52px] font-bold leading-[1.1] tracking-tight text-slate-900 mb-4">
                Creative Class Terpopuler
            </h2>
            <p class="reveal-up delay-100 text-[21px] text-slate-600 mb-16 max-w-2xl mx-auto">
                Tingkatkan keahlian digital Anda melalui 3 kelas pilihan yang dirancang khusus oleh praktisi industri profesional.
            </p>

            <!-- Utility grid for courses (Exactly 3 cards) -->
            <div class="grid md:grid-cols-3 gap-8 text-left mb-16">
                @foreach ($popularCourses as $index => $course)
                    <div class="reveal-up group flex flex-col bg-white rounded-[24px] border border-slate-200 p-6 hover:-translate-y-3 hover:shadow-[0_30px_60px_rgba(0,0,0,0.06)] hover:border-blue-200 transition-all duration-500 relative overflow-hidden" style="transition-delay: {{ $index * 150 }}ms;">
                        <div class="w-full aspect-video bg-slate-100 rounded-[16px] mb-6 overflow-hidden flex items-center justify-center relative">
                            @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-[12px] font-bold text-slate-800 shadow-sm">
                                {{ $course->category->name ?? 'Umum' }}
                            </div>
                        </div>
                        
                        <h3 class="text-[20px] font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                            {{ $course->title }}
                        </h3>
                        <p class="text-[16px] text-slate-500 mb-6 flex-1 line-clamp-2">
                            {{ $course->description }}
                        </p>
                        
                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center mb-6">
                            <div class="text-[14px] text-slate-500 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-[12px] font-bold text-slate-700">
                                    {{ substr($course->mentor->name ?? 'M', 0, 1) }}
                                </div>
                                {{ $course->mentor->name ?? 'Mentor' }}
                            </div>
                            <div class="text-[20px] font-bold text-slate-900">
                                {{ $course->price > 0 ? 'Rp' . number_format($course->price, 0, ',', '.') : 'Gratis' }}
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('courses.show', $course) }}" class="block w-full py-3 px-4 bg-slate-50 hover:bg-blue-600 text-slate-700 hover:text-white text-center font-semibold rounded-xl transition-colors border border-slate-200 hover:border-transparent">
                            Ikuti Kelas
                        </a>
                    </div>
                @endforeach
            </div>
            
            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                Jelajahi Katalog Kelas Lainnya <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- GRADIENT TRANSITION: Light to Dark -->
    <div class="h-32 bg-gradient-to-b from-slate-50 to-slate-900 w-full"></div>

    <!-- SECTION: SERVICES (Dark Section) -->
    <section id="services" class="py-[100px] bg-slate-900 text-center relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <h2 class="reveal-up text-[44px] md:text-[52px] font-bold leading-[1.1] tracking-tight text-white mb-4">
                Layanan Agensi Unggulan
            </h2>
            <p class="reveal-up delay-100 text-[21px] text-slate-300 mb-16 max-w-2xl mx-auto">
                Solusi kreatif inovatif untuk bisnis Anda. Pesan layanan paling dicari untuk mengembangkan aset digital dengan cepat.
            </p>

            <!-- Utility grid for services (Exactly 3 cards) -->
            <div class="grid md:grid-cols-3 gap-8 text-left mb-16">
                @foreach ($services as $index => $service)
                    <div class="reveal-up group flex flex-col bg-slate-800 rounded-[24px] border border-slate-700 p-6 hover:-translate-y-3 hover:shadow-[0_30px_60px_rgba(147,51,234,0.15)] hover:border-purple-500/40 transition-all duration-500 relative overflow-hidden" style="transition-delay: {{ $index * 150 }}ms;">
                        <div class="absolute -right-20 -top-20 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl pointer-events-none group-hover:bg-purple-500/20 transition-colors"></div>
                        
                        <div class="mb-6 flex justify-between items-start relative z-10">
                            <div class="w-14 h-14 rounded-[16px] bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                                @if($service->icon)
                                    <img src="{{ Storage::url($service->icon) }}" alt="icon" class="w-7 h-7 object-contain brightness-0 invert">
                                @else
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                @endif
                            </div>
                            <span class="text-[12px] font-bold text-purple-300 border border-purple-500/30 rounded-full px-4 py-1.5 bg-purple-500/10">
                                {{ $service->category->name ?? 'Layanan' }}
                            </span>
                        </div>
                        <h3 class="text-[20px] font-bold text-white mb-2 line-clamp-2 group-hover:text-purple-400 transition-colors relative z-10">
                            {{ $service->name }}
                        </h3>
                        <p class="text-[16px] text-slate-400 mb-6 flex-1 line-clamp-3 relative z-10">
                            {{ $service->description }}
                        </p>
                        <div class="pt-4 border-t border-slate-700 flex justify-between items-end relative z-10 mb-6">
                            <div class="text-[12px] text-slate-400 uppercase tracking-widest font-bold">Mulai Dari</div>
                            <div class="text-[20px] font-bold text-white">
                                Rp{{ number_format($service->base_price, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('services.show', $service) }}" class="block w-full py-3 px-4 bg-slate-700 hover:bg-purple-600 text-white text-center font-semibold rounded-xl transition-colors border border-slate-600 hover:border-transparent relative z-10">
                            Pesan Layanan
                        </a>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('services.index') }}" class="inline-flex items-center text-purple-400 font-semibold hover:text-purple-300 transition-colors">
                Eksplorasi Semua Layanan Kreatif <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </section>

    <!-- GRADIENT TRANSITION: Dark to Light Testimonials -->
    <div class="h-32 bg-gradient-to-b from-slate-900 to-slate-50 w-full relative z-0"></div>

    <!-- SECTION: TESTIMONIALS (Light Section) -->
    <section id="testimonials" class="py-[80px] bg-slate-50 text-center relative overflow-hidden">
        <div class="absolute top-1/4 right-0 w-[400px] h-[400px] bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <h2 class="reveal-up text-[44px] md:text-[52px] font-bold leading-[1.1] tracking-tight text-slate-900 mb-4">
                Apa Kata Mereka?
            </h2>
            <p class="reveal-up delay-100 text-[21px] text-slate-600 mb-16 max-w-2xl mx-auto">
                Kisah sukses dari mereka yang telah bertumbuh bersama Syabaab Creative Platform.
            </p>

            @if(isset($testimonials) && count($testimonials) > 0)
                <div class="reveal-up delay-200 relative max-w-4xl mx-auto" x-data="{ activeTesti: 0, testisArray: {{ json_encode($testimonials) }}, init() { if(this.testisArray.length > 1) { setInterval(() => { this.activeTesti = (this.activeTesti + 1) % this.testisArray.length; }, 5000); } } }">
                    <div class="relative h-[400px] md:h-[250px]">
                        <template x-for="(testi, index) in testisArray" :key="index">
                            <div x-show="activeTesti === index"
                                 x-transition:enter="transition ease-out duration-500 transform"
                                 x-transition:enter-start="opacity-0 translate-x-12 scale-95"
                                 x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                                 x-transition:leave="transition ease-in duration-300 absolute inset-0 transform"
                                 x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                                 x-transition:leave-end="opacity-0 -translate-x-12 scale-95"
                                 class="absolute inset-0 bg-white rounded-[32px] p-8 md:p-12 border border-slate-200 flex flex-col md:flex-row items-center gap-8 text-left shadow-[0_20px_60px_rgba(0,0,0,0.05)]">
                                
                                <div class="shrink-0 relative">
                                    <template x-if="testi.avatar">
                                        <img :src="'/storage/' + testi.avatar" :alt="testi.name" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-xl">
                                    </template>
                                    <template x-if="!testi.avatar">
                                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 border-4 border-white shadow-xl flex items-center justify-center text-[32px] font-bold text-white" x-text="testi.name.charAt(0)"></div>
                                    </template>
                                    <div class="absolute -bottom-3 -right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center border border-slate-100 shadow-lg text-amber-400">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <!-- Stars -->
                                    <div class="flex text-amber-400 mb-4">
                                        <template x-for="i in (testi.rating || 5)">
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>
                                        </template>
                                    </div>
                                    <p class="text-[18px] md:text-[20px] text-slate-800 italic mb-6 leading-relaxed" x-text="'&quot;' + testi.message + '&quot;'"></p>
                                    <div>
                                        <h4 class="text-[18px] font-bold text-slate-900" x-text="testi.name"></h4>
                                        <p class="text-[14px] text-blue-600 font-medium" x-text="testi.role + (testi.company ? ' at ' + testi.company : '')"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Pagination Dots -->
                    <div class="flex justify-center mt-8 gap-2">
                        <template x-for="(testi, index) in testisArray" :key="index">
                            <button @click="activeTesti = index" :class="activeTesti === index ? 'w-8 bg-blue-600' : 'w-2 bg-slate-300 hover:bg-slate-400'" class="h-2 rounded-full transition-all duration-300"></button>
                        </template>
                    </div>
                </div>
            @else
                <div class="text-slate-500 text-[16px] py-10">Belum ada ulasan saat ini.</div>
            @endif
        </div>
    </section>

    <!-- GRADIENT TRANSITION: Light to Pure Black Footer -->
    <div class="h-32 bg-gradient-to-b from-slate-50 to-black w-full relative z-0"></div>

    <!-- FOOTER SECTION (True Black) -->
    <footer class="bg-black pt-[60px] pb-[40px] relative overflow-hidden border-t border-white/5">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16 border-b border-white/10 pb-16">
                <!-- Brand & Newsletter -->
                <div class="md:col-span-4">
                    <span class="text-[28px] font-bold text-white mb-4 block tracking-tight">Syabaab<span class="text-blue-500">.</span></span>
                    <p class="text-[15px] text-gray-400 leading-relaxed mb-6">
                        Platform edukasi dan layanan digital masa depan. Tingkatkan keahlian atau serahkan proyek Anda pada tim agensi profesional kami.
                    </p>
                    <div class="bg-white/5 p-1 rounded-xl flex items-center border border-white/10 focus-within:border-blue-500/50 transition-colors">
                        <input type="email" placeholder="Alamat email Anda" class="w-full bg-transparent border-none text-white text-[14px] px-4 focus:ring-0 placeholder-gray-500">
                        <button class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-[13px] font-bold transition-colors">Berlangganan</button>
                    </div>
                </div>
                
                <!-- Links -->
                <div class="md:col-span-2 md:col-start-6">
                    <h4 class="text-[15px] font-bold text-white mb-5 uppercase tracking-widest">Academy</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('courses.index') }}" class="text-[15px] text-gray-400 hover:text-white transition-colors">Semua Kelas</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Mentorship</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Instruktur Kami</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Sertifikasi</a></li>
                    </ul>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-[15px] font-bold text-white mb-5 uppercase tracking-widest">Agency</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('services.index') }}" class="text-[15px] text-gray-400 hover:text-white transition-colors">Layanan Kreatif</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Portofolio</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Studi Kasus</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Konsultasi Gratis</a></li>
                    </ul>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-[15px] font-bold text-white mb-5 uppercase tracking-widest">Perusahaan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Karir</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="text-[15px] text-gray-400 hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center text-[13px] text-gray-500 gap-4">
                <p>&copy; {{ date('Y') }} Syabaab Creative Platform. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">Privasi</a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-500 hover:text-white transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- FAB: WHATSAPP CUSTOMER SERVICE -->
    @php
        $showWa = true;
        if (auth()->check()) {
            if (!auth()->user()->hasRole('member')) {
                $showWa = false;
            }
        }
        $fabWaNumber = preg_replace('/[^0-9]/', '', \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890');
        $fabWaUrl = 'https://api.whatsapp.com/send/?phone=%2B' . $fabWaNumber . '&text&type=phone_number&app_absent=0';
    @endphp

    @if($showWa)
    <div class="fixed bottom-[100px] sm:bottom-8 right-4 sm:right-8 z-50"
         x-data="{
            isDragging: false,
            hasDragged: false,
            startX: 0,
            startY: 0,
            currentX: 0,
            currentY: 0,
            startDrag(e) {
                if (window.innerWidth >= 640) return; // Only draggable on mobile
                this.isDragging = true;
                this.hasDragged = false;
                let clientX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
                let clientY = e.type === 'touchstart' ? e.touches[0].clientY : e.clientY;
                this.startX = clientX - this.currentX;
                this.startY = clientY - this.currentY;
            },
            doDrag(e) {
                if (!this.isDragging) return;
                if (e.cancelable) e.preventDefault();
                this.hasDragged = true;
                
                let clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                let clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
                
                let newX = clientX - this.startX;
                let newY = clientY - this.startY;
                
                // Menghitung posisi absolut awal berdasarkan CSS (right-4 = 16px, bottom = 100px, w/h = 56px)
                let origX = window.innerWidth - 72; 
                let origY = window.innerHeight - 156;
                
                // Batas minimal dan maksimal absolut di layar
                let minAbsX = 16; // 16px dari kiri layar
                let maxAbsX = window.innerWidth - 72; // 16px dari kanan layar (posisi awal)
                
                let minAbsY = 85; // 85px dari atas layar (menghindari top nav)
                let maxAbsY = window.innerHeight - 156; // 100px dari bawah layar (menghindari bottom nav)
                
                // Hitung posisi absolut target
                let absX = origX + newX;
                let absY = origY + newY;
                
                // Clamping / membatasi posisi
                absX = Math.max(minAbsX, Math.min(absX, maxAbsX));
                absY = Math.max(minAbsY, Math.min(absY, maxAbsY));
                
                // Terapkan kembali menjadi nilai relatif transform
                this.currentX = absX - origX;
                this.currentY = absY - origY;
            },
            stopDrag() {
                this.isDragging = false;
                setTimeout(() => this.hasDragged = false, 50);
            }
         }"
         @mousedown="startDrag"
         @touchstart="startDrag"
         @mousemove.window="doDrag"
         @touchmove.window="doDrag"
         @mouseup.window="stopDrag"
         @touchend.window="stopDrag"
         :style="`transform: translate3d(${currentX}px, ${currentY}px, 0); transition: ${isDragging ? 'none' : 'transform 0.1s ease'}; touch-action: none;`"
    >
        <a href="{{ $fabWaUrl }}" 
           @click="if(hasDragged) $event.preventDefault()"
           target="_blank" rel="noopener noreferrer" 
           class="flex items-center justify-center w-[56px] h-[56px] bg-[#25D366] text-white rounded-full shadow-[0_10px_30px_rgba(37,211,102,0.4)] hover:scale-110 transition-all duration-300 border-2 border-white/20" title="Hubungi CS">
            <svg class="w-8 h-8 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
        </a>
    </div>
    @endif

    <!-- Scroll Reveal Animation Logic & Styles -->
    <style>
        .reveal-up {
            opacity: 0;
            transform: translateY(40px) scale(0.96);
            transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-up.revealed {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .delay-100 { transition-delay: 100ms; }
        
        /* Smooth scrolling for anchor links */
        html { scroll-behavior: smooth; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-up').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</x-front-layout>
