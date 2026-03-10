<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lettre #{{ $document->id }}</title>
    @include('pdf._sst_styles')
    <style>
        .letter-date {
            text-align: right;
            font-size: 10px;
            color: #333;
            margin-bottom: 20px;
        }
        .recipient-block {
            margin-bottom: 8px;
            font-size: 10px;
            line-height: 1.8;
            color: #222;
        }
        .recipient-block .recipient-name {
            font-weight: bold;
            font-size: 11px;
        }
        .letter-objet {
            margin: 14px 0 18px 0;
            font-size: 10px;
        }
        .letter-objet strong {
            color: #1a1a1a;
        }
        .letter-greeting {
            margin-bottom: 12px;
            font-size: 10px;
            color: #222;
        }
        .letter-closing {
            margin-top: 22px;
            font-size: 10px;
            color: #222;
        }
    </style>
</head>
<body>
    @include('pdf._sst_header_footer')

    {{-- Date --}}
    <div class="letter-date">
        Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}
    </div>

    {{-- Bloc destinataire --}}
    <div class="recipient-block">
        <div class="recipient-name">{{ $document->civilite ? $document->civilite . ' ' : '' }}{{ $document->client_name }}</div>
        @if($document->titre_destinataire)
            <div>{{ $document->titre_destinataire }}</div>
        @endif
        @if($document->client_address)
            <div>{{ $document->client_address }}</div>
        @endif
        @if($document->telephone_destinataire)
            <div>{{ $document->telephone_destinataire }}</div>
        @endif
    </div>

    {{-- Objet --}}
    @if($document->objet)
    <div class="letter-objet">
        <strong>Objet :</strong> {{ $document->objet }}
    </div>
    @endif

    {{-- Formule d'appel --}}
    <div class="letter-greeting">
        {{ $document->civilite ? $document->civilite . ' ' . $document->client_name : 'Madame, Monsieur' }},
    </div>

    {{-- Contenu --}}
    <div class="content">
        @foreach(explode("\n", $document->content) as $line)
            @if(trim($line) !== '')
                <p>{{ $line }}</p>
            @else
                <br>
            @endif
        @endforeach
    </div>

    {{-- Formule de politesse --}}
    <div class="letter-closing">
        Cordialement,
    </div>

    {{-- Signature --}}
    <div class="signature">
        <div class="sign-name">Sidi Hairou Camara</div>
        <div class="sign-role">Producteur / R&eacute;alisateur</div>
    </div>
</body>
</html>
