{{-- Header SST (fixed en haut de chaque page) --}}
<div class="sst-header">
    <img src="{{ public_path('images/logo_sst.jpg') }}" alt="SST">
    @if(($document->design ?? 'classique') !== 'simple')
    <div class="company-name">SINIING SOHOMA TILO SARL</div>
    <div class="company-tagline">Production Audiovisuelle &bull; Dakar, S&eacute;n&eacute;gal</div>
    @endif
</div>

{{-- Footer SST (fixed en bas de chaque page) --}}
<div class="sst-footer">
    SINIING SOHOMA TILO SARL (SST) &bull; RCCM SN-DKR-2025-B-50427 &bull; NINEA 0127043012A2<br>
    Villa 21, Unit&eacute; 23 Parcelles Assainies Dakar &ndash; S&eacute;n&eacute;gal &bull; +221 77 549 90 38
</div>
