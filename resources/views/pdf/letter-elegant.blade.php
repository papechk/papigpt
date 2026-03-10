{{-- Design Élégant — Double lignes fines, typographie raffinée, accents subtils --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lettre #{{ $document->id }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body { margin: 0; padding: 28mm 22mm 25mm 22mm; font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #2c2c2c; line-height: 1.7; }

        /* Lignes décoratives haut */
        .top-line-thick { position: fixed; top: 0; left: 0; width: 210mm; height: 3mm; background-color: #b08657; }
        .top-line-thin { position: fixed; top: 4mm; left: 0; width: 210mm; height: 0.5mm; background-color: #b08657; }

        /* Ligne décorative bas */
        .bottom-line-thick { position: fixed; bottom: 0; left: 0; width: 210mm; height: 2mm; background-color: #b08657; }

        .header { text-align: center; padding-bottom: 14px; margin-bottom: 16px; }
        .header img { height: 40px; display: block; margin: 0 auto; }
        .header .name { font-size: 11px; font-weight: bold; letter-spacing: 4px; color: #1a1a1a; margin-top: 5px; text-transform: uppercase; }
        .header .tagline { font-size: 7px; color: #b08657; letter-spacing: 2px; margin-top: 2px; font-style: italic; }
        .header .sep { width: 60px; height: 1px; background-color: #b08657; margin: 8px auto 0 auto; }

        .footer { position: fixed; bottom: 4mm; left: 22mm; width: 166mm; text-align: center; font-size: 6.5px; color: #999; line-height: 1.5; }

        .date { text-align: right; font-size: 10px; color: #666; margin-bottom: 18px; font-style: italic; }

        .recipient { margin-bottom: 8px; font-size: 10px; line-height: 1.8; }
        .recipient .rname { font-weight: bold; font-size: 11px; color: #1a1a1a; }
        .recipient .rdetail { color: #555; }

        .objet { margin: 12px 0 16px 0; font-size: 10px; padding: 8px 12px; background-color: #faf6f0; border: 1px solid #e8dcc8; }
        .objet strong { color: #b08657; }

        .greeting { margin-bottom: 10px; font-size: 10px; color: #333; }
        .content { text-align: justify; font-size: 10px; line-height: 1.85; }
        .content p { margin-bottom: 5px; }
        .closing { margin-top: 20px; font-size: 10px; color: #333; font-style: italic; }
        .signature { margin-top: 35px; text-align: center; }
        .signature .sign-line { width: 120px; border-bottom: 1px solid #b08657; margin: 0 auto 6px auto; }
        .signature .sign-name { font-size: 11px; font-weight: bold; color: #1a1a1a; }
        .signature .sign-role { font-size: 8px; color: #888; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="top-line-thick"></div>
    <div class="top-line-thin"></div>
    <div class="bottom-line-thick"></div>

    <div class="header">
        <img src="{{ public_path('images/logo_sst.jpg') }}" alt="SST">
        <div class="name">SINIING SOHOMA TILO SARL</div>
        <div class="tagline">Production Audiovisuelle &bull; Dakar, S&eacute;n&eacute;gal</div>
        <div class="sep"></div>
    </div>

    <div class="footer">
        SINIING SOHOMA TILO SARL (SST) &bull; RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2<br>
        Villa 21, Unit&eacute; 23 Parcelles Assainies Dakar &ndash; S&eacute;n&eacute;gal &bull; +221 77 549 90 38
    </div>

    <div class="date">Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>

    <div class="recipient">
        <div class="rname">{{ $document->civilite ? $document->civilite . ' ' : '' }}{{ $document->client_name }}</div>
        @if($document->titre_destinataire)<div class="rdetail">{{ $document->titre_destinataire }}</div>@endif
        @if($document->client_address)<div class="rdetail">{{ $document->client_address }}</div>@endif
        @if($document->telephone_destinataire)<div class="rdetail">{{ $document->telephone_destinataire }}</div>@endif
    </div>

    @if($document->objet)
    <div class="objet"><strong>Objet :</strong> {{ $document->objet }}</div>
    @endif

    <div class="greeting">{{ $document->civilite ? $document->civilite . ' ' . $document->client_name : 'Madame, Monsieur' }},</div>

    <div class="content">
        @foreach(explode("\n", $document->content) as $line)
            @if(trim($line) !== '')<p>{{ $line }}</p>@else<br>@endif
        @endforeach
    </div>

    <div class="signature">
        <div class="sign-line"></div>
        <div class="sign-name">Sidi Hairou Camara</div>
        <div class="sign-role">Producteur / R&eacute;alisateur</div>
    </div>
</body>
</html>
