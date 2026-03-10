@php
    $design = $document->design ?? 'classique';
    $colors = [
        'simple'    => ['accent' => 'transparent', 'accent_text' => '#333', 'bg_light' => '#fafafa', 'border_light' => '#e5e5e5', 'card_bg' => '#fafafa', 'card_border' => '#e0e0e0'],
        'classique' => ['accent' => '#C8A415', 'accent_text' => '#C8A415', 'bg_light' => '#fdfbf3', 'border_light' => '#e8dfa0', 'card_bg' => '#fdfbf3', 'card_border' => '#e8dfa0'],
        'moderne'   => ['accent' => '#3f3861', 'accent_text' => '#3f3861', 'bg_light' => '#f5f4f9', 'border_light' => '#d0cde0', 'card_bg' => '#f5f4f9', 'card_border' => '#d0cde0'],
        'elegant'   => ['accent' => '#b08657', 'accent_text' => '#b08657', 'bg_light' => '#faf6f0', 'border_light' => '#e0d0b8', 'card_bg' => '#faf6f0', 'card_border' => '#e0d0b8'],
        'corporate' => ['accent' => '#1a2744', 'accent_text' => '#1a2744', 'bg_light' => '#f0f3f8', 'border_light' => '#c8d0e0', 'card_bg' => '#f0f3f8', 'card_border' => '#c8d0e0'],
    ];
    $c = $colors[$design] ?? $colors['classique'];
    $isSimple = $design === 'simple';
@endphp
<style>
    @page {
        size: A4;
        margin: 0;
    }
    body {
        margin: 0;
        padding: 40mm 18mm 24mm 18mm;
        font-family: DejaVu Sans, sans-serif;
        font-size: 10px;
        color: #2c2c2c;
        line-height: 1.7;
    }

    /* ═══ HEADER ═══ */
    .sst-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 210mm;
        height: 34mm;
        text-align: center;
        padding: 6mm 18mm 0 18mm;
        @if(!$isSimple) border-bottom: 2.5px solid {{ $c['accent'] }}; @endif
        box-sizing: border-box;
    }
    .sst-header img {
        display: block;
        margin: 0 auto;
        height: 42px;
        width: auto;
    }
    .sst-header .company-name {
        font-size: 9px;
        font-weight: bold;
        letter-spacing: 3px;
        color: #1a1a1a;
        margin-top: 3px;
        text-transform: uppercase;
    }
    .sst-header .company-tagline {
        font-size: 7px;
        color: #999;
        letter-spacing: 1.5px;
        margin-top: 1px;
    }

    /* ═══ FOOTER ═══ */
    .sst-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 210mm;
        height: 18mm;
        text-align: center;
        font-size: 7px;
        color: #888;
        @if(!$isSimple) border-top: 1.5px solid {{ $c['accent'] }}; @endif
        padding: 5mm 18mm 0 18mm;
        box-sizing: border-box;
        line-height: 1.6;
    }

    /* ═══ TITLE ═══ */
    .doc-title {
        text-align: center;
        margin: 10px 0 22px 0;
    }
    .doc-title h1 {
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #1a1a1a;
        padding-bottom: 6px;
        @if(!$isSimple) border-bottom: 2px solid {{ $c['accent'] }}; @endif
        display: inline-block;
    }
    .doc-title .doc-number {
        display: block;
        margin-top: 6px;
        font-size: 8px;
        color: #aaa;
        letter-spacing: 1px;
    }

    /* ═══ INFO ═══ */
    .info-grid { width: 100%; margin-bottom: 18px; }
    .info-grid td { vertical-align: top; padding: 0; }
    .info-block { margin-bottom: 8px; }
    .info-label {
        font-size: 7px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: {{ $c['accent_text'] }};
        font-weight: bold;
        margin-bottom: 2px;
    }
    .info-value { font-size: 10px; color: #222; }

    /* ═══ INFO CARD ═══ */
    .info-card {
        background-color: {{ $c['card_bg'] }};
        border: 1px solid {{ $c['card_border'] }};
        @if(!$isSimple) border-left: 3px solid {{ $c['accent'] }}; @else border-left: 3px solid #ccc; @endif
        padding: 10px 14px;
        margin-bottom: 15px;
    }

    /* ═══ TABLE ═══ */
    table.items { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    table.items th {
        background-color: {{ $isSimple ? '#555' : $c['accent'] }};
        color: #fff;
        padding: 8px 10px;
        font-size: 7.5px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        text-align: left;
    }
    table.items th:first-child {
        border-radius: 3px 0 0 0;
    }
    table.items th:last-child {
        border-radius: 0 3px 0 0;
    }
    table.items th.right { text-align: right; }
    table.items th.center { text-align: center; }
    table.items td {
        padding: 9px 10px;
        border-bottom: 1px solid #eee;
        font-size: 10px;
    }
    table.items td.right { text-align: right; }
    table.items td.center { text-align: center; }
    table.items tr:nth-child(even) td { background-color: #fafaf5; }
    table.items tr:last-child td { border-bottom: 2px solid {{ $isSimple ? '#ccc' : $c['accent'] }}; }

    /* ═══ TOTAL ═══ */
    .total-box {
        text-align: right;
        margin-top: 8px;
        padding: 12px 16px;
        background-color: {{ $c['bg_light'] }};
        border: 1.5px solid {{ $isSimple ? '#ccc' : $c['accent'] }};
        border-radius: 4px;
    }
    .total-box .label {
        font-size: 8px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #888;
    }
    .total-box .amount {
        font-size: 17px;
        font-weight: bold;
        color: #1a1a1a;
        letter-spacing: 0.5px;
    }

    /* ═══ PAYMENT ═══ */
    .payment-info {
        margin-top: 18px;
        padding: 10px 14px;
        border: 1px dashed {{ $isSimple ? '#ccc' : $c['accent'] }};
        border-radius: 4px;
        font-size: 9px;
        color: #666;
        background-color: #fefefe;
    }

    /* ═══ SIGNATURE ═══ */
    .signature {
        margin-top: 45px;
        text-align: right;
    }
    .signature .sign-label {
        font-size: 7px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: {{ $c['accent_text'] }};
        font-weight: bold;
    }
    .signature .sign-line {
        margin-top: 30px;
        margin-bottom: 6px;
        margin-left: auto;
        width: 150px;
        border-bottom: 1px solid #ccc;
    }
    .signature .sign-name {
        font-size: 11px;
        font-weight: bold;
        color: #1a1a1a;
    }
    .signature .sign-role {
        font-size: 8px;
        color: #888;
        margin-top: 2px;
    }

    /* ═══ DUAL SIGNATURE ═══ */
    .signatures-grid { width: 100%; margin-top: 45px; }
    .signatures-grid td {
        width: 50%;
        text-align: center;
        vertical-align: top;
        padding: 0 15px;
    }
    .signatures-grid .sign-label {
        font-size: 7px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: {{ $c['accent_text'] }};
        font-weight: bold;
        border-bottom: 1px solid {{ $c['border_light'] }};
        padding-bottom: 5px;
    }
    .signatures-grid .sign-line {
        margin: 35px auto 6px auto;
        width: 120px;
        border-bottom: 1px solid #ccc;
    }
    .signatures-grid .sign-name {
        font-size: 10px;
        font-weight: bold;
        color: #1a1a1a;
    }
    .signatures-grid .sign-role {
        font-size: 8px;
        color: #888;
        margin-top: 2px;
    }

    /* ═══ CONTENT ═══ */
    .content {
        text-align: justify;
        font-size: 10px;
        line-height: 1.8;
        margin-bottom: 15px;
    }
    .content p { margin-bottom: 6px; }

    /* ═══ PAGE DE GARDE ═══ */
    .page-garde {
        text-align: center;
        padding-top: 60px;
    }
    .page-garde img { height: 110px; }
    .page-garde .film-title {
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 3px;
        margin: 50px 30px 25px 30px;
        color: #1a1a1a;
        padding: 18px 10px;
        @if(!$isSimple) border-top: 3px solid {{ $c['accent'] }}; border-bottom: 3px solid {{ $c['accent'] }}; @else border-top: 2px solid #ccc; border-bottom: 2px solid #ccc; @endif
        text-transform: uppercase;
        line-height: 1.4;
    }
    .page-garde .subtitle {
        font-size: 13px;
        color: #555;
        margin-bottom: 15px;
    }
    .page-garde .production {
        font-size: 11px;
        margin-top: 40px;
        color: #444;
        letter-spacing: 1.5px;
    }

    /* ═══ SECTION HEADING ═══ */
    .section-heading {
        font-size: 9px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        color: {{ $c['accent_text'] }};
        border-bottom: 1.5px solid {{ $c['border_light'] }};
        padding-bottom: 5px;
        margin: 22px 0 12px 0;
    }

    /* ═══ FORMULE POLITESSE ═══ */
    .formule {
        margin-top: 25px;
        font-style: italic;
        font-size: 10px;
        color: #555;
        text-align: justify;
    }

    /* ═══ LIEU DATE ═══ */
    .lieu-date {
        margin-top: 20px;
        font-size: 10px;
        color: #555;
        padding-top: 8px;
        border-top: 1px solid #eee;
    }

    /* ═══ PARTIES ═══ */
    .parties-grid { width: 100%; margin-bottom: 18px; border-collapse: collapse; }
    .parties-grid td {
        width: 50%;
        vertical-align: top;
        padding: 10px 14px;
        background-color: #fdfbf3;
        border: 1px solid #e8dfa0;
    }
    .parties-grid td:first-child { border-right: none; }
</style>
