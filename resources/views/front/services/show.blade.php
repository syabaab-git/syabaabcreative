<x-front-layout>
    <div class="min-h-screen bg-[#f8fafc] pb-12 pt-4 sm:pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            


            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)" class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start transform transition-all duration-700 ease-out opacity-0 translate-y-8" :class="show ? '!opacity-100 !translate-y-0' : ''">
                
                <!-- KIRI: SERVICE DETAILS -->
                <div class="col-span-1 lg:col-span-4 lg:sticky lg:top-[120px] flex flex-col gap-6">
                    <div class="bg-white rounded-[24px] border border-slate-200 overflow-hidden shadow-sm">
                        <div class="w-full h-48 bg-slate-100 relative">
                            @if($service->thumbnail)
                                <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                    <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white/90 text-indigo-700 backdrop-blur-md shadow-sm uppercase tracking-wider">
                                    {{ $service->category->name }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h1 class="text-lg sm:text-xl font-black text-slate-800 mb-4 leading-tight">{{ $service->title }}</h1>
                            
                            <div class="flex flex-col gap-2.5 mb-5">
                                <div class="bg-blue-50/50 px-3 py-2 rounded-xl border border-blue-100/50 flex justify-between items-center">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-500">Mulai Dari</span>
                                    <span class="font-black text-lg text-blue-700">Rp{{ number_format($service->base_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center text-[12px] font-semibold text-slate-600 bg-slate-50 px-3 py-2.5 rounded-xl border border-slate-200/80">
                                    <svg class="w-4 h-4 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Estimasi {{ $service->estimated_days }} Hari
                                </div>
                            </div>

                            @if(is_array($service->packages) && count($service->packages) > 0)
                                <div class="mb-5 pt-4 border-t border-slate-100">
                                    <h4 class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-3">Pilihan Paket:</h4>
                                    <div class="space-y-3">
                                        @foreach($service->packages as $key => $value)
                                            @php
                                                $name = is_array($value) ? ($value['name'] ?? '') : $key;
                                                $price = is_array($value) ? ($value['price'] ?? 0) : $value;
                                                $estimated = is_array($value) ? ($value['estimated_days'] ?? '') : '';
                                                $desc = is_array($value) ? ($value['description'] ?? '') : '';
                                            @endphp
                                            <div class="flex flex-col bg-white border border-slate-200 px-4 py-3 rounded-xl shadow-sm hover:border-indigo-300 transition-colors group">
                                                <div class="flex justify-between items-start mb-1">
                                                    <span class="text-[14px] font-bold text-slate-800 group-hover:text-indigo-700 transition-colors">{{ $name }}</span>
                                                    <div class="text-right">
                                                        <span class="block text-[9px] font-semibold text-slate-400 uppercase tracking-wider leading-none mb-0.5">Mulai Dari</span>
                                                        <span class="text-[14px] font-black text-indigo-600 leading-none">Rp{{ number_format((float)$price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                                @if(!empty($estimated))
                                                    <div class="text-[11px] font-semibold text-slate-500 mb-2 flex items-center bg-slate-50 self-start px-2 py-1 rounded-md border border-slate-100 mt-1">
                                                        <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Estimasi: {{ $estimated }}
                                                    </div>
                                                @endif
                                                @if(!empty($desc))
                                                    <div class="text-[12px] text-slate-600 leading-relaxed border-t border-slate-100 pt-2 mt-1 whitespace-pre-wrap">{!! nl2br(e($desc)) !!}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="prose prose-slate text-[13px] leading-relaxed text-slate-600 max-w-none quill-content">
                                {!! $service->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TENGAH: ORDER FORM -->
                <div class="col-span-1 lg:col-span-5">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                        <div class="mb-6 pb-6 border-b border-slate-100">
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Formulir Pemesanan</h2>
                            <p class="text-slate-500 text-sm mt-1">Lengkapi data di bawah ini untuk memulai proyek Anda.</p>
                        </div>

                        @php
                            $packages = is_array($service->packages) ? $service->packages : [];
                            $hasPackages = !empty($packages);
                            
                            $parsedPackages = [];
                            $priceMap = [];
                            foreach($packages as $key => $val) {
                                $n = is_array($val) ? ($val['name'] ?? '') : $key;
                                $p = is_array($val) ? ($val['price'] ?? 0) : $val;
                                if (!empty($n)) {
                                    $parsedPackages[] = [ 'name' => $n, 'price' => $p ];
                                    $priceMap[$n] = $p;
                                }
                            }
                        @endphp

                        <form id="order-form" action="{{ route('services.order', $service) }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                              x-data="{
                                  selectedPackage: '{{ old('package_name', '') }}',
                                  packagePrices: {{ json_encode($priceMap) }},
                                  basePrice: {{ $service->base_price }},
                                  offerPriceRaw: '{{ old('offer_price', '') }}',
                                  offerPriceFormatted: '',
                                  minPrice: {{ $service->base_price }},
                                  updateMinPrice() {
                                      if (this.selectedPackage && this.packagePrices[this.selectedPackage]) {
                                          this.minPrice = parseInt(this.packagePrices[this.selectedPackage]);
                                      } else {
                                          this.minPrice = this.basePrice;
                                      }
                                  },
                                  formatCurrency() {
                                      let val = this.offerPriceRaw.toString().replace(/[^0-9]/g, '');
                                      if (val) {
                                          this.offerPriceFormatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                                      } else {
                                          this.offerPriceFormatted = '';
                                      }
                                  },
                                  init() {
                                      this.updateMinPrice();
                                      this.formatCurrency();
                                      $watch('selectedPackage', value => this.updateMinPrice());
                                  }
                              }">
                            @csrf
                            
                            <!-- Nama Lengkap -->
                            <div>
                                <label for="customer_name" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" required value="{{ old('customer_name', auth()->user()->name ?? '') }}" 
                                       class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-bold text-slate-900 transition-colors placeholder:text-slate-300 placeholder:font-normal" placeholder="Masukkan nama Anda">
                                @error('customer_name') <span class="text-red-500 text-[13px] mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Alamat Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" required value="{{ old('email', auth()->user()->email ?? '') }}" 
                                           class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-bold text-slate-900 transition-colors placeholder:text-slate-300 placeholder:font-normal" placeholder="email@contoh.com">
                                    @error('email') <span class="text-red-500 text-[13px] mt-1">{{ $message }}</span> @enderror
                                </div>

                                <!-- WhatsApp -->
                                <div>
                                    <label for="whatsapp" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                                    <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}" 
                                           class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[15px] font-bold text-slate-900 transition-colors placeholder:text-slate-300 placeholder:font-normal" placeholder="081234567890">
                                    @error('whatsapp') <span class="text-red-500 text-[13px] mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Pilihan Paket -->
                            @if($hasPackages)
                            <div>
                                <label for="package_name" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilihan Paket <span class="text-red-500">*</span></label>
                                <select name="package_name" id="package_name" x-model="selectedPackage" required
                                        class="w-full bg-slate-50 border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-4 py-3 rounded-t-xl text-[15px] font-bold text-slate-900 transition-colors">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach($parsedPackages as $pkg)
                                        <option value="{{ $pkg['name'] }}">{{ $pkg['name'] }} - Rp {{ number_format((float)$pkg['price'], 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                                @error('package_name') <span class="text-red-500 text-[13px] mt-1">{{ $message }}</span> @enderror
                            </div>
                            @endif

                            <!-- Ajukan Tawaran Harga -->
                            <div>
                                <label for="offer_price_formatted" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">
                                    Ajukan Tawaran Harga <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
                                </label>
                                <input type="text" id="offer_price_formatted" name="offer_price_formatted" 
                                       x-model="offerPriceFormatted" 
                                       @input="offerPriceRaw = $event.target.value.replace(/[^0-9]/g, ''); formatCurrency()"
                                       class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-bold text-indigo-700 transition-colors placeholder:text-slate-300 placeholder:font-normal" 
                                       :placeholder="'Min. Rp ' + new Intl.NumberFormat('id-ID').format(minPrice)">
                                <input type="hidden" name="offer_price" x-model="offerPriceRaw">
                                <p class="text-[11px] text-slate-400 mt-1" x-show="minPrice > 0">Minimal harga tawaran: <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(minPrice)" class="font-bold text-slate-500"></span></p>
                                @error('offer_price') <span class="text-red-500 text-[13px] mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Detail Kebutuhan (Quill Editor) -->
                            <div>
                                <label for="requirement" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Detail Kebutuhan Proyek <span class="text-red-500">*</span></label>
                                <input type="hidden" name="requirement" id="requirement-hidden" value="{{ old('requirement') }}">
                                <div class="rounded-[20px] border border-slate-200 overflow-hidden focus-within:border-indigo-400 focus-within:ring-1 focus-within:ring-indigo-400/20 transition-all bg-slate-50">
                                    <div id="quill-toolbar" class="border-0 border-b border-slate-100 bg-slate-50/80 px-4 py-1.5">
                                        <span class="ql-formats">
                                            <button class="ql-bold"></button>
                                            <button class="ql-italic"></button>
                                            <button class="ql-underline"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-list" value="ordered"></button>
                                            <button class="ql-list" value="bullet"></button>
                                        </span>
                                    </div>
                                    <div id="quill-editor" class="bg-white" style="min-height: 200px; font-family: Inter, sans-serif; font-size: 15px;">{!! old('requirement') !!}</div>
                                </div>
                                @error('requirement') <span class="text-red-500 text-[13px] mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Lampiran Dokumen -->
                            <div>
                                <label for="file" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Lampiran Dokumen <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer relative" onclick="document.getElementById('file').click()">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="file" class="relative cursor-pointer bg-transparent rounded-md font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload file</span>
                                                <input id="file" name="file" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-slate-500">PDF, DOC, ZIP max 5MB</p>
                                    </div>
                                </div>
                                <div id="file-name" class="mt-2 text-sm text-slate-600 font-medium hidden"></div>
                                @error('file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <script>
                                document.getElementById('file').addEventListener('change', function(e) {
                                    var fileName = e.target.files[0] ? e.target.files[0].name : '';
                                    var fileNameDisplay = document.getElementById('file-name');
                                    if (fileName) {
                                        fileNameDisplay.textContent = 'File terpilih: ' + fileName;
                                        fileNameDisplay.classList.remove('hidden');
                                    } else {
                                        fileNameDisplay.classList.add('hidden');
                                    }
                                });
                            </script>

                            <div class="pt-4 mt-6 border-t border-slate-100">
                                @guest
                                    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm mb-4">
                                        Anda harus <a href="{{ route('login') }}" class="font-bold underline">Login</a> atau <a href="{{ route('register') }}" class="font-bold underline">Mendaftar</a> untuk memesan layanan ini.
                                    </div>
                                    <button type="button" disabled class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-slate-400 cursor-not-allowed">
                                        Kirim Pesanan
                                    </button>
                                @else
                                    <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                                        Kirim Pesanan
                                    </button>
                                @endguest
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KANAN: KONSULTASI / BANTUAN -->
                <div class="col-span-1 lg:col-span-3 lg:sticky lg:top-[120px]">
                    <div class="bg-gradient-to-b from-white to-slate-50 rounded-[24px] p-6 border border-slate-200/80 shadow-sm flex flex-col items-center text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-100/50 rounded-full mix-blend-multiply filter blur-3xl translate-x-1/2 -translate-y-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-100/50 rounded-full mix-blend-multiply filter blur-3xl -translate-x-1/2 translate-y-1/2"></div>
                        
                        <div class="relative w-12 h-12 bg-white/80 backdrop-blur shadow-sm text-indigo-600 rounded-[16px] flex items-center justify-center mb-4 border border-indigo-50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="relative text-slate-800 font-black text-[15px] tracking-tight mb-2">Masih Bingung?</h3>
                        <p class="relative text-slate-500 text-[12px] leading-relaxed mb-5">Konsultasikan kebutuhan proyek Anda bersama tim ahli kami.</p>
                        
                        <div class="relative w-full flex gap-2 mt-auto">
                            @php $waNumber = preg_replace('/[^0-9]/', '', \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890'); @endphp
                            <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="flex-1 flex justify-center items-center py-2.5 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-[14px] transition-all shadow-sm hover:shadow-[#25D366]/30 hover:-translate-y-0.5" title="WhatsApp">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            </a>
                            @php $igUrl = \App\Models\Setting::where('key', 'social_instagram')->value('value') ?? '#'; @endphp
                            <a href="{{ $igUrl }}" target="_blank" class="flex-1 flex justify-center items-center py-2.5 bg-gradient-to-tr from-[#FD1D1D] via-[#E1306C] to-[#C13584] hover:opacity-90 text-white rounded-[14px] transition-all shadow-sm hover:shadow-pink-500/30 hover:-translate-y-0.5" title="Instagram">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quill Editor Assets -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        #quill-editor { border: none !important; }
        .ql-toolbar.ql-snow { border: none !important; font-family: inherit; }
        .ql-container.ql-snow { font-family: inherit; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quill = new Quill('#quill-editor', {
                modules: { toolbar: '#quill-toolbar' },
                theme: 'snow',
                placeholder: 'Ceritakan secara detail kebutuhan dan visi proyek Anda...'
            });
            
            const form = document.getElementById('order-form');
            if(form) {
                form.addEventListener('submit', function(e) {
                    document.getElementById('requirement-hidden').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
                });
            }
        });
    </script>
</x-front-layout>
