{{-- Design Classique — Style SST doré, header centré, lignes fines --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lettre #{{ $document->id }}</title>
    <style>
        @page { size: A4; margin: 30mm 20mm 25mm 20mm; }
        body { margin: 0; padding: 0; font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #2c2c2c; line-height: 1.7; }

        .header { position: fixed; top: -25mm; left: 0; right: 0; height: 22mm; text-align: center; border-bottom: 2px solid #C8A415; padding-bottom: 3px; }
        .header img { display: block; margin: 0 auto; height: 38px; }
        .header .name { font-size: 8px; font-weight: bold; letter-spacing: 3px; color: #1a1a1a; margin-top: 2px; text-transform: uppercase; }
        .header .tagline { font-size: 6.5px; color: #999; letter-spacing: 1.5px; margin-top: 1px; }

        .footer { position: fixed; bottom: -20mm; left: 0; right: 0; height: 14mm; text-align: center; font-size: 6.5px; color: #888; border-top: 1.5px solid #C8A415; padding-top: 4px; line-height: 1.6; }

        .date { text-align: right; font-size: 10px; color: #555; margin-bottom: 18px; }
        .recipient { margin-bottom: 6px; font-size: 10px; line-height: 1.8; }
        .recipient .name { font-weight: bold; font-size: 11px; color: #1a1a1a; }
        .objet { margin: 12px 0 16px 0; font-size: 10px; }
        .objet strong { color: #C8A415; }
        .greeting { margin-bottom: 10px; font-size: 10px; }
        .content { text-align: justify; font-size: 10px; line-height: 1.8; }
        .content p { margin-bottom: 5px; }
        .closing { margin-top: 20px; font-size: 10px; }
        .signature { margin-top: 35px; text-align: right; }
        .signature .sign-name { font-size: 11px; font-weight: bold; color: #1a1a1a; }
        .signature .sign-role { font-size: 8px; color: #888; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_sst.jpg') }}" alt="SST">
        <div class="name">SINIING SOHOMA TILO SARL</div>
        <div class="tagline">Production Audiovisuelle &bull; Dakar, S&eacute;n&eacute;gal</div>
    </div>

    <div class="footer">
        SINIING SOHOMA TILO SARL (SST) &bull; RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2<br>
        Villa 21, Unit&eacute; 23 Parcelles Assainies Dakar &ndash; S&eacute;n&eacute;gal &bull; +221 77 549 90 38
    </div>

    <div class="date">Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>

    <div class="recipient">
        <div class="name">{{ $document->civilite ? $document->civilite . ' ' : '' }}{{ $document->client_name }}</div>
        @if($document->titre_destinataire)<div>{{ $document->titre_destinataire }}</div>@endif
        @if($document->client_address)<div>{{ $document->client_address }}</div>@endif
        @if($document->telephone_destinataire)<div>{{ $document->telephone_destinataire }}</div>@endif
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
        <div class="sign-name">Sidi Hairou Camara</div>
        <div class="sign-role">Producteur / R&eacute;alisateur</div>
    </div>
</body>
</html>
