<x-settings-layout>
    <div class="mb-6">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Personalisasi') }}
        </h2>
    </div>

    @php
        $authBg      = json_decode($settings['auth_background'] ?? '{}', true);
        $authBgType  = $authBg['type']  ?? 'color';
        $authBgText  = $authBg['text']  ?? 'Syabaab Creative';
        $authBgImage = $authBg['image'] ?? '';

        $receipt         = json_decode($settings['receipt_personalization'] ?? '{}', true);
        $canvasWidth     = $receipt['canvas_width']           ?? 380;
        $canvasHeight    = $receipt['canvas_height']          ?? 560;
        $canvasUnit      = $receipt['canvas_unit']            ?? 'px';
        $canvasBg        = $receipt['canvas_bg']              ?? '#ffffff';
        $canvasDefaultBg = $receipt['canvas_use_default_bg']  ?? false;
        $canvasDefaultBgOpacity = $receipt['canvas_default_bg_opacity'] ?? 0.3;
        $elements        = $receipt['elements']               ?? [];
    @endphp

    {{-- ===== SINGLE UNIFIED FORM ===== --}}
    <form id="personalisasi-form" method="POST" action="{{ route('settings.landing.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Hidden receipt canvas data fields --}}
        <input type="hidden" name="canvas_data" id="canvas-data-input">
        <input type="hidden" name="logo_data"   id="logo-data-input">

        {{-- ================================================================
             SECTION 1 — Auth Page Background
        ================================================================ --}}
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 mb-8" x-data="authBackgroundPreview()">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50 rounded-t-[24px]">
                <h3 class="text-[16px] font-bold text-slate-900">Auth Page Background</h3>
                <p class="text-[13px] text-slate-500 mt-1">Ubah latar belakang untuk halaman login dan register.</p>
            </div>

            <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Settings Inputs (LEFT COLUMN) --}}
                <div class="space-y-6 w-full">

                    {{-- Type Selection --}}
                    <div>
                        <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider mb-3">Tipe Latar Belakang</label>
                        <div class="flex items-center space-x-6 bg-slate-50 p-1.5 rounded-2xl w-fit border border-slate-100">
                            <label class="flex items-center group cursor-pointer px-4 py-2 rounded-xl transition-all" :class="bgType === 'color' ? 'bg-white shadow-sm' : 'hover:bg-slate-200/50'">
                                <input type="radio" name="auth_bg_type" value="color" x-model="bgType" class="sr-only">
                                <span class="text-[14px] font-bold transition-colors" :class="bgType === 'color' ? 'text-indigo-600' : 'text-slate-500'">Warna & Tipografi</span>
                            </label>
                            <label class="flex items-center group cursor-pointer px-4 py-2 rounded-xl transition-all" :class="bgType === 'image' ? 'bg-white shadow-sm' : 'hover:bg-slate-200/50'">
                                <input type="radio" name="auth_bg_type" value="image" x-model="bgType" class="sr-only">
                                <span class="text-[14px] font-bold transition-colors" :class="bgType === 'image' ? 'text-indigo-600' : 'text-slate-500'">Gambar</span>
                            </label>
                        </div>
                    </div>

                    {{-- Typography Settings --}}
                    <div x-show="bgType === 'color'" x-transition class="space-y-6 pt-2">

                        {{-- Teks & Pemformatan --}}
                        <div>
                            <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider mb-2">Teks Latar & Gaya</label>
                            <div class="flex flex-wrap items-center gap-3">
                                <input type="text" name="auth_bg_text" x-model="bgText" class="flex-1 min-w-[200px] bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" placeholder="Syabaab Creative">

                                <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-xl shrink-0">
                                    <input type="hidden" name="auth_bg_italic" :value="bgItalic">
                                    <input type="hidden" name="auth_bg_strikethrough" :value="bgStrikethrough">
                                    <button type="button" @click="bgItalic = bgItalic === 'true' ? 'false' : 'true'" class="flex items-center justify-center w-8 h-8 rounded-lg text-[14px] transition-all duration-300 italic font-serif" :class="bgItalic === 'true' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'" title="Miring">I</button>
                                    <button type="button" @click="bgStrikethrough = bgStrikethrough === 'true' ? 'false' : 'true'" class="flex items-center justify-center w-8 h-8 rounded-lg text-[14px] transition-all duration-300 line-through" :class="bgStrikethrough === 'true' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'" title="Coret">S</button>
                                </div>

                                <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-1 rounded-xl shrink-0">
                                    <input type="hidden" name="auth_bg_case" :value="bgCase">
                                    <button type="button" @click="bgCase = 'normal'"    class="flex items-center justify-center px-3 py-1.5 rounded-lg text-[13px] font-bold transition-all duration-300"          :class="bgCase === 'normal'    ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">Aa</button>
                                    <button type="button" @click="bgCase = 'lowercase'" class="flex items-center justify-center px-3 py-1.5 rounded-lg text-[13px] font-bold transition-all duration-300 lowercase"  :class="bgCase === 'lowercase' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">aa</button>
                                    <button type="button" @click="bgCase = 'uppercase'" class="flex items-center justify-center px-3 py-1.5 rounded-lg text-[13px] font-bold transition-all duration-300 uppercase"  :class="bgCase === 'uppercase' ? 'bg-white dark:bg-slate-700 shadow-sm text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200'">AA</button>
                                </div>
                            </div>
                        </div>

                        {{-- Font, Ukuran, Ketebalan --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                            <div>
                                <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Font</label>
                                <div x-data="{ open: false, fonts: {'Inter': 'Inter','Arial': 'Arial','Georgia': 'Georgia','Courier New': 'Courier New','Times New Roman': 'Times New Roman','Verdana': 'Verdana','Impact': 'Impact','Comic Sans MS': 'Comic Sans MS','Trebuchet MS': 'Trebuchet MS'}, get label() { return this.fonts[bgFont] || 'Inter'; } }" class="relative">
                                    <input type="hidden" name="auth_bg_font" :value="bgFont">
                                    <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-700 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[14px] font-medium text-slate-900 dark:text-slate-100 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                        <span x-text="label" :style="`font-family: ${bgFont}`" class="truncate"></span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="open" x-transition class="absolute z-50 left-0 right-0 mt-2 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl rounded-xl shadow-xl border border-white/40 dark:border-white/10">
                                        <style>.custom-scrollbar::-webkit-scrollbar{width:5px}.custom-scrollbar::-webkit-scrollbar-track{background:transparent}.custom-scrollbar::-webkit-scrollbar-thumb{background-color:#cbd5e1;border-radius:10px}.custom-scrollbar::-webkit-scrollbar-thumb:hover{background-color:#94a3b8}</style>
                                        <div class="p-1.5 max-h-48 overflow-y-auto custom-scrollbar">
                                            <template x-for="(fontName, fontKey) in fonts" :key="fontKey">
                                                <button type="button" @click="bgFont = fontKey; open = false;" class="group w-full text-left px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:text-indigo-700 dark:hover:text-white transition-colors flex items-center justify-between" :class="bgFont == fontKey ? 'bg-indigo-50 dark:bg-indigo-600 text-indigo-700 dark:text-white font-bold' : 'text-slate-700 dark:text-slate-300 text-[14px]'">
                                                    <span x-text="fontName" :style="`font-family: ${fontKey}`" class="truncate text-slate-700 dark:text-slate-300 group-hover:text-indigo-700 dark:group-hover:text-white"></span>
                                                    <svg x-show="bgFont == fontKey" class="w-4 h-4 text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Ukuran</label>
                                    <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded" x-text="bgSize + 'px'"></span>
                                </div>
                                <input type="hidden" name="auth_bg_size" :value="bgSize">
                                <div class="relative pt-3 pb-2">
                                    <input type="range" min="10" max="250" step="2" x-model="bgSize" class="w-full h-2 bg-slate-200 rounded-full appearance-none cursor-pointer accent-indigo-600 hover:accent-indigo-500 transition-all">
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Ketebalan</label>
                                    <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded" x-text="bgWeight"></span>
                                </div>
                                <input type="hidden" name="auth_bg_weight" :value="bgWeight">
                                <div class="relative pt-3 pb-2">
                                    <input type="range" min="100" max="900" step="100" x-model="bgWeight" class="w-full h-2 bg-slate-200 rounded-full appearance-none cursor-pointer accent-indigo-600 hover:accent-indigo-500 transition-all">
                                </div>
                            </div>
                        </div>

                        {{-- Warna --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                            <div>
                                <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider mb-2">Warna Teks</label>
                                <div class="flex items-center space-x-3">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-sm shrink-0 border border-slate-200">
                                        <input type="color" name="auth_bg_text_color" x-model="bgTextColor" class="absolute inset-[-5px] w-12 h-12 cursor-pointer">
                                    </div>
                                    <input type="text" x-model="bgTextColor" class="flex-1 bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-1.5 text-[14px] font-bold text-slate-900 uppercase font-mono transition-colors" placeholder="#0f172a">
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider">Warna Latar</label>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10px] font-bold text-slate-400">Auto</span>
                                        <button type="button" @click="bgAutoColor = bgAutoColor === 'true' ? 'false' : 'true'" :class="bgAutoColor === 'true' ? 'bg-indigo-600' : 'bg-slate-200'" class="relative inline-flex h-4 w-7 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                            <input type="hidden" name="auth_bg_auto_color" :value="bgAutoColor">
                                            <span aria-hidden="true" :class="bgAutoColor === 'true' ? 'translate-x-3' : 'translate-x-0'" class="pointer-events-none inline-block h-3 w-3 transform rounded-full bg-white shadow ring-0 transition-transform duration-300 ease-in-out"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3 transition-opacity duration-300" :class="bgAutoColor === 'true' ? 'opacity-60' : ''">
                                    <div class="relative w-8 h-8 rounded-lg overflow-hidden shadow-sm shrink-0 border border-slate-200">
                                        <template x-if="bgAutoColor === 'true'">
                                            <div class="absolute inset-0" :style="{ backgroundColor: computedBgColor }"></div>
                                        </template>
                                        <template x-if="bgAutoColor !== 'true'">
                                            <input type="color" name="auth_bg_color" x-model="bgColor" class="absolute inset-[-5px] w-12 h-12 cursor-pointer">
                                        </template>
                                    </div>
                                    <input type="text" :value="bgAutoColor === 'true' ? computedBgColor : bgColor" @input="if(bgAutoColor !== 'true') bgColor = $event.target.value;" :readonly="bgAutoColor === 'true'" class="flex-1 bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-1.5 text-[14px] font-bold text-slate-900 font-mono transition-colors" :class="bgAutoColor === 'true' ? 'text-slate-400' : 'uppercase'">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Image Settings --}}
                    <div x-show="bgType === 'image'" x-transition class="pt-2">
                        <label class="block text-[12px] font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Gambar Background</label>
                        <div class="flex flex-col items-center justify-center w-full aspect-[21/9] border-2 border-slate-200 border-dashed rounded-[16px] hover:border-indigo-400 hover:bg-indigo-50/50 transition-colors bg-slate-50 cursor-pointer group relative overflow-hidden" onclick="document.getElementById('auth_bg_image').click()">
                            <div class="space-y-2 text-center p-4 relative z-10" x-show="!imagePreviewUrl && !'{{ $authBgImage }}'">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm text-indigo-500 mb-2 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <span class="text-[12px] font-bold text-slate-700 block">Klik untuk Upload</span>
                                <span class="text-[10px] text-slate-500 block">JPG, PNG (Max 2MB)</span>
                            </div>
                            <div class="absolute inset-0 bg-cover bg-center" x-show="imagePreviewUrl || '{{ $authBgImage }}'" :style="imagePreviewUrl ? `background-image: url('${imagePreviewUrl}')` : `background-image: url('{{ $authBgImage ? asset('storage/' . $authBgImage) : '' }}')`"></div>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" x-show="imagePreviewUrl || '{{ $authBgImage }}'">
                                <span class="text-white text-[13px] font-bold">Ganti Gambar</span>
                            </div>
                            <input id="auth_bg_image" name="auth_bg_image" type="file" @change="previewImage" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                        </div>
                        <input type="hidden" name="old_auth_bg_image" value="{{ $authBgImage }}">
                    </div>
                </div>

                {{-- Live Preview (RIGHT COLUMN) --}}
                <div class="h-full flex flex-col">
                    <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-3">Live Preview</label>
                    <div class="w-full flex-1 min-h-[400px] rounded-[24px] border-2 border-slate-200 overflow-hidden relative flex items-center justify-center transition-all duration-300"
                         :style="bgType === 'color' ? { backgroundColor: computedBgColor } : (bgType === 'image' ? { backgroundImage: imagePreviewUrl ? `url('${imagePreviewUrl}')` : `url('{{ $authBgImage ? asset('storage/' . $authBgImage) : '' }}')`, backgroundSize: 'cover', backgroundPosition: 'center' } : {})">

                        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-500/10 rounded-full blur-[40px] pointer-events-none z-0"></div>
                        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-purple-500/10 rounded-full blur-[40px] pointer-events-none z-0"></div>

                        <template x-if="bgType === 'color' && bgText">
                            <div class="absolute inset-[-50%] overflow-hidden flex flex-wrap pointer-events-none select-none z-0 transform -rotate-12 justify-center content-center opacity-30">
                                <template x-for="i in 120">
                                    <span class="px-6 py-4 whitespace-nowrap leading-none"
                                        :class="{ 'uppercase': bgCase === 'uppercase', 'lowercase': bgCase === 'lowercase', 'italic': bgItalic === 'true', 'line-through': bgStrikethrough === 'true' }"
                                        :style="{ 'font-family': bgFont, 'font-size': (bgSize * 0.45) + 'px', 'font-weight': bgWeight, 'color': bgTextColor }"
                                        x-text="bgText"></span>
                                </template>
                            </div>
                        </template>

                        <template x-if="bgType === 'image' && !imagePreviewUrl && !'{{ $authBgImage }}'">
                            <div class="absolute inset-0 flex items-center justify-center bg-slate-100 z-0">
                                <span class="text-slate-400 text-xs">Belum ada gambar background</span>
                            </div>
                        </template>

                        <div class="relative z-10 w-60 bg-white/60 backdrop-blur-2xl rounded-[24px] shadow-2xl border border-white/50 p-6 flex flex-col items-center">
                            <div class="w-full flex justify-end -mt-2 mb-2">
                                <div class="text-slate-400"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>
                            </div>
                            <div class="flex flex-col items-center mb-6">
                                <span class="text-base font-black text-slate-800 leading-none tracking-tight">Syabaab</span>
                                <span class="text-[6px] font-bold text-indigo-600 uppercase tracking-widest leading-none mt-1">Creative Platform</span>
                            </div>
                            <div class="w-full space-y-2">
                                <div class="w-full h-8 bg-white/40 border border-slate-200/50 rounded-xl"></div>
                                <div class="w-full h-8 bg-white/40 border border-slate-200/50 rounded-xl"></div>
                                <div class="w-full h-8 bg-indigo-600 text-white font-bold text-[8px] tracking-widest uppercase rounded-xl mt-3 flex items-center justify-center">MASUK</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================================
             SECTION 2 — Struk Pesanan (moved right below Auth)
        ================================================================ --}}
        <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 mb-8"
             x-data="receiptEditor()" x-init="init()">

            <div class="p-8 border-b border-slate-100 bg-slate-50/50 rounded-t-[24px]">
                <h3 class="text-[16px] font-bold text-slate-900">Struk Pesanan</h3>
                <p class="text-[13px] text-slate-500 mt-1">Rancang tata letak struk secara bebas dengan editor visual.</p>
            </div>

            <div class="p-8">
                <div class="relative grid grid-cols-1 xl:grid-cols-[280px,minmax(0,1fr)] gap-6">

                    {{-- Floating action layer --}}
                    <template x-teleport="body">
                        <div x-show="selectedEl && floating.visible" id="floating-toolbar" class="fixed z-[120] bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-slate-200/80 dark:border-slate-800/80 px-3 py-2 flex items-center gap-2.5 min-w-max transition-all duration-200"
                             :style="{ left: floating.left + 'px', top: floating.top + 'px' }"
                             @mousedown.stop @click.stop>
                            <template x-if="selectedEl && selectedEl.type === 'text'">
                                <div class="flex items-center gap-2">
                                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                        <button type="button" @click="open = !open" class="h-8 bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/60 rounded-xl px-3 text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/80 dark:hover:bg-slate-700/80 focus:outline-none transition-all flex items-center justify-between gap-2 shadow-sm">
                                            <span x-text="selectedEl ? selectedEl.fontFamily.split(',')[0].replace(/'/g, '') : 'Inter'"></span>
                                            <svg class="w-3.5 h-3.5 text-slate-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" x-transition class="absolute left-0 z-[130] mt-1 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl rounded-xl shadow-xl border border-white/40 dark:border-white/10 overflow-hidden min-w-[120px]">
                                            <div class="p-1">
                                                <template x-for="f in [
                                                    { value: 'Inter, sans-serif', label: 'Inter' },
                                                    { value: 'Arial, sans-serif', label: 'Arial' },
                                                    { value: '\'Courier New\', monospace', label: 'Courier New' },
                                                    { value: 'Georgia, serif', label: 'Georgia' },
                                                    { value: 'Verdana, sans-serif', label: 'Verdana' }
                                                ]" :key="f.value">
                                                    <button type="button" @click="if(selectedEl) { selectedEl.fontFamily = f.value; updateEl(); open = false; $nextTick(() => positionFloatingToolbar()); }" class="w-full text-left px-2.5 py-1.5 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors text-xs font-bold text-slate-700 dark:text-slate-200" x-text="f.label"></button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="number" x-model="selectedEl.fontSize" @input="updateEl(); positionFloatingToolbar()" min="8" max="120"
                                        class="w-14 h-8 text-xs font-bold bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/60 rounded-xl px-2 text-slate-700 dark:text-slate-200 text-center focus:border-indigo-500 focus:ring-0">
                                    <div class="flex items-center bg-slate-100/80 dark:bg-slate-800/80 p-0.5 rounded-xl border border-slate-200/40 dark:border-slate-700/40">
                                        <button type="button" @click="toggleBold()" :class="selectedEl && selectedEl.bold ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-white/40 dark:hover:bg-slate-700/40'" class="flex items-center justify-center w-8 h-8 rounded-lg text-sm font-black transition-all">B</button>
                                        <button type="button" @click="toggleItalic()" :class="selectedEl && selectedEl.italic ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-white/40 dark:hover:bg-slate-700/40'" class="flex items-center justify-center w-8 h-8 rounded-lg text-sm font-bold italic transition-all">I</button>
                                        <button type="button" @click="toggleUnderline()" :class="selectedEl && selectedEl.underline ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-white/40 dark:hover:bg-slate-700/40'" class="flex items-center justify-center w-8 h-8 rounded-lg text-sm font-bold underline transition-all">U</button>
                                    </div>
                                </div>
                              </template>

                            <template x-if="selectedEl && selectedEl.type === 'divider'">
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="if(selectedEl) { selectedEl.dashed = !selectedEl.dashed; updateEl(); }" :class="selectedEl && selectedEl.dashed ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-slate-100/80 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-200/80 dark:hover:bg-slate-700/80'" class="px-3 h-8 rounded-xl border text-xs font-black transition-colors">Putus</button>
                                    <input type="number" x-model.number="selectedEl.width" @input="updateEl(); positionFloatingToolbar()" min="20" class="w-16 h-8 text-xs font-bold bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/60 rounded-xl px-2 text-slate-700 dark:text-slate-200 text-center focus:border-indigo-500 focus:ring-0">
                                </div>
                            </template>

                            <template x-if="selectedEl && selectedEl.type === 'logo'">
                                <div class="flex items-center gap-2">
                                    <label class="flex items-center justify-center gap-1.5 px-3 h-8 bg-slate-100/80 dark:bg-slate-800/80 hover:bg-slate-200/80 dark:hover:bg-slate-700/80 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs transition-colors border border-slate-200/60 dark:border-slate-700/60 cursor-pointer shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Gambar
                                        <input type="file" class="hidden" accept="image/*" @change="uploadLogo">
                                    </label>
                                    <input type="number" x-model.number="selectedEl.fontSize" @input="updateEl(); positionFloatingToolbar()" min="12" max="180" class="w-16 h-8 text-xs font-bold bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/60 rounded-xl px-2 text-slate-700 dark:text-slate-200 text-center focus:border-indigo-500 focus:ring-0">
                                </div>
                            </template>

                            <div class="flex items-center bg-slate-100/80 dark:bg-slate-800/80 p-0.5 rounded-xl border border-slate-200/40 dark:border-slate-700/40">
                                <button type="button" @click="if(selectedEl) { selectedEl.align='left'; updateEl(); }" :class="selectedEl && selectedEl.align==='left' ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-white/40 dark:hover:bg-slate-700/40'" class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd"/></svg></button>
                                <button type="button" @click="if(selectedEl) { selectedEl.align='center'; updateEl(); }" :class="selectedEl && selectedEl.align==='center' ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-white/40 dark:hover:bg-slate-700/40'" class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm3 10.5a.75.75 0 01.75-.75h8.5a.75.75 0 010 1.5h-8.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd"/></svg></button>
                                <button type="button" @click="if(selectedEl) { selectedEl.align='right'; updateEl(); }" :class="selectedEl && selectedEl.align==='right' ? 'bg-white dark:bg-slate-600 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-white/40 dark:hover:bg-slate-700/40'" class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm5 10.5a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H7.75a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd"/></svg></button>
                            </div>
                            <div class="w-8 h-8 rounded-xl border border-slate-200/60 dark:border-slate-700/60 overflow-hidden cursor-pointer relative shadow-sm" :style="{backgroundColor: selectedEl ? selectedEl.color : '#000000'}">
                                <input type="color" x-model="selectedEl.color" @input="updateEl()" class="absolute inset-[-4px] w-12 h-12 opacity-0 cursor-pointer">
                            </div>
                            <button type="button" @click="deleteSelected()" class="flex items-center justify-center w-8 h-8 rounded-xl bg-red-500/10 dark:bg-red-500/20 text-red-600 dark:text-red-400 hover:bg-red-600 hover:text-white dark:hover:bg-red-500 transition-colors border border-red-200/50 dark:border-red-500/30">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>

                    {{-- Left controls --}}
                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-4">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Template</label>
                                <div class="relative" @click.away="templateOpen = false">
                                    <button type="button" @click="templateOpen = !templateOpen"
                                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-800 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 focus:outline-none transition-all flex items-center justify-between gap-3 shadow-sm">
                                        <span x-text="selectedTemplateLabel" class="truncate"></span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" :class="templateOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="templateOpen" x-transition class="absolute left-0 right-0 z-[130] mt-2 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl rounded-xl shadow-2xl border border-white/40 dark:border-white/10 overflow-hidden">
                                        <div class="p-1.5 max-h-72 overflow-y-auto custom-scrollbar">
                                            <template x-for="tpl in templates" :key="tpl.id">
                                                <button type="button" @click="applyTemplate(tpl.id); templateOpen = false"
                                                    class="group w-full text-left px-3 py-2.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:text-indigo-700 dark:hover:text-white transition-colors flex items-start justify-between gap-3 text-slate-700 dark:text-slate-300">
                                                    <span>
                                                        <span class="block text-xs font-black text-slate-700 dark:text-slate-200 group-hover:text-indigo-700 dark:group-hover:text-white" x-text="tpl.name"></span>
                                                        <span class="block text-[10px] font-semibold text-slate-400 group-hover:text-indigo-500 dark:group-hover:text-indigo-200 mt-0.5" x-text="tpl.desc"></span>
                                                    </span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tambah</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" @click="addElement('text')" class="h-10 flex items-center justify-center gap-1.5 bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-600 dark:hover:bg-indigo-500 text-indigo-700 dark:text-indigo-300 hover:text-white dark:hover:text-white rounded-xl font-bold text-xs transition-colors border border-indigo-100 dark:border-indigo-900/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                        Teks
                                    </button>
                                    <button type="button" @click="addElement('divider')" class="h-10 flex items-center justify-center gap-1.5 bg-slate-50 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-white text-slate-700 dark:text-slate-300 hover:text-white dark:hover:text-slate-900 rounded-xl font-bold text-xs transition-colors border border-slate-200 dark:border-slate-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path></svg>
                                        Garis
                                    </button>
                                    <button type="button" @click="addElement('logo')" class="h-10 flex items-center justify-center gap-1.5 bg-slate-50 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-white text-slate-700 dark:text-slate-300 hover:text-white dark:hover:text-slate-900 rounded-xl font-bold text-xs transition-colors border border-slate-200 dark:border-slate-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Gambar
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Lebar</label>
                                    <input type="number" x-model.number="canvas.width" @input="syncCanvasToForm()" class="w-full text-xs font-bold bg-slate-50 border border-slate-200 rounded-xl px-2 py-2 text-slate-700 text-center focus:border-indigo-500 focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tinggi</label>
                                    <input type="number" x-model.number="canvas.height" @input="syncCanvasToForm()" class="w-full text-xs font-bold bg-slate-50 border border-slate-200 rounded-xl px-2 py-2 text-slate-700 text-center focus:border-indigo-500 focus:ring-0">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Satuan</label>
                                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                        <button type="button" @click="open = !open" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-2 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-800 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 focus:outline-none transition-all flex items-center justify-between shadow-sm">
                                            <span x-text="canvas.unit"></span>
                                            <svg class="w-3 h-3 text-slate-400 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" x-transition class="absolute left-0 right-0 z-[130] mt-1 bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl rounded-xl shadow-xl border border-white/40 dark:border-white/10 overflow-hidden">
                                            <div class="p-1">
                                                <template x-for="u in ['px', 'cm', 'mm', 'in']" :key="u">
                                                    <button type="button" @click="changeUnit(u); open = false" class="w-full text-left px-2 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-600 hover:text-indigo-700 dark:hover:text-white transition-colors text-xs font-bold text-slate-700 dark:text-slate-300" x-text="u"></button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Warna</label>
                                <div class="relative" title="Warna Latar Struk">
                                    <div class="w-8 h-8 rounded-xl border border-slate-200 overflow-hidden cursor-pointer shadow-sm" :style="{backgroundColor: canvas.bg}">
                                        <input type="color" x-model="canvas.bg" @input="syncCanvasToForm()" class="absolute inset-[-4px] w-12 h-12 opacity-0 cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <label class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl font-bold text-xs transition-all border cursor-pointer"
                                   :class="canvas.useDefaultBg ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm hover:bg-indigo-700' : 'bg-slate-50 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-white text-slate-700 dark:text-slate-300 hover:text-white dark:hover:text-slate-900 border-slate-200 dark:border-slate-700'">
                                <span>Latar Default</span>
                                <input type="checkbox" x-model="canvas.useDefaultBg" @change="syncCanvasToForm()" class="sr-only">
                                <span class="relative inline-flex h-4 w-7 rounded-full transition-colors" :class="canvas.useDefaultBg ? 'bg-white/30' : 'bg-slate-200 dark:bg-slate-700'">
                                    <span :class="canvas.useDefaultBg ? 'translate-x-3' : 'translate-x-0'" class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform"></span>
                                </span>
                            </label>

                            <div x-show="canvas.useDefaultBg" x-transition>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-[10px] font-bold text-slate-400 uppercase">Opacity</label>
                                    <span class="text-[10px] font-black text-indigo-600" x-text="Math.round(canvas.defaultBgOpacity * 100) + '%'"></span>
                                </div>
                                <input type="range" min="0.04" max="0.5" step="0.01" x-model.number="canvas.defaultBgOpacity" @input="syncCanvasToForm()" class="w-full h-2 bg-slate-200 rounded-full appearance-none cursor-pointer accent-indigo-600">
                            </div>
                        </div>

                        <template x-if="selectedId !== null && selectedEl && selectedEl.type === 'text'">
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Konten Teks</label>
                                <textarea x-model="selectedEl.text" @input="updateEl(); positionFloatingToolbar()" rows="5"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:border-indigo-500 focus:ring-0 resize-none"
                                    placeholder="Ketik teks..."></textarea>
                            </div>
                        </template>

                        <template x-if="selectedId !== null && selectedEl && selectedEl.type === 'logo'">
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-4">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Gambar Struk</label>
                                <label class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-slate-50 hover:bg-indigo-50 text-slate-700 hover:text-indigo-700 rounded-xl font-bold text-xs transition-colors border border-slate-200 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Upload Gambar
                                    <input type="file" class="hidden" accept="image/*" @change="uploadLogo">
                                </label>
                            </div>
                        </template>

                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="showPreviewModal = true"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-900 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 border border-slate-200 dark:border-slate-700 hover:border-transparent dark:hover:border-transparent font-black text-xs rounded-2xl transition-all duration-300 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Pratinjau
                            </button>
                            <button type="button" @click="openTemplateModal()"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-900 dark:bg-slate-700 text-white hover:bg-slate-50 dark:hover:bg-white hover:text-slate-900 dark:hover:text-slate-900 border border-transparent hover:border-slate-200 dark:hover:border-transparent font-black text-xs rounded-2xl transition-all duration-300 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5v14h14V8.5L15.5 5H5zm4 0v5h6V5"></path></svg>
                                Simpan Template
                            </button>
                        </div>
                    </div>

                    {{-- Canvas Area --}}
                    <div class="bg-slate-100/80 rounded-2xl border border-slate-200/80 overflow-visible shadow-sm">
                        <style>
                            .hide-scrollbar::-webkit-scrollbar { display: none; }
                            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                        </style>
                        <div class="relative overflow-auto hide-scrollbar" style="min-height: 620px;">
                            {{-- Always-visible ambient bg of canvas area, synced with auth typography --}}
                            <div class="absolute inset-0 overflow-hidden pointer-events-none select-none" style="opacity: 0.08;">
                                <div class="absolute inset-[-50%] flex flex-wrap justify-center content-center transform -rotate-12 gap-0">
                                    <template x-for="i in 80">
                                        <span class="px-6 py-4 whitespace-nowrap leading-none"
                                              :class="{ 'uppercase': authBg.case === 'uppercase', 'lowercase': authBg.case === 'lowercase', 'italic': authBg.italic === 'true', 'line-through': authBg.strikethrough === 'true' }"
                                              :style="{ color: authBg.textColor, fontFamily: authBg.font, fontSize: Math.max(22, authBg.size * 0.36) + 'px', fontWeight: authBg.weight }"
                                              x-text="authBg.text"></span>
                                    </template>
                                </div>
                            </div>
                            <div class="absolute top-[-5%] left-[-5%] w-64 h-64 bg-blue-500/10 rounded-full blur-[80px] pointer-events-none"></div>
                            <div class="absolute bottom-[-5%] right-[-5%] w-64 h-64 bg-purple-500/10 rounded-full blur-[80px] pointer-events-none"></div>

                            {{-- Receipt Canvas --}}
                            <div class="relative z-10 flex items-start justify-center p-10">
                                <div id="receipt-canvas"
                                    :style="{ width: canvas.width + canvas.unit, minHeight: canvas.height + canvas.unit, backgroundColor: canvas.bg, position: 'relative' }"
                                    class="shadow-2xl rounded-sm overflow-visible select-none"
                                    @mousedown.self="selectedId = null; floating.visible = false"
                                    style="box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 4px 20px rgba(0,0,0,0.08);">

                                    {{-- Perforated top edge --}}
                                    <div class="absolute -top-2 left-0 right-0 h-2 overflow-hidden z-10">
                                        <div style="background: radial-gradient(circle at 5px 100%, transparent 4px, #e2e8f0 5px); background-size: 10px 10px; height: 100%; width: 100%;"></div>
                                    </div>

                                    {{-- Latar Default overlay (inside canvas) --}}
                                    <template x-if="canvas.useDefaultBg">
                                        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0 rounded-sm">
                                            {{-- Tiling typography synced with auth --}}
                                            <div class="absolute inset-[-60%] flex flex-wrap justify-center content-center transform -rotate-12" :style="{ opacity: canvas.defaultBgOpacity }">
                                                <template x-for="i in 80">
                                                    <span class="px-6 py-4 whitespace-nowrap leading-none"
                                                          :class="{ 'uppercase': authBg.case === 'uppercase', 'lowercase': authBg.case === 'lowercase', 'italic': authBg.italic === 'true', 'line-through': authBg.strikethrough === 'true' }"
                                                          :style="{ color: authBg.textColor, fontFamily: authBg.font, fontSize: Math.max(18, authBg.size * 0.38) + 'px', fontWeight: authBg.weight }"
                                                          x-text="authBg.text"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Canvas elements --}}
                                    <template x-for="el in elements" :key="el.id">
                                        <div
                                            :id="'el-' + el.id"
                                            :style="{
                                                position: 'absolute',
                                                left: el.x + 'px',
                                                top: el.y + 'px',
                                                width: el.width + 'px',
                                                cursor: 'move',
                                                zIndex: selectedId === el.id ? 10 : 1,
                                                outline: selectedId === el.id ? '2px dashed #6366f1' : '2px dashed transparent',
                                                outlineOffset: '3px',
                                                borderRadius: '2px',
                                                userSelect: 'none'
                                            }"
                                            @mousedown.prevent="startDrag($event, el)"
                                            @click.stop="selectElement(el)">

                                            <template x-if="el.type === 'text'">
                                                <div :style="{
                                                    fontFamily: el.fontFamily,
                                                    fontSize: el.fontSize + 'px',
                                                    color: el.color,
                                                    textAlign: el.align,
                                                    fontWeight: el.bold ? 'bold' : 'normal',
                                                    fontStyle: el.italic ? 'italic' : 'normal',
                                                    textDecoration: el.underline ? 'underline' : 'none',
                                                    lineHeight: '1.4',
                                                    whiteSpace: 'pre-wrap',
                                                    wordBreak: 'break-word'
                                                }" x-text="el.text || 'Teks baru'"></div>
                                            </template>

                                            <template x-if="el.type === 'divider'">
                                                <div :style="{ borderTop: '1px ' + (el.dashed ? 'dashed' : 'solid') + ' ' + el.color, width: '100%', marginTop: '4px' }"></div>
                                            </template>

                                            <template x-if="el.type === 'logo'">
                                                <div>
                                                    <template x-if="logoDataUrl">
                                                        <img :src="logoDataUrl" :style="{maxHeight: el.fontSize + 'px', maxWidth: el.width + 'px', display: 'block', margin: el.align === 'center' ? '0 auto' : (el.align === 'right' ? '0 0 0 auto' : '0')}" alt="Logo">
                                                    </template>
                                                    <template x-if="!logoDataUrl">
                                                        <div class="flex items-center justify-center text-xs text-slate-400 bg-slate-100 rounded border border-dashed border-slate-300" :style="{height: el.fontSize + 'px', width: '100%'}">
                                                            Gambar (upload di panel)
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>

                                            <template x-if="selectedId === el.id">
                                                <div @mousedown.prevent.stop="startResize($event, el)"
                                                    class="absolute bottom-0 right-0 w-4 h-4 bg-indigo-600 rounded-tl cursor-se-resize flex items-center justify-center"
                                                    style="margin-bottom: -2px; margin-right: -2px;">
                                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M3 17l14-14M10 17l7-7M17 17V10"/></svg>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    {{-- Perforated bottom edge --}}
                                    <div class="absolute -bottom-2 left-0 right-0 h-2 overflow-hidden">
                                        <div style="background: radial-gradient(circle at 5px 0, transparent 4px, #e2e8f0 5px); background-size: 10px 10px; height: 100%; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-4 right-4 z-40">
                        <div class="w-9 h-9 rounded-full bg-white border border-slate-200/80 shadow-md flex items-center justify-center transition-all">
                            <svg x-show="saveState === 'saved'" class="w-5 h-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4.13-5.68z" clip-rule="evenodd" />
                            </svg>
                            <svg x-show="saveState === 'saving'" class="w-5 h-5 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <template x-teleport="body">
                    <div x-show="showTemplateModal" class="fixed inset-0 z-[150] flex items-center justify-center p-4" x-transition>
                        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="showTemplateModal = false"></div>
                        <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-[24px] shadow-2xl border border-white/70 dark:border-slate-850 overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/50">
                                <h4 class="text-[16px] font-black text-slate-900 dark:text-white">Simpan Template Struk</h4>
                                <p class="text-[12px] font-medium text-slate-500 dark:text-slate-400 mt-1">Template tersimpan di browser ini dan bisa dipakai lagi dari dropdown.</p>
                            </div>
                            <div class="p-6 space-y-4">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Template</label>
                                    <input type="text" x-model="templateForm.name" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:ring-0" placeholder="Contoh: Struk Promo">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Keterangan</label>
                                    <textarea x-model="templateForm.desc" rows="3" class="w-full bg-slate-50 dark:bg-slate-850 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-sm text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:ring-0 resize-none" placeholder="Keterangan singkat template..."></textarea>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-slate-50/70 dark:bg-slate-900/50 flex justify-end gap-2">
                                <button type="button" @click="showTemplateModal = false" class="px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-800 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 transition-all">Batal</button>
                                <button type="button" @click="saveCurrentAsTemplate()" class="px-4 py-2.5 bg-indigo-600 text-white hover:bg-white hover:text-indigo-600 border border-transparent hover:border-indigo-600 rounded-xl text-xs font-bold transition-all">Simpan Template</button>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Real Thermal Receipt Preview Modal --}}
                <template x-teleport="body">
                    <div x-show="showPreviewModal" class="fixed inset-0 z-[150] flex items-center justify-center p-6" x-transition>
                        {{-- Dark Blur Backdrop --}}
                        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md cursor-pointer" @click="showPreviewModal = false"></div>
                        
                        {{-- Floating Receipt Container --}}
                        <div class="relative z-10 overflow-auto max-h-[90vh] max-w-full hide-scrollbar flex flex-col items-center justify-center p-12" @click.self="showPreviewModal = false">
                            <div class="transition-transform duration-200 my-auto flex items-center justify-center" :style="{ transform: 'scale(' + previewZoom + ')', transformOrigin: 'center center' }">
                                {{-- Thermal Paper Struk --}}
                                <div :style="{ width: canvas.width + canvas.unit, minHeight: canvas.height + canvas.unit, backgroundColor: canvas.bg, position: 'relative' }"
                                     class="shadow-[0_25px_60px_-15px_rgba(0,0,0,0.5)] rounded-sm p-6 overflow-hidden select-none text-slate-900 border border-slate-200/40">
                                     
                                    {{-- Perforated top --}}
                                    <div class="absolute -top-2 left-0 right-0 h-2 overflow-hidden z-10">
                                        <div style="background: radial-gradient(circle at 5px 100%, transparent 4px, #cbd5e1 5px); background-size: 10px 10px; height: 100%; width: 100%;"></div>
                                    </div>

                                    {{-- Latar Default overlay --}}
                                    <template x-if="canvas.useDefaultBg">
                                        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0 rounded-sm">
                                            <div class="absolute inset-[-60%] flex flex-wrap justify-center content-center transform -rotate-12" :style="{ opacity: canvas.defaultBgOpacity }">
                                                <template x-for="i in 80">
                                                    <span class="px-6 py-4 whitespace-nowrap leading-none"
                                                          :class="{ 'uppercase': authBg.case === 'uppercase', 'lowercase': authBg.case === 'lowercase', 'italic': authBg.italic === 'true', 'line-through': authBg.strikethrough === 'true' }"
                                                          :style="{ color: authBg.textColor, fontFamily: authBg.font, fontSize: Math.max(18, authBg.size * 0.38) + 'px', fontWeight: authBg.weight }"
                                                          x-text="authBg.text"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Elements --}}
                                    <template x-for="el in elements" :key="el.id">
                                        <div :style="{
                                            position: 'absolute',
                                            left: el.x + 'px',
                                            top: el.y + 'px',
                                            width: el.width + 'px',
                                            zIndex: 1
                                        }">
                                            <template x-if="el.type === 'text'">
                                                <div :style="{
                                                    fontFamily: el.fontFamily,
                                                    fontSize: el.fontSize + 'px',
                                                    color: el.color,
                                                    textAlign: el.align,
                                                    fontWeight: el.bold ? 'bold' : 'normal',
                                                    fontStyle: el.italic ? 'italic' : 'normal',
                                                    textDecoration: el.underline ? 'underline' : 'none',
                                                    lineHeight: '1.4',
                                                    whiteSpace: 'pre-wrap',
                                                    wordBreak: 'break-word'
                                                }" x-text="getRealPreviewText(el.text)"></div>
                                            </template>
                                            <template x-if="el.type === 'divider'">
                                                <div :style="{ borderTop: '1px ' + (el.dashed ? 'dashed' : 'solid') + ' ' + el.color, width: '100%', marginTop: '4px' }"></div>
                                            </template>
                                            <template x-if="el.type === 'logo'">
                                                <div>
                                                    <template x-if="logoDataUrl">
                                                        <img :src="logoDataUrl" :style="{maxHeight: el.fontSize + 'px', maxWidth: el.width + 'px', display: 'block', margin: el.align === 'center' ? '0 auto' : (el.align === 'right' ? '0 0 0 auto' : '0')}" alt="Logo">
                                                    </template>
                                                    <template x-if="!logoDataUrl">
                                                        <div class="h-10 bg-slate-100 rounded border border-dashed border-slate-300"></div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    {{-- Perforated bottom --}}
                                    <div class="absolute -bottom-2 left-0 right-0 h-2 overflow-hidden">
                                        <div style="background: radial-gradient(circle at 5px 0, transparent 4px, #cbd5e1 5px); background-size: 10px 10px; height: 100%; width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Zoom Controller -->
                        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-2xl border border-slate-200/80 dark:border-slate-800 flex items-center gap-3 text-xs font-bold text-slate-700 dark:text-slate-200">
                            <button type="button" @click="previewZoom = Math.max(0.4, previewZoom - 0.1)" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all text-sm font-black shadow-sm">-</button>
                            <span class="min-w-[40px] text-center" x-text="Math.round(previewZoom * 100) + '%'"></span>
                            <button type="button" @click="previewZoom = Math.min(2.0, previewZoom + 0.1)" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all text-sm font-black shadow-sm">+</button>
                            <div class="h-4 w-[1px] bg-slate-200 dark:bg-slate-800"></div>
                            <button type="button" @click="previewZoom = 1.0" class="px-3 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">Reset</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ================================================================
             Unified Save Button
        ================================================================ --}}
        <div class="flex items-center justify-end pb-12">
            <button type="submit" id="main-save-btn"
                class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 dark:bg-slate-800 text-white hover:bg-white dark:hover:bg-white hover:text-slate-900 dark:hover:text-slate-900 border border-transparent hover:border-slate-900 dark:hover:border-transparent font-bold text-[15px] rounded-2xl hover:shadow-lg hover:-translate-y-0.5 transition-all">
                Simpan Pengaturan
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
    // ===== Auth Background Preview =====
    document.addEventListener('alpine:init', () => {
        Alpine.data('authBackgroundPreview', () => {
            return {
                bgType:          '{{ $authBgType }}',
                bgText:          '{{ $authBgText }}',
                bgFont:          '{{ $authBg['font'] ?? 'Inter' }}',
                bgSize:          '{{ $authBg['size'] ?? 80 }}',
                bgWeight:        '{{ $authBg['weight'] ?? 900 }}',
                bgCase:          '{{ $authBg['case'] ?? 'normal' }}',
                bgItalic:        '{{ $authBg['italic'] ?? 'false' }}',
                bgStrikethrough: '{{ $authBg['strikethrough'] ?? 'false' }}',
                bgTextColor:     '{{ $authBg['text_color'] ?? '#0f172a' }}',
                bgColor:         '{{ $authBg['bg_color'] ?? '#f8fafc' }}',
                bgAutoColor:     '{{ $authBg['auto_color'] ?? 'true' }}',
                imagePreviewUrl: null,

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.imagePreviewUrl = URL.createObjectURL(file);
                    } else {
                        this.imagePreviewUrl = null;
                    }
                },

                get computedBgColor() {
                    if (this.bgAutoColor === 'true') {
                        const hex = this.bgTextColor.replace('#', '');
                        const r = parseInt(hex.substring(0, 2), 16) || 0;
                        const g = parseInt(hex.substring(2, 4), 16) || 0;
                        const b = parseInt(hex.substring(4, 6), 16) || 0;
                        return `rgba(${r}, ${g}, ${b}, 0.05)`;
                    }
                    return this.bgColor;
                }
            }
        })
    })

    // ===== Receipt Editor =====
    function receiptEditor() {
        return {
            canvas: {
                width:        {{ $canvasWidth }},
                height:       {{ $canvasHeight }},
                unit:         @json($canvasUnit),
                bg:           @json($canvasBg),
                useDefaultBg: {{ $canvasDefaultBg ? 'true' : 'false' }},
                defaultBgOpacity: Number(@json($canvasDefaultBgOpacity))
            },
            elements:    @json($elements),
            selectedId:  null,
            logoDataUrl: @json(!empty($receipt['logo_data']) ? $receipt['logo_data'] : null),
            templateChoice: '',
            templateOpen: false,
            customTemplates: [],
            showTemplateModal: false,
            showPreviewModal: false,
            previewZoom: 1.0,
            templateForm: { name: '', desc: '' },
            floating: { visible: false, left: 0, top: 0 },
            authBg: {
                text: @json($authBgText),
                font: @json($authBg['font'] ?? 'Inter'),
                size: Number(@json($authBg['size'] ?? 80)),
                weight: Number(@json($authBg['weight'] ?? 900)),
                case: @json($authBg['case'] ?? 'normal'),
                italic: @json($authBg['italic'] ?? 'false'),
                strikethrough: @json($authBg['strikethrough'] ?? 'false'),
                textColor: @json($authBg['text_color'] ?? '#0f172a'),
                bgColor: @json($authBg['bg_color'] ?? '#f8fafc'),
                autoColor: @json($authBg['auto_color'] ?? 'true'),
            },
            saveState:  'saved',
            dragging:    null,
            resizing:    null,

            get selectedEl() {
                if (this.selectedId === null) return null;
                return this.elements.find(e => e.id === this.selectedId) || null;
            },

            get authComputedBgColor() {
                if (this.authBg.autoColor === 'true') {
                    const hex = String(this.authBg.textColor || '#0f172a').replace('#', '');
                    const r = parseInt(hex.substring(0, 2), 16) || 0;
                    const g = parseInt(hex.substring(2, 4), 16) || 0;
                    const b = parseInt(hex.substring(4, 6), 16) || 0;
                    return `rgba(${r}, ${g}, ${b}, 0.05)`;
                }
                return this.authBg.bgColor || '#f8fafc';
            },

            get templates() {
                const builtIns = [
                    { id: 'modern', name: 'Modern Syabaab', desc: 'Brand kuat, latar auth, total menonjol' },
                    { id: 'clean', name: 'Bersih Formal', desc: 'Rapi untuk transaksi resmi' },
                    { id: 'compact', name: 'Thermal Ringkas', desc: 'Padat untuk struk kecil' },
                    { id: 'premium', name: 'Premium Soft', desc: 'Elegan dengan latar auth lembut' },
                    { id: 'minimal', name: 'Minimal Mono', desc: 'Tipografi sederhana dan hemat ruang' },
                    { id: 'service', name: 'Service Detail', desc: 'Fokus pada layanan dan pelanggan' },
                    { id: 'thankful', name: 'Thank You Card', desc: 'Lebih personal untuk pelanggan' },
                ];
                return [...builtIns, ...this.customTemplates];
            },

            get selectedTemplateLabel() {
                const selected = this.templates.find(t => t.id === this.templateChoice);
                return selected ? selected.name : 'Pilih template struk';
            },

            init() {
                this.loadCustomTemplates();

                // Sync canvas data into the unified form on submit
                const form = document.getElementById('personalisasi-form');
                form.addEventListener('submit', () => {
                    this._writeToHiddenInputs();
                });

                // Mouse events for drag/resize
                document.addEventListener('mousemove', (e) => this.onMouseMove(e));
                document.addEventListener('mouseup',   (e) => this.onMouseUp(e));
                window.addEventListener('scroll', () => this.positionFloatingToolbar(), true);
                window.addEventListener('resize', () => this.positionFloatingToolbar());

                // Initial sync
                this.syncCanvasToForm();
            },

            _writeToHiddenInputs() {
                const data = {
                    canvas_width:        this.canvas.width,
                    canvas_height:       this.canvas.height,
                    canvas_unit:         this.canvas.unit,
                    canvas_bg:           this.canvas.bg,
                    canvas_use_default_bg: this.canvas.useDefaultBg,
                    canvas_default_bg_opacity: this.canvas.defaultBgOpacity,
                    elements:            this.elements,
                    logo_data:           this.logoDataUrl,
                };
                document.getElementById('canvas-data-input').value = JSON.stringify(data);
                document.getElementById('logo-data-input').value   = this.logoDataUrl || '';
            },

            syncCanvasToForm() {
                this._writeToHiddenInputs();
                this.debouncedAutoSave();
            },

            addElement(type) {
                const id   = Date.now();
                const base = { id, type, x: 20, y: 20, width: this.canvas.width - 40, color: '#111827' };
                if (type === 'text')    Object.assign(base, { text: 'Teks baru', fontFamily: 'Inter, sans-serif', fontSize: 14, bold: false, italic: false, underline: false, align: 'left' });
                else if (type === 'divider') Object.assign(base, { dashed: true });
                else if (type === 'logo')    Object.assign(base, { fontSize: 50, align: 'left' });
                this.elements.push(base);
                this.selectElement(base);
                this.syncCanvasToForm();
            },

            changeUnit(newUnit) {
                const oldUnit = this.canvas.unit;
                if (oldUnit === newUnit) return;

                const toPx = { px: 1, in: 96, cm: 96 / 2.54, mm: 96 / 25.4 };
                const widthInPx = this.canvas.width * toPx[oldUnit];
                const heightInPx = this.canvas.height * toPx[oldUnit];

                let newWidth = widthInPx / toPx[newUnit];
                let newHeight = heightInPx / toPx[newUnit];

                if (newUnit === 'px') {
                    newWidth = Math.round(newWidth);
                    newHeight = Math.round(newHeight);
                } else if (newUnit === 'in') {
                    newWidth = parseFloat(newWidth.toFixed(2));
                    newHeight = parseFloat(newHeight.toFixed(2));
                } else {
                    newWidth = parseFloat(newWidth.toFixed(1));
                    newHeight = parseFloat(newHeight.toFixed(1));
                }

                this.canvas.unit = newUnit;
                this.canvas.width = newWidth;
                this.canvas.height = newHeight;
                this.syncCanvasToForm();
            },

            applyTemplate(templateId) {
                if (!templateId) return;

                const stored = this.customTemplates.find(t => t.id === templateId);
                const tpl = stored ? stored.payload : this.buildTemplate(templateId);
                this.canvas.width = tpl.canvas.width;
                this.canvas.height = tpl.canvas.height;
                this.canvas.unit = tpl.canvas.unit || 'px';
                this.canvas.bg = tpl.canvas.bg;
                this.canvas.useDefaultBg = tpl.canvas.useDefaultBg;
                this.canvas.defaultBgOpacity = tpl.canvas.defaultBgOpacity;
                this.elements = tpl.elements.map((el, index) => ({ ...el, id: Date.now() + index }));
                if (tpl.logoDataUrl !== undefined) this.logoDataUrl = tpl.logoDataUrl;
                this.selectedId = null;
                this.floating.visible = false;
                this.templateChoice = '';
                this.syncCanvasToForm();
            },

            loadCustomTemplates() {
                try {
                    const saved = JSON.parse(localStorage.getItem('receipt_custom_templates') || '[]');
                    this.customTemplates = Array.isArray(saved) ? saved : [];
                } catch (e) {
                    this.customTemplates = [];
                }
            },

            persistCustomTemplates() {
                localStorage.setItem('receipt_custom_templates', JSON.stringify(this.customTemplates));
            },

            openTemplateModal() {
                this.templateForm = { name: '', desc: '' };
                this.showTemplateModal = true;
            },

            saveCurrentAsTemplate() {
                const name = (this.templateForm.name || '').trim();
                if (!name) return;

                const template = {
                    id: 'custom-' + Date.now(),
                    name,
                    desc: (this.templateForm.desc || '').trim() || 'Template buatan sendiri',
                    payload: {
                        canvas: { ...this.canvas },
                        elements: this.elements.map(el => ({ ...el })),
                        logoDataUrl: this.logoDataUrl,
                    },
                };

                this.customTemplates.push(template);
                this.persistCustomTemplates();
                this.showTemplateModal = false;
            },

            buildTemplate(templateId) {
                const font = 'Inter, sans-serif';
                const slate = '#0f172a';
                const muted = '#64748b';
                const line = '#cbd5e1';
                const brand = '#4f46e5';
                const authBg = this.authComputedBgColor;

                const text = (x, y, width, value, size = 13, color = slate, bold = false, align = 'left') => ({
                    type: 'text', x, y, width, text: value, fontFamily: font, fontSize: size,
                    color, bold, italic: false, underline: false, align
                });
                const divider = (x, y, width, color = line, dashed = true) => ({
                    type: 'divider', x, y, width, color, dashed
                });

                if (templateId === 'clean') {
                    return {
                        canvas: { width: 380, height: 560, bg: '#ffffff', useDefaultBg: false, defaultBgOpacity: 0.18, unit: 'px' },
                        elements: [
                            text(24, 28, 332, 'Syabaab Creative', 22, slate, true, 'center'),
                            text(24, 60, 332, 'Struk pemesanan resmi', 11, muted, false, 'center'),
                            divider(24, 92, 332),
                            text(24, 116, 120, 'No. Pesanan', 11, muted, true),
                            text(160, 116, 196, '{order_number}', 12, slate, true, 'right'),
                            text(24, 144, 120, 'Tanggal', 11, muted, true),
                            text(160, 144, 196, '{date}', 12, slate, false, 'right'),
                            text(24, 184, 332, 'Pemesan', 11, muted, true),
                            text(24, 206, 332, '{customer_name}', 18, slate, true),
                            text(24, 232, 332, '{phone}', 12, muted),
                            divider(24, 270, 332),
                            text(24, 300, 200, '{service_name}', 14, slate, true),
                            text(224, 300, 132, '{total_amount}', 14, slate, true, 'right'),
                            divider(24, 352, 332, slate, false),
                            text(24, 380, 100, 'Total', 13, muted, true),
                            text(150, 376, 206, '{total_amount}', 24, brand, true, 'right'),
                            text(24, 500, 332, 'Terima kasih atas pesanan Anda.', 12, muted, false, 'center'),
                        ],
                    };
                }

                if (templateId === 'compact') {
                    return {
                        canvas: { width: 320, height: 520, bg: '#ffffff', useDefaultBg: false, defaultBgOpacity: 0.16, unit: 'px' },
                        elements: [
                            text(18, 24, 284, 'SYABAAB', 20, slate, true, 'center'),
                            text(18, 50, 284, 'Creative Platform', 10, muted, true, 'center'),
                            divider(18, 78, 284),
                            text(18, 102, 284, 'ORDER: {order_number}', 12, slate, true, 'center'),
                            text(18, 124, 284, '{date}', 10, muted, false, 'center'),
                            divider(18, 154, 284),
                            text(18, 182, 86, 'Nama', 11, muted, true),
                            text(104, 182, 198, '{customer_name}', 12, slate, false, 'right'),
                            text(18, 212, 86, 'Layanan', 11, muted, true),
                            text(104, 212, 198, '{service_name}', 12, slate, false, 'right'),
                            text(18, 252, 86, 'Total', 12, slate, true),
                            text(104, 246, 198, '{total_amount}', 20, slate, true, 'right'),
                            divider(18, 300, 284),
                            text(18, 332, 284, 'Simpan struk ini sebagai bukti transaksi.', 11, muted, false, 'center'),
                            text(18, 430, 284, 'Terima kasih', 14, slate, true, 'center'),
                        ],
                    };
                }

                if (templateId === 'premium') {
                    return {
                        canvas: { width: 420, height: 620, bg: authBg, useDefaultBg: true, defaultBgOpacity: 0.18, unit: 'px' },
                        elements: [
                            text(34, 42, 352, 'Syabaab Creative', 24, slate, true, 'center'),
                            text(34, 78, 352, 'Premium service receipt', 11, brand, true, 'center'),
                            divider(34, 118, 352, '#a5b4fc', false),
                            text(34, 148, 160, 'Nomor Pesanan', 11, muted, true),
                            text(204, 148, 182, '{order_number}', 13, slate, true, 'right'),
                            text(34, 178, 160, 'Tanggal', 11, muted, true),
                            text(204, 178, 182, '{date}', 13, slate, false, 'right'),
                            text(34, 230, 352, '{customer_name}', 22, slate, true, 'center'),
                            text(34, 260, 352, '{phone}', 12, muted, false, 'center'),
                            divider(34, 306, 352),
                            text(34, 340, 210, '{service_name}', 15, slate, true),
                            text(254, 340, 132, '{total_amount}', 15, slate, true, 'right'),
                            text(34, 420, 130, 'Total Pembayaran', 12, muted, true),
                            text(164, 414, 222, '{total_amount}', 26, brand, true, 'right'),
                            text(34, 552, 352, 'Terima kasih sudah mempercayakan kebutuhan kreatif Anda kepada kami.', 12, muted, false, 'center'),
                        ],
                    };
                }

                if (templateId === 'minimal') {
                    return {
                        canvas: { width: 340, height: 540, bg: '#ffffff', useDefaultBg: false, defaultBgOpacity: 0.12, unit: 'px' },
                        elements: [
                            text(22, 26, 296, 'SYABAAB CREATIVE', 16, slate, true, 'center'),
                            divider(22, 62, 296, slate, false),
                            text(22, 90, 120, 'NO', 10, muted, true),
                            text(148, 90, 170, '{order_number}', 11, slate, true, 'right'),
                            text(22, 116, 120, 'DATE', 10, muted, true),
                            text(148, 116, 170, '{date}', 11, slate, false, 'right'),
                            divider(22, 152, 296),
                            text(22, 184, 296, '{customer_name}', 15, slate, true),
                            text(22, 210, 296, '{service_name}', 12, muted),
                            divider(22, 260, 296),
                            text(22, 292, 90, 'TOTAL', 12, slate, true),
                            text(112, 286, 206, '{total_amount}', 22, slate, true, 'right'),
                            text(22, 470, 296, 'Terima kasih.', 11, muted, false, 'center'),
                        ],
                    };
                }

                if (templateId === 'service') {
                    return {
                        canvas: { width: 400, height: 600, bg: '#f8fafc', useDefaultBg: true, defaultBgOpacity: 0.12, unit: 'px' },
                        elements: [
                            text(28, 34, 344, 'Detail Pemesanan', 24, slate, true),
                            text(28, 68, 344, 'Syabaab Creative Platform', 11, brand, true),
                            divider(28, 108, 344, '#c7d2fe', false),
                            text(28, 138, 142, 'Pemesan', 11, muted, true),
                            text(170, 134, 202, '{customer_name}', 16, slate, true, 'right'),
                            text(28, 168, 142, 'Kontak', 11, muted, true),
                            text(170, 168, 202, '{phone}', 12, slate, false, 'right'),
                            text(28, 218, 344, 'Layanan', 11, muted, true),
                            text(28, 242, 344, '{service_name}', 20, slate, true),
                            divider(28, 304, 344),
                            text(28, 334, 142, 'No. Pesanan', 11, muted, true),
                            text(170, 334, 202, '{order_number}', 13, slate, true, 'right'),
                            text(28, 364, 142, 'Tanggal', 11, muted, true),
                            text(170, 364, 202, '{date}', 13, slate, false, 'right'),
                            text(28, 440, 120, 'Total', 12, muted, true),
                            text(148, 432, 224, '{total_amount}', 26, brand, true, 'right'),
                            text(28, 540, 344, 'Struk ini sah sebagai bukti pesanan.', 11, muted, false, 'center'),
                        ],
                    };
                }

                if (templateId === 'thankful') {
                    return {
                        canvas: { width: 380, height: 600, bg: authBg, useDefaultBg: true, defaultBgOpacity: 0.1, unit: 'px' },
                        elements: [
                            text(28, 46, 324, 'Terima Kasih', 30, slate, true, 'center'),
                            text(28, 88, 324, '{customer_name}', 18, brand, true, 'center'),
                            divider(54, 132, 272, '#c7d2fe', false),
                            text(28, 166, 324, 'Pesanan Anda telah tercatat di Syabaab Creative.', 13, muted, false, 'center'),
                            text(28, 232, 130, 'Nomor', 11, muted, true),
                            text(158, 232, 194, '{order_number}', 13, slate, true, 'right'),
                            text(28, 264, 130, 'Layanan', 11, muted, true),
                            text(158, 264, 194, '{service_name}', 13, slate, false, 'right'),
                            text(28, 296, 130, 'Tanggal', 11, muted, true),
                            text(158, 296, 194, '{date}', 13, slate, false, 'right'),
                            divider(28, 356, 324),
                            text(28, 392, 130, 'Total', 12, slate, true),
                            text(158, 384, 194, '{total_amount}', 24, brand, true, 'right'),
                            text(28, 526, 324, 'Kami akan menghubungi Anda untuk proses berikutnya.', 12, muted, false, 'center'),
                        ],
                    };
                }

                return {
                    canvas: { width: 380, height: 580, bg: authBg, useDefaultBg: true, defaultBgOpacity: 0.16, unit: 'px' },
                    elements: [
                        text(26, 34, 328, 'Syabaab', 28, slate, true, 'center'),
                        text(26, 68, 328, 'Creative Platform', 10, brand, true, 'center'),
                        divider(26, 106, 328, '#a5b4fc', false),
                        text(26, 134, 130, 'Struk Pesanan', 12, muted, true),
                        text(166, 130, 188, '{order_number}', 15, slate, true, 'right'),
                        text(26, 162, 130, 'Tanggal', 11, muted, true),
                        text(166, 162, 188, '{date}', 12, slate, false, 'right'),
                        text(26, 212, 328, '{customer_name}', 22, slate, true),
                        text(26, 240, 328, '{phone}', 12, muted),
                        divider(26, 286, 328),
                        text(26, 320, 188, '{service_name}', 15, slate, true),
                        text(214, 320, 140, '{total_amount}', 15, slate, true, 'right'),
                        divider(26, 380, 328, slate, false),
                        text(26, 412, 120, 'Total', 13, muted, true),
                        text(146, 406, 208, '{total_amount}', 25, brand, true, 'right'),
                        text(26, 520, 328, 'Terima kasih atas pesanan Anda.', 12, muted, false, 'center'),
                    ],
                };
            },

            updateEl()        { this.debouncedAutoSave(); this.positionFloatingToolbar(); },
            toggleBold()      { if (this.selectedEl) { this.selectedEl.bold      = !this.selectedEl.bold;      this.updateEl(); } },
            toggleItalic()    { if (this.selectedEl) { this.selectedEl.italic    = !this.selectedEl.italic;    this.updateEl(); } },
            toggleUnderline() { if (this.selectedEl) { this.selectedEl.underline = !this.selectedEl.underline; this.updateEl(); } },

            selectElement(el) {
                this.selectedId = el.id;
                this.$nextTick(() => this.positionFloatingToolbar());
            },

            positionFloatingToolbar() {
                if (!this.selectedEl) {
                    this.floating.visible = false;
                    return;
                }

                const node = document.getElementById('el-' + this.selectedId);
                if (!node) {
                    this.floating.visible = false;
                    return;
                }

                // Show it first so its dimensions can be read in nextTick
                this.floating.visible = true;

                const rect = node.getBoundingClientRect();
                
                this.$nextTick(() => {
                    const toolbar = document.getElementById('floating-toolbar');
                    const toolbarWidth = toolbar && toolbar.offsetWidth > 0 ? toolbar.offsetWidth : (this.selectedEl.type === 'text' ? 520 : 330);
                    const toolbarHeight = toolbar && toolbar.offsetHeight > 0 ? toolbar.offsetHeight : 52;

                    const left = Math.max(12, Math.min(window.innerWidth - toolbarWidth - 12, rect.left + (rect.width / 2) - (toolbarWidth / 2)));
                    
                    let top = rect.top - toolbarHeight - 8;
                    if (top < 10) {
                        top = rect.bottom + 8;
                    }
                    if (top + toolbarHeight > window.innerHeight - 10) {
                        top = window.innerHeight - toolbarHeight - 10;
                    }

                    this.floating.left = left;
                    this.floating.top = top;
                });
            },

            deleteSelected() {
                this.elements  = this.elements.filter(e => e.id !== this.selectedId);
                this.selectedId = null;
                this.floating.visible = false;
                this.syncCanvasToForm();
            },

            insertVar(v) {
                if (this.selectedEl && this.selectedEl.type === 'text') {
                    this.selectedEl.text = (this.selectedEl.text || '') + v;
                    this.debouncedAutoSave();
                }
            },

            uploadLogo(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.logoDataUrl = e.target.result;
                    this.syncCanvasToForm();
                    this.positionFloatingToolbar();
                };
                reader.readAsDataURL(file);
            },

            _autoSaveTimer: null,
            debouncedAutoSave() {
                this._writeToHiddenInputs();
                this.saveState = 'saving';
                clearTimeout(this._autoSaveTimer);
                this._autoSaveTimer = setTimeout(() => this._autoSave(), 1200);
            },

            _autoSave() {
                this._writeToHiddenInputs();
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append('canvas_data', document.getElementById('canvas-data-input').value);
                formData.append('logo_data', this.logoDataUrl || '');
                fetch('{{ route('settings.receipt.store') }}', {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                }).then(r => {
                    if (r.ok || r.redirected) {
                        this.saveState = 'saved';
                    }
                }).catch(() => {
                    this.saveState = 'saved';
                });
            },

            startDrag(e, el) {
                this.selectElement(el);
                this.dragging = { id: el.id, startX: e.clientX, startY: e.clientY, origX: el.x, origY: el.y };
            },

            startResize(e, el) {
                this.resizing = { id: el.id, startX: e.clientX, origWidth: el.width };
            },

            onMouseMove(e) {
                if (this.dragging) {
                    const dx = e.clientX - this.dragging.startX;
                    const dy = e.clientY - this.dragging.startY;
                    const el = this.elements.find(el => el.id === this.dragging.id);
                    if (el) { el.x = Math.max(0, this.dragging.origX + dx); el.y = Math.max(0, this.dragging.origY + dy); }
                    this.positionFloatingToolbar();
                }
                if (this.resizing) {
                    const dx = e.clientX - this.resizing.startX;
                    const el = this.elements.find(el => el.id === this.resizing.id);
                    if (el) { el.width = Math.max(20, this.resizing.origWidth + dx); }
                    this.positionFloatingToolbar();
                }
            },

            onMouseUp() {
                if (this.dragging || this.resizing) {
                    this.dragging = null; this.resizing = null;
                    this.debouncedAutoSave();
                }
            },

            getRealPreviewText(text) {
                if (!text) return '';
                return text
                    .replace(/{order_number}/g, 'ORD-20260629-0042')
                    .replace(/{date}/g, '29 Jun 2026 20:45')
                    .replace(/{customer_name}/g, 'Budi Santoso')
                    .replace(/{phone}/g, '0812-3456-7890')
                    .replace(/{service_name}/g, 'Layanan Premium Syabaab')
                    .replace(/{total_amount}/g, 'Rp 150.000');
            }
        };
    }
    </script>
    @endpush

</x-settings-layout>
