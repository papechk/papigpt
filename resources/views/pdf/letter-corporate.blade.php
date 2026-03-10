{{-- Design Corporate — Bannière colorée en haut, header blanc sur fond, pro --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lettre #{{ $document->id }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body { margin: 0; padding: 38mm 20mm 22mm 20mm; font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #2c2c2c; line-height: 1.7; }

        /* Bannière haut */
        .banner { position: fixed; top: 0; left: 0; width: 210mm; height: 34mm; background-color: #1a2744; }
        .banner-logo { position: fixed; top: 2mm; left: 0; width: 210mm; text-align: center; }
        .banner-logo img { height: 32px; }
        .banner-name { position: fixed; top: 12mm; left: 0; width: 210mm; text-align: center; font-size: 10px; font-weight: bold; letter-spacing: 4px; color: #ffffff; text-transform: uppercase; }
        .banner-tagline { position: fixed; top: 16mm; left: 0; width: 210mm; text-align: center; font-size: 6.5px; color: #8899bb; letter-spacing: 2px; }

        /* Accent sous le banner */
        .accent-line { position: fixed; top: 34mm; left: 0; width: 210mm; height: 1.5mm; background-color: #C8A415; }

        .footer { position: fixed; bottom: 4mm; left: 20mm; width: 170mm; text-align: center; font-size: 6.5px; color: #888; line-height: 1.5; }
        .footer-line { position: fixed; bottom: 0; left: 0; width: 210mm; height: 1.5mm; background-color: #1a2744; }

        .date { text-align: right; font-size: 10px; color: #555; margin-bottom: 20px; }

        .two-col { width: 100%; margin-bottom: 10px; }
        .two-col td { vertical-align: top; padding: 0; }
        .two-col .left { width: 55%; }
        .two-col .right { width: 45%; text-align: right; }

        .recipient { font-size: 10px; line-height: 1.8; }
        .recipient .rname { font-weight: bold; font-size: 11px; color: #1a2744; }
        .recipient .rdetail { color: #555; }

        .ref-box { text-align: right; font-size: 9px; color: #666; }
        .ref-box .ref-label { font-size: 7px; text-transform: uppercase; letter-spacing: 1.5px; color: #1a2744; font-weight: bold; }

        .objet { margin: 14px 0 16px 0; font-size: 10px; padding: 7px 12px; background-color: #f0f3f8; border-left: 3px solid #1a2744; }
        .objet strong { color: #1a2744; }

        .greeting { margin-bottom: 10px; font-size: 10px; }
        .content { text-align: justify; font-size: 10px; line-height: 1.85; }
        .content p { margin-bottom: 5px; }
        .closing { margin-top: 20px; font-size: 10px; }
        .signature { margin-top: 35px; text-align: right; }
        .signature .sign-name { font-size: 11px; font-weight: bold; color: #1a2744; }
        .signature .sign-role { font-size: 8px; color: #888; margin-top: 2px; }
        .signature .sign-company { font-size: 7px; color: #aaa; text-transform: uppercase; letter-spacing: 1px; margin-top: 1px; }
    </style>
</head>
<body>
    <div class="banner"></div>
    <div class="banner-logo"><img src="{{ public_path('images/logo_sst.jpg') }}" alt="SST"></div>
    <div class="banner-name">SINIING SOHOMA TILO SARL</div>
    <div class="banner-tagline">Production Audiovisuelle &bull; Dakar, S&eacute;n&eacute;gal</div>
    <div class="accent-line"></div>
    <div class="footer-line"></div>

    <div class="footer">
        SINIING SOHOMA TILO SARL (SST) &bull; RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2<br>
        Villa 21, Unit&eacute; 23 Parcelles Assainies Dakar &ndash; S&eacute;n&eacute;gal &bull; +221 77 549 90 38
    </div>

    <div class="date">Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>

    <table class="two-col">
        <tr>
            <td class="left">
                <div class="recipient">
                    <div class="rname">{{ $document->civilite ? $document->civilite . ' ' : '' }}{{ $document->client_name }}</div>
                    @if($document->titre_destinataire)<div class="rdetail">{{ $document->titre_destinataire }}</div>@endif
                    @if($document->client_address)<div class="rdetail">{{ $document->client_address }}</div>@endif
                    @if($document->telephone_destinataire)<div class="rdetail">{{ $document->telephone_destinataire }}</div>@endif
                </div>
            </td>
            <td class="right">
                <div class="ref-box">
                    <div class="ref-label">R&eacute;f&eacute;rence</div>
                    <div>SST/{{ $document->created_at->format('Y') }}/{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
            </td>
        </tr>
    </table>

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
        <div class="sign-name">Sidi Hairou Camara</div>
        <div class="sign-role">Producteur / R&eacute;alisateur</div>
        <div class="sign-company">SINIING SOHOMA TILO SARL</div>
    </div>
</body>
</html>
