<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $document->type === 'invoice_proforma' ? 'Facture Proforma' : 'Facture' }} #{{ $document->id }}</title>
    @include('pdf._sst_styles')
</head>
<body>
    @include('pdf._sst_header_footer')

    {{-- Type badge + Numéro --}}
    <div class="doc-title">
        <h1>{{ $document->type === 'invoice_proforma' ? 'Facture Proforma' : 'Facture D&eacute;finitive' }}</h1>
        <div class="doc-number">N&deg; {{ $document->type === 'invoice_proforma' ? 'FP' : 'FD' }}-{{ $document->created_at->format('Y') }}-{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}</div>
    </div>

    {{-- Informations client + facture côte à côte --}}
    <table class="info-grid">
        <tr>
            <td style="width: 55%;">
                <div class="info-card">
                    <div class="info-block">
                        <div class="info-label">Factur&eacute; &agrave;</div>
                        <div class="info-value" style="font-weight: bold; font-size: 11px;">{{ $document->client_name }}</div>
                    </div>
                    @if($document->client_address)
                    <div class="info-block" style="margin-bottom: 0;">
                        <div class="info-label">Adresse</div>
                        <div class="info-value">{{ $document->client_address }}</div>
                    </div>
                    @endif
                </div>
            </td>
            <td style="text-align: right; padding-left: 15px;">
                <div class="info-block">
                    <div class="info-label">Date d'&eacute;mission</div>
                    <div class="info-value">{{ $document->created_at->locale('fr')->translatedFormat('d F Y') }}</div>
                </div>
                <div class="info-block">
                    <div class="info-label">R&eacute;f&eacute;rence</div>
                    <div class="info-value" style="font-weight: bold;">SST/{{ $document->created_at->format('Y') }}/{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                @if($document->type === 'invoice_proforma')
                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-label">Validit&eacute;</div>
                    <div class="info-value">30 jours</div>
                </div>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-heading">D&eacute;tail des prestations</div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 8%;">N&deg;</th>
                <th style="width: 42%;">D&eacute;signation</th>
                <th class="center" style="width: 10%;">Qt&eacute;</th>
                <th class="right" style="width: 20%;">Prix unitaire</th>
                <th class="right" style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($document->invoiceItems as $idx => $item)
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td>{{ $item->designation }}</td>
                <td class="center">{{ $item->quantity }}</td>
                <td class="right">{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                <td class="right" style="font-weight: bold;">{{ number_format($item->total, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div class="label">Montant total</div>
        <div class="amount">{{ number_format($document->total, 0, ',', ' ') }} FCFA</div>
    </div>

    <div style="margin-top: 14px; font-size: 8px; color: #888; font-style: italic;">
        Arr&ecirc;t&eacute;e la pr&eacute;sente facture &agrave; la somme de : <strong style="color: #2c2c2c;">{{ number_format($document->total, 0, ',', ' ') }} FCFA</strong>
    </div>

    <div class="payment-info">
        <strong>Conditions de paiement :</strong> Paiement &agrave; r&eacute;ception de facture<br>
        <strong>Mode de paiement :</strong> Virement bancaire / Ch&egrave;que / Esp&egrave;ces
    </div>

    <div class="signature">
        <div class="sign-label">Pour SST &mdash; Signature et cachet</div>
        <div class="sign-line"></div>
        <div class="sign-name">Sidi Hairou Camara</div>
        <div class="sign-role">Producteur / R&eacute;alisateur &bull; G&eacute;rant</div>
    </div>
</body>
</html>
