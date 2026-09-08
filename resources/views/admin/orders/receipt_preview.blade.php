<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk {{ $order->order_number }}</title>
    @php
        $receiptPersonal = json_decode(\App\Models\Setting::where('key','receipt_personalization')->value('value') ?? '{}', true);
        $elements     = $receiptPersonal['elements']      ?? [];
        $canvasWidth  = $receiptPersonal['canvas_width']  ?? 380;
        $canvasHeight = $receiptPersonal['canvas_height'] ?? 560;
        $canvasUnit   = $receiptPersonal['canvas_unit']   ?? 'px';
        $canvasBg     = $receiptPersonal['canvas_bg']     ?? '#ffffff';
        $useDefaultBg = !empty($receiptPersonal['canvas_use_default_bg']);
        $defaultBgOpacity = $receiptPersonal['canvas_default_bg_opacity'] ?? 0.3;
        $logoData     = $receiptPersonal['logo_data']     ?? null;

        // Convert canvas width to pixels for element width calculation if not in px
        $canvasWidthPx = $canvasWidth;
        if ($canvasUnit === 'in') {
            $canvasWidthPx = $canvasWidth * 96;
        } elseif ($canvasUnit === 'cm') {
            $canvasWidthPx = $canvasWidth * (96 / 2.54);
        } elseif ($canvasUnit === 'mm') {
            $canvasWidthPx = $canvasWidth * (96 / 25.4);
        }

        $authBg = json_decode(\App\Models\Setting::where('key', 'auth_background')->value('value') ?? '{}', true);
        $authBgType = $authBg['type'] ?? 'color';
        $authBgText = $authBg['text'] ?? 'Syabaab Creative';
        $authFont = $authBg['font'] ?? 'Inter';
        $authSize = max(18, ((int) ($authBg['size'] ?? 80)) * 0.38);
        $authWeight = $authBg['weight'] ?? 900;
        $authTextColor = $authBg['text_color'] ?? '#0f172a';
        $caseMap = ['uppercase' => 'uppercase', 'lowercase' => 'lowercase'];
        $authTransform = $caseMap[$authBg['case'] ?? 'normal'] ?? 'none';
        $authItalic = ($authBg['italic'] ?? 'false') === 'true' ? 'italic' : 'normal';
        $authStrike = ($authBg['strikethrough'] ?? 'false') === 'true' ? 'line-through' : 'none';

        // Dynamic variable replacements
        $vars = [
            '{order_number}'  => $order->order_number ?? '-',
            '{customer_name}' => $order->customer_name ?? '-',
            '{total_amount}'  => 'Rp ' . number_format($order->amount ?? 0, 0, ',', '.'),
            '{date}'          => optional($order->created_at)->format('d M Y H:i') ?? '-',
            '{service_name}'  => optional($order->service)->title ?? 'Layanan',
            '{phone}'         => $order->customer_phone ?? '-',
        ];
        
        // Check if using new canvas editor or legacy format
        $hasCanvasElements = !empty($elements);
    @endphp
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .page-wrap {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 20px;
            min-height: 100vh;
        }
        .receipt {
            position: relative;
            width: {{ $canvasWidth }}{{ $canvasUnit }};
            min-height: {{ $canvasHeight }}{{ $canvasUnit }};
            background-color: {{ $canvasBg }};
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        }

        @if($useDefaultBg)
        .receipt-auth-typo {
            padding: 16px 24px;
            white-space: nowrap;
            line-height: 1;
            color: {{ $authTextColor }};
            font-family: "{{ $authFont }}", Arial, sans-serif;
            font-size: {{ $authSize }}px;
            font-weight: {{ $authWeight }};
            text-transform: {{ $authTransform }};
            font-style: {{ $authItalic }};
            text-decoration: {{ $authStrike }};
        }
        @endif

        @if(!$hasCanvasElements)
        /* Legacy fallback styles */
        .container { width: 100%; padding: 20px; }
        .header { display:flex; justify-content:space-between; align-items:center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 16px; margin-bottom: 16px; }
        .logo-section { font-weight:700; font-size:18px; color:#0f172a; }
        .meta { text-align:right; font-size:11px; color:#6b7280 }
        .section { margin-top:16px; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:7px 5px; border-bottom:1px solid #e5e7eb; font-size:12px; }
        th { font-weight: 700; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; }
        .total-row td { font-weight:800; font-size:16px; color: {{ $receiptPersonal['theme_color'] ?? '#4f46e5' }}; border-top: 2px solid #e5e7eb; border-bottom: none; }
        .small { font-size:11px; color:#6b7280 }
        @endif
    </style>
</head>
<body>
<div class="page-wrap">
    <div class="receipt">
        @if($useDefaultBg)
        <div style="position:absolute; inset:0; overflow:hidden; border-radius:inherit; pointer-events:none; z-index:0;">
            @if($authBgType === 'color' && $authBgText)
                <!-- Auth Typography Background -->
                <div style="position:absolute; top:-50%; left:-50%; right:-50%; bottom:-50%; display:flex; flex-wrap:wrap; justify-content:center; align-content:center; transform:rotate(-12deg); gap:0; opacity:{{ $defaultBgOpacity }};">
                    @for($i=0; $i<80; $i++)
                        <span class="receipt-auth-typo">{{ $authBgText }}</span>
                    @endfor
                </div>
            @endif
        </div>
        @endif

        @if($hasCanvasElements)
            {{-- Canvas Editor Mode: Render absolute-positioned elements --}}
            @foreach($elements as $el)
                @php
                    $type  = $el['type']   ?? 'text';
                    $x     = $el['x']      ?? 0;
                    $y     = $el['y']      ?? 0;
                    $w     = $el['width']  ?? ($canvasWidthPx - 40);
                    $color = $el['color']  ?? '#111827';
                    $align = $el['align']  ?? 'left';

                    $style = "position:absolute; left:{$x}px; top:{$y}px; width:{$w}px;";
                @endphp

                @if($type === 'text')
                    @php
                        $font    = $el['fontFamily'] ?? 'Arial, sans-serif';
                        $size    = $el['fontSize']   ?? 14;
                        $bold    = ($el['bold']      ?? false) ? 'font-weight:bold;' : '';
                        $italic  = ($el['italic']    ?? false) ? 'font-style:italic;' : '';
                        $uline   = ($el['underline'] ?? false) ? 'text-decoration:underline;' : '';
                        $rawText = $el['text'] ?? '';
                        $text    = str_replace(array_keys($vars), array_values($vars), $rawText);
                    @endphp
                    <div style="{{ $style }} font-family:{{ $font }}; font-size:{{ $size }}px; color:{{ $color }}; text-align:{{ $align }}; {{ $bold }}{{ $italic }}{{ $uline }} line-height:1.4; word-break:break-word; white-space:pre-wrap;">{{ $text }}</div>

                @elseif($type === 'divider')
                    @php $dashed = ($el['dashed'] ?? true) ? 'dashed' : 'solid'; @endphp
                    <div style="{{ $style }} border-top:1px {{ $dashed }} {{ $color }};"></div>

                @elseif($type === 'logo')
                    @php
                        $maxH    = $el['fontSize'] ?? 50;
                        $margin  = $align === 'center' ? '0 auto' : ($align === 'right' ? '0 0 0 auto' : '0');
                    @endphp
                    @if($logoData)
                        <div style="{{ $style }}">
                            <img src="{{ $logoData }}" style="max-height:{{ $maxH }}px; max-width:{{ $w }}px; display:block; margin:{{ $margin }};" alt="Logo">
                        </div>
                    @endif
                @endif
            @endforeach

        @else
            {{-- Legacy table-based fallback --}}
            <div class="container">
                <div class="header">
                    <div class="logo-section">
                        @if($logoData)
                            <img src="{{ $logoData }}" style="max-height:40px; margin-bottom:8px; display:block;" alt="Logo">
                        @endif
                        {{ $receiptPersonal['company_name'] ?? config('app.name') }}
                        <div class="small">{{ $receiptPersonal['company_address'] ?? '' }}</div>
                    </div>
                    <div class="meta">
                        <div>Struk: {{ $order->order_number }}</div>
                        <div>{{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>

                <div class="section">
                    <strong>Pemesan</strong>
                    <div class="small">{{ $order->customer_name }} — {{ $order->customer_email }}{{ $order->customer_phone ? ' / ' . $order->customer_phone : '' }}</div>
                </div>

                <div class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th style="text-align:right; width:120px">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->service->title ?? 'Layanan' }}{{ $order->package_name ? ' - ' . $order->package_name : '' }}</td>
                                <td style="text-align:right">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td>Total</td>
                                <td style="text-align:right">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="section small" style="margin-top: 20px; padding-top: 12px; border-top: 1px dashed #e2e8f0; text-align: center;">
                    {{ $receiptPersonal['footer_text'] ?? 'Terima kasih atas pesanan Anda.' }}
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
