<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Page de Garde</title>
    @include('pdf._sst_styles')
    <style>
        body { padding-top: 15mm; }
    </style>
</head>
<body>
    {{-- Footer uniquement --}}
    <div class="sst-footer">
        SINIING SOHOMA TILO SARL (SST) &bull; RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2<br>
        Villa 21, Unit&eacute; 23 Parcelles Assainies Dakar &ndash; S&eacute;n&eacute;gal &bull; +221 77 549 90 38
    </div>

    <div class="page-garde">
        <img src="{{ public_path('images/logo_sst.jpg') }}" alt="SST">

        <div style="margin-top: 12px; font-size: 10px; font-weight: bold; letter-spacing: 3px; color: #C8A415; text-transform: uppercase;">SINIING SOHOMA TILO SARL</div>
        <div style="font-size: 7px; color: #999; letter-spacing: 2px; margin-top: 2px;">Production Audiovisuelle &bull; Dakar, S&eacute;n&eacute;gal</div>

        <div style="margin-top: 10px; font-size: 7px; letter-spacing: 3px; text-transform: uppercase; color: #aaa;">pr&eacute;sente</div>

        <div class="film-title">
            {!! nl2br(e($document->content)) !!}
        </div>

        <div class="subtitle">
            Un film de <strong>Sidi Hairou Camara</strong> (SHC)
        </div>

        <div class="production">
            Production &bull; <strong>SINIING SOHOMA TILO SARL (SST)</strong>
        </div>

        <div style="margin-top: 50px; font-size: 8px; color: #aaa; letter-spacing: 2px; text-transform: uppercase;">
            &copy; {{ date('Y') }} &bull; Tous droits r&eacute;serv&eacute;s
        </div>
    </div>
</body>
</html>
