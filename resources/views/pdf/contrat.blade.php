<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrat #{{ $document->id }}</title>
    @include('pdf._sst_styles')
</head>
<body>
    @include('pdf._sst_header_footer')

    <div class="doc-title">
        <h1>Contrat de Prestation</h1>
        <div class="doc-number">R&eacute;f. CT-{{ $document->created_at->format('Y') }}-{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }} &mdash; {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>
    </div>

    <div class="section-heading">Les parties</div>

    <table class="parties-grid">
        <tr>
            <td>
                <div class="info-block">
                    <div class="info-label">Le prestataire</div>
                    <div class="info-value" style="font-weight: bold; font-size: 11px;">SINIING SOHOMA TILO SARL (SST)</div>
                    <div class="info-value" style="font-size: 8px; color: #888; margin-top: 2px;">RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2</div>
                    <div class="info-value" style="font-size: 8px; color: #888;">Villa 21, Unit&eacute; 23 Parcelles Assainies, Dakar</div>
                    <div class="info-value" style="font-size: 8px; color: #888;">Repr&eacute;sent&eacute;e par M. Sidi Hairou Camara, G&eacute;rant</div>
                </div>
            </td>
            <td>
                <div class="info-block">
                    <div class="info-label">Le client</div>
                    <div class="info-value" style="font-weight: bold; font-size: 11px;">{{ $document->client_name }}</div>
                </div>
            </td>
        </tr>
    </table>

    @if($document->objet)
    <div class="section-heading">Article 1 &mdash; Objet du contrat</div>
    <div class="content">
        <p>Le pr&eacute;sent contrat a pour objet : <strong>{{ $document->objet }}</strong></p>
    </div>
    @endif

    @if($document->duree)
    <div class="section-heading">Article 2 &mdash; Dur&eacute;e</div>
    <div class="content">
        <p>Le pr&eacute;sent contrat est conclu pour une dur&eacute;e de : <strong>{{ $document->duree }}</strong>, &agrave; compter de la date de signature.</p>
    </div>
    @endif

    <div class="section-heading">Article {{ $document->objet && $document->duree ? '3' : ($document->objet || $document->duree ? '2' : '1') }} &mdash; Conditions &amp; Clauses</div>

    <div class="content">
        @foreach(explode("\n", $document->content) as $line)
            @if(trim($line) !== '')
                <p>{{ $line }}</p>
            @else
                <br>
            @endif
        @endforeach
    </div>

    <div class="lieu-date">
        Fait &agrave; Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}, en deux (2) exemplaires originaux, un pour chaque partie.
    </div>

    <table class="signatures-grid">
        <tr>
            <td>
                <div class="sign-label">Pour le prestataire &mdash; SST</div>
                <div class="sign-line"></div>
                <div class="sign-name">Sidi Hairou Camara</div>
                <div class="sign-role">Producteur / R&eacute;alisateur &bull; G&eacute;rant</div>
            </td>
            <td>
                <div class="sign-label">Pour le client</div>
                <div class="sign-line"></div>
                <div class="sign-name">{{ $document->client_name }}</div>
            </td>
        </tr>
    </table>
</body>
</html>
