<?php

$file = 'resources/views/settings/landing.blade.php';
$content = file_get_contents($file);

$newTypoBlock = <<<'EOT'
                <!-- Auth Page Background -->
                <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 overflow-hidden mb-8" x-data="authBackgroundPreview()">
                    <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-[16px] font-bold text-slate-900">Auth Page Background</h3>
                        <p class="text-[13px] text-slate-500 mt-1">Ubah latar belakang untuk halaman login dan register.</p>
                    </div>
                    
                    <div class="p-8 flex flex-col gap-8">
                        @php
                            $authBg = json_decode($settings['auth_background'] ?? '{}', true);
                            $authBgType = $authBg['type'] ?? 'color';
                            $authBgText = $authBg['text'] ?? 'Syabaab Creative';
                            $authBgImage = $authBg['image'] ?? '';
                        @endphp
                        
                        <!-- Live Preview (Moved to TOP) -->
                        <div>
                            <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-3">Live Preview</label>
                            <div class="w-full h-80 sm:h-96 rounded-[20px] border-2 border-slate-200 overflow-hidden relative flex items-center justify-center transition-colors duration-300" :style="bgType === 'color' ? `background-color: ${computedBgColor}` : ''">
                                
                                <!-- Typography Background Preview -->
                                <template x-if="bgType === 'color'">
                                    <div class="absolute inset-0 overflow-hidden flex flex-wrap pointer-events-none select-none">
                                        <template x-for="i in 100">
                                            <span class="p-4 text-slate-900 whitespace-nowrap transform -rotate-12" :class="typographyClasses" :style="typographyStyles" x-text="bgText || 'Teks Tipografi'"></span>
                                        </template>
                                    </div>
                                </template>

                                <!-- Image Background Preview -->
                                <template x-if="bgType === 'image'">
                                    <div class="absolute inset-0 w-full h-full">
                                        <div x-show="!imagePreviewUrl" class="w-full h-full bg-cover bg-center" style="background-image: url('{{ $authBgImage ? asset('storage/' . $authBgImage) : '' }}')"></div>
                                        <div x-show="imagePreviewUrl" class="w-full h-full bg-cover bg-center" :style="`background-image: url('${imagePreviewUrl}')`"></div>
                                        
                                        <!-- Placeholder if no image -->
                                        <div x-show="!imagePreviewUrl && !'{{ $authBgImage }}'" class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <span class="text-gray-400 text-sm">Belum ada gambar</span>
                                        </div>
                                    </div>
                                </template>

                                <!-- Mock Auth Box -->
                                <div class="relative z-10 w-64 bg-white/90 backdrop-blur-xl rounded-[20px] shadow-lg border border-slate-200 p-6">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full mb-4 mx-auto flex items-center justify-center">
                                        <div class="w-5 h-5 bg-indigo-600 rounded-full"></div>
                                    </div>
                                    <div class="w-3/4 h-3 bg-slate-200 rounded-full mx-auto mb-6"></div>
                                    <div class="space-y-3">
                                        <div class="w-full h-10 bg-slate-100 rounded-xl"></div>
                                        <div class="w-full h-10 bg-slate-100 rounded-xl"></div>
                                        <div class="w-full h-10 bg-indigo-600 rounded-xl mt-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Inputs -->
                        <div class="space-y-8 pt-4 border-t border-slate-100">
                            <div>
                                <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-3">Tipe Latar Belakang</label>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center group cursor-pointer">
                                        <div class="relative flex items-center justify-center w-5 h-5 mr-3">
                                            <input type="radio" name="auth_bg_type" value="color" x-model="bgType" class="peer sr-only">
                                            <div class="w-full h-full border-2 border-slate-300 rounded-full peer-checked:border-indigo-600 transition-colors"></div>
                                            <div class="absolute w-2.5 h-2.5 bg-indigo-600 rounded-full opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200"></div>
                                        </div>
                                        <span class="text-[15px] font-medium text-slate-700 group-hover:text-indigo-600 transition-colors">Warna Solid / Tipografi</span>
                                    </label>
                                    <label class="flex items-center group cursor-pointer">
                                        <div class="relative flex items-center justify-center w-5 h-5 mr-3">
                                            <input type="radio" name="auth_bg_type" value="image" x-model="bgType" class="peer sr-only">
                                            <div class="w-full h-full border-2 border-slate-300 rounded-full peer-checked:border-indigo-600 transition-colors"></div>
                                            <div class="absolute w-2.5 h-2.5 bg-indigo-600 rounded-full opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200"></div>
                                        </div>
                                        <span class="text-[15px] font-medium text-slate-700 group-hover:text-indigo-600 transition-colors">Gambar Latar</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Typography Settings -->
                            <div x-show="bgType === 'color'" x-transition class="space-y-8">
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Teks dan Format Tambahan -->
                                    <div>
                                        <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Teks Tipografi & Format</label>
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                            <input type="text" name="auth_bg_text" x-model="bgText" class="flex-1 w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" placeholder="Syabaab Creative">
                                            
                                            <!-- Toggles: Italic, Strikethrough -->
                                            <div class="flex items-center bg-slate-100 p-1 rounded-xl shrink-0">
                                                <input type="hidden" name="auth_bg_italic" :value="bgItalic">
                                                <input type="hidden" name="auth_bg_strikethrough" :value="bgStrikethrough">
                                                
                                                <button type="button" @click="bgItalic = bgItalic === 'true' ? 'false' : 'true'" class="flex items-center justify-center w-10 h-10 rounded-lg text-[16px] transition-all duration-300 italic font-serif" :class="bgItalic === 'true' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'" title="Miring (Italic)">
                                                    I
                                                </button>
                                                <button type="button" @click="bgStrikethrough = bgStrikethrough === 'true' ? 'false' : 'true'" class="flex items-center justify-center w-10 h-10 rounded-lg text-[16px] transition-all duration-300 line-through" :class="bgStrikethrough === 'true' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'" title="Coret (Strikethrough)">
                                                    S
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Font Custom Dropdown -->
                                    <div>
                                        <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Jenis Font</label>
                                        <div x-data="{ 
                                            open: false, 
                                            fonts: {
                                                'Inter': 'Inter',
                                                'Arial': 'Arial',
                                                'Georgia': 'Georgia',
                                                'Courier New': 'Courier New',
                                                'Times New Roman': 'Times New Roman',
                                                'Verdana': 'Verdana',
                                                'Impact': 'Impact',
                                                'Comic Sans MS': 'Comic Sans MS',
                                                'Trebuchet MS': 'Trebuchet MS'
                                            },
                                            get label() { 
                                                return this.fonts[bgFont] || 'Inter'; 
                                            } 
                                        }" class="relative">
                                            <input type="hidden" name="auth_bg_font" :value="bgFont">
                                            <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 px-0 py-2 text-[16px] font-medium text-slate-900 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                                <span x-text="label" :style="`font-family: ${bgFont}`"></span>
                                                <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-[16px] shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                                                <div class="p-2 max-h-60 overflow-y-auto">
                                                    <template x-for="(fontName, fontKey) in fonts" :key="fontKey">
                                                        <button type="button" @click="bgFont = fontKey; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between" :class="bgFont == fontKey ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 font-medium'">
                                                            <span x-text="fontName" :style="`font-family: ${fontKey}`"></span>
                                                            <svg x-show="bgFont == fontKey" class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Format Teks (Case Toggle Buttons) -->
                                    <div>
                                        <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Kapitalisasi Teks</label>
                                        <input type="hidden" name="auth_bg_case" :value="bgCase">
                                        <div class="flex flex-wrap gap-2 items-center bg-slate-100 p-1 rounded-2xl w-full sm:w-fit">
                                            <button type="button" @click="bgCase = 'normal'" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-2 rounded-xl text-[14px] font-bold transition-all duration-300" :class="bgCase === 'normal' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'">
                                                Aa
                                            </button>
                                            <button type="button" @click="bgCase = 'lowercase'" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-2 rounded-xl text-[14px] font-bold transition-all duration-300 lowercase" :class="bgCase === 'lowercase' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'">
                                                aa
                                            </button>
                                            <button type="button" @click="bgCase = 'uppercase'" class="flex-1 sm:flex-none flex items-center justify-center px-6 py-2 rounded-xl text-[14px] font-bold transition-all duration-300 uppercase" :class="bgCase === 'uppercase' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'">
                                                AA
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Size Slider -->
                                    <div>
                                        <div class="flex justify-between items-end mb-2">
                                            <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider">Ukuran Teks</label>
                                            <span class="text-[12px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg" x-text="bgSize + 'px'"></span>
                                        </div>
                                        <input type="hidden" name="auth_bg_size" :value="bgSize">
                                        <div class="relative pt-3 pb-6">
                                            <input type="range" min="10" max="250" step="2" 
                                                x-model="bgSize" 
                                                class="w-full h-2.5 bg-slate-200 rounded-full appearance-none cursor-pointer accent-indigo-600 hover:accent-indigo-500 transition-all shadow-inner">
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Weight Slider -->
                                    <div>
                                        <div class="flex justify-between items-end mb-2">
                                            <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider">Ketebalan Font</label>
                                            <span class="text-[12px] font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg" x-text="bgWeight"></span>
                                        </div>
                                        <input type="hidden" name="auth_bg_weight" :value="bgWeight">
                                        <div class="relative pt-3 pb-6">
                                            <input type="range" min="100" max="900" step="100" 
                                                x-model="bgWeight" 
                                                class="w-full h-2.5 bg-slate-200 rounded-full appearance-none cursor-pointer accent-indigo-600 hover:accent-indigo-500 transition-all shadow-inner">
                                            <div class="absolute w-full flex justify-between text-[11px] font-bold text-slate-400 px-1 mt-2 pointer-events-none">
                                                <span>100</span>
                                                <span>400</span>
                                                <span>700</span>
                                                <span>900</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 border-t border-slate-100 pt-8">
                                    <!-- Text Color Picker -->
                                    <div>
                                        <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Warna Teks Tipografi</label>
                                        <div class="flex items-center space-x-4 bg-slate-50 p-2 rounded-[16px] border border-slate-200/60">
                                            <div class="relative w-12 h-12 rounded-[12px] overflow-hidden shadow-sm shrink-0 border border-slate-200">
                                                <input type="color" name="auth_bg_text_color" x-model="bgTextColor" class="absolute inset-[-10px] w-20 h-20 cursor-pointer">
                                            </div>
                                            <input type="text" x-model="bgTextColor" class="flex-1 bg-transparent border-0 focus:ring-0 px-2 py-2 text-[16px] font-bold text-slate-900 transition-colors uppercase font-mono" placeholder="#0f172a">
                                        </div>
                                    </div>
                                    
                                    <!-- Background Color Picker -->
                                    <div>
                                        <div class="flex justify-between items-end mb-2">
                                            <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider">Warna Latar Belakang</label>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[11px] font-bold text-slate-400">Sesuaikan Otomatis</span>
                                                <button type="button" @click="bgAutoColor = bgAutoColor === 'true' ? 'false' : 'true'" :class="bgAutoColor === 'true' ? 'bg-indigo-600' : 'bg-slate-200'" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                                    <input type="hidden" name="auth_bg_auto_color" :value="bgAutoColor">
                                                    <span aria-hidden="true" :class="bgAutoColor === 'true' ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition-transform duration-300 ease-in-out"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 bg-slate-50 p-2 rounded-[16px] border border-slate-200/60 transition-opacity duration-300" :class="bgAutoColor === 'true' ? 'opacity-50 grayscale' : ''">
                                            <div class="relative w-12 h-12 rounded-[12px] overflow-hidden shadow-sm shrink-0 border border-slate-200">
                                                <!-- If auto color is on, show computed color. If off, show the picker bound to bgColor -->
                                                <template x-if="bgAutoColor === 'true'">
                                                    <div class="absolute inset-0" :style="`background-color: ${computedBgColor}`"></div>
                                                </template>
                                                <template x-if="bgAutoColor !== 'true'">
                                                    <input type="color" name="auth_bg_color" x-model="bgColor" class="absolute inset-[-10px] w-20 h-20 cursor-pointer">
                                                </template>
                                            </div>
                                            <!-- The text input always displays the current effective hex or rgba -->
                                            <input type="text" :value="bgAutoColor === 'true' ? computedBgColor : bgColor" @input="if(bgAutoColor !== 'true') bgColor = $event.target.value;" :readonly="bgAutoColor === 'true'" class="flex-1 bg-transparent border-0 focus:ring-0 px-2 py-2 text-[16px] font-bold text-slate-900 transition-colors font-mono" :class="bgAutoColor === 'true' ? 'text-slate-400' : 'uppercase'">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Settings -->
                            <div x-show="bgType === 'image'" x-transition class="space-y-4 pt-4">
                                <div>
                                    <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Upload Gambar Background</label>
                                    <div class="flex flex-col sm:flex-row items-center gap-4">
                                        <div class="flex flex-col items-center justify-center w-full sm:w-64 aspect-video border-2 border-slate-200 border-dashed rounded-[20px] hover:border-indigo-400 hover:bg-indigo-50/50 transition-colors bg-slate-50 cursor-pointer group relative overflow-hidden" onclick="document.getElementById('auth_bg_image').click()">
                                            <div class="space-y-2 text-center p-4 relative z-10" x-show="!imagePreviewUrl && !'{{ $authBgImage }}'">
                                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm text-indigo-500 mb-2 group-hover:scale-110 transition-transform duration-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                </div>
                                                <span class="text-[13px] font-bold text-slate-700 block">Klik untuk Upload</span>
                                                <span class="text-[11px] text-slate-500 block">JPG, PNG (Max 2MB)</span>
                                            </div>
                                            <!-- Preview thumbnail -->
                                            <div class="absolute inset-0 bg-cover bg-center" x-show="imagePreviewUrl || '{{ $authBgImage }}'" :style="imagePreviewUrl ? `background-image: url('${imagePreviewUrl}')` : `background-image: url('{{ $authBgImage ? asset('storage/' . $authBgImage) : '' }}')`"></div>
                                            <!-- Overlay hover -->
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" x-show="imagePreviewUrl || '{{ $authBgImage }}'">
                                                <span class="text-white text-sm font-bold">Ganti Gambar</span>
                                            </div>
                                            <input id="auth_bg_image" name="auth_bg_image" type="file" @change="previewImage" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                                        </div>
                                    </div>
                                    <input type="hidden" name="old_auth_bg_image" value="{{ $authBgImage }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
EOT;

// Replace entire old Auth Page Background block
// The block spans from <!-- Auth Page Background --> to <!-- Theme Colors -->
$content = preg_replace('/<!-- Auth Page Background -->.*?<!-- Theme Colors -->/s', $newTypoBlock . "\n\n                <!-- Theme Colors -->", $content);

// Ensure Alpine Data matches precisely
$alpineReplacement = <<<'EOT'
            Alpine.data('authBackgroundPreview', () => {
                return {
                    bgType: '{{ $authBgType }}',
                    bgText: '{{ $authBgText }}',
                    bgFont: '{{ $authBg['font'] ?? 'Inter' }}',
                    bgSize: '{{ $authBg['size'] ?? 80 }}',
                    bgWeight: '{{ $authBg['weight'] ?? 900 }}',
                    bgCase: '{{ $authBg['case'] ?? 'normal' }}',
                    bgItalic: '{{ $authBg['italic'] ?? 'false' }}',
                    bgStrikethrough: '{{ $authBg['strikethrough'] ?? 'false' }}',
                    bgTextColor: '{{ $authBg['text_color'] ?? '#0f172a' }}',
                    bgColor: '{{ $authBg['bg_color'] ?? '#f8fafc' }}',
                    bgAutoColor: '{{ $authBg['auto_color'] ?? 'true' }}',
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
                    },

                    get typographyClasses() {
                        let classes = [];
                        
                        // Case
                        if(this.bgCase === 'uppercase') classes.push('uppercase');
                        else if(this.bgCase === 'lowercase') classes.push('lowercase');
                        
                        // Italic & Strike
                        if(this.bgItalic === 'true') classes.push('italic');
                        if(this.bgStrikethrough === 'true') classes.push('line-through');
                        
                        return classes.join(' ');
                    },
                    
                    get typographyStyles() {
                        return `font-family: '${this.bgFont}'; font-size: ${this.bgSize}px; font-weight: ${this.bgWeight}; color: ${this.bgTextColor};`;
                    }
                }
            })
EOT;

$content = preg_replace('/Alpine\.data\(\'authBackgroundPreview\', \(\) => \(\{.*?\}\)\)/s', $alpineReplacement, $content);

file_put_contents($file, $content);
echo "Refactoring typography logic v4 completed.\n";

