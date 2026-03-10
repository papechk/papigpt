<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Note Officielle #{{ $document->id }}</title>
    @include('pdf._sst_styles')
</head>
<body>
    @include('pdf._sst_header_footer')

    <div class="doc-title">
        <h1>Note Officielle</h1>
        <div class="doc-number">R&eacute;f. {{ $document->reference ?? ('NO-' . $document->created_at->format('Y') . '-' . str_pad($document->id, 4, '0', STR_PAD_LEFT)) }}</div>
    </div>

    <div class="info-card">
        <table style="width: 100%;">
            <tr>
                <td style="width: 65%; vertical-align: top;">
                    @if($document->objet)
                    <div class="info-block" style="margin-bottom: 0;">
                        <div class="info-label">Objet</div>
                        <div class="info-value" style="font-weight: bold; font-size: 11px;">{{ $document->objet }}</div>
                    </div>
                    @endif
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div class="info-block" style="margin-bottom: 0;">
                        <div class="info-label">Date</div>
                        <div class="info-value">Dakar, le {{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content" style="margin-top: 15px;">
        @foreach(explode("\n", $document->content) as $line)
            @if(trim($line) !== '')
                <p>{{ $line }}</p>
            @else
                <br>
            @endif
        @endforeach
    </div>

    <div class="signature">
        <div class="sign-label">Le G&eacute;rant</div>
        <div class="sign-line"></div>
        <div class="sign-name">Sidi Hairou Camara</div>
        <div class="sign-role">Producteur / R&eacute;alisateur &bull; G&eacute;rant SST</div>
    </div>
</body>
</html>
