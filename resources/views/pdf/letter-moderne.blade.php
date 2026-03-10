{{-- Design Moderne — Bande latérale gauche + barre bas, style Canva sidebar --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lettre #{{ $document->id }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body { margin: 0; padding: 20mm 20mm 24mm 28mm; font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #2c2c2c; line-height: 1.7; }

        /* Bande latérale gauche */
        .sidebar { position: fixed; top: 0; left: 0; width: 6mm; height: 297mm; background-color: #3f3861; }
        /* Barre en bas */
        .bottom-bar { position: fixed; bottom: 0; left: 0; width: 210mm; height: 5mm; background-color: #3f3861; }

        .header { text-align: left; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1.5px solid #e0e0e0; }
        .header img { height: 36px; display: inline-block; vertical-align: middle; }
        .header .info { display: inline-block; vertical-align: middle; margin-left: 10px; }
        .header .name { font-size: 10px; font-weight: bold; letter-spacing: 2px; color: #3f3861; text-transform: uppercase; }
        .header .tagline { font-size: 7px; color: #999; letter-spacing: 1px; margin-top: 1px; }

        .footer { position: fixed; bottom: 7mm; left: 28mm; width: 154mm; text-align: center; font-size: 6px; color: #aaa; line-height: 1.5; }

        .date { text-align: right; font-size: 10px; color: #666; margin-bottom: 22px; }

        .recipient { margin-bottom: 8px; font-size: 10px; line-height: 1.9; padding: 10px 14px; border-left: 3px solid #3f3861; background-color: #f8f7fc; }
        .recipient .rname { font-weight: bold; font-size: 11px; color: #3f3861; }

        .objet { margin: 14px 0 18px 0; font-size: 10px; padding: 6px 0; border-bottom: 1px solid #e8e8e8; }
        .objet strong { color: #3f3861; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; }

        .greeting { margin-bottom: 12px; font-size: 10px; color: #333; }
        .content { text-align: justify; font-size: 10px; line-height: 1.85; }
        .content p { margin-bottom: 5px; }
        .closing { margin-top: 22px; font-size: 10px; color: #333; }
        .signature { margin-top: 35px; text-align: right; }
        .signature .sign-name { font-size: 11px; font-weight: bold; color: #3f3861; }
        .signature .sign-role { font-size: 8px; color: #888; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="sidebar"></div>
    <div class="bottom-bar"></div>

    <table class="header" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 50px; padding: 0;">
                <img src="{{ public_path('images/logo_sst.jpg') }}" alt="SST">
            </td>
            <td style="padding: 0 0 0 10px; vertical-align: middle;">
                <div class="name">SINIING SOHOMA TILO SARL</div>
                <div class="tagline">Production Audiovisuelle &bull; Dakar, S&eacute;n&eacute;gal</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        SINIING SOHOMA TILO SARL (SST) &bull; RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2 &bull;
        Villa 21, Unit&eacute; 23 Parcelles Assainies Dakar &ndash; S&eacute;n&eacute;gal &bull; +221 77 549 90 38
    </div>

    <div class="date">Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>

    <div class="recipient">
        <div class="rname">{{ $document->civilite ? $document->civilite . ' ' : '' }}{{ $document->client_name }}</div>
        @if($document->titre_destinataire)<div>{{ $document->titre_destinataire }}</div>@endif
        @if($document->client_address)<div>{{ $document->client_address }}</div>@endif
        @if($document->telephone_destinataire)<div>{{ $document->telephone_destinataire }}</div>@endif
    </div>

    @if($document->objet)
    <div class="objet"><strong>Objet : </strong>{{ $document->objet }}</div>
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
    </div>
</body>
</html>
