<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = [
        'template_id',
        'design',
        'type',
        'civilite',
        'reference',
        'objet',
        'duree',
        'client_name',
        'titre_destinataire',
        'client_address',
        'telephone_destinataire',
        'content',
        'total',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'letter' => 'Lettre',
            'invoice_proforma' => 'Facture Proforma',
            'invoice_final' => 'Facture Définitive',
            'contrat' => 'Contrat',
            'note_officielle' => 'Note Officielle',
            'page_garde' => 'Page de Garde',
            default => $this->type,
        };
    }

    public function isInvoice(): bool
    {
        return in_array($this->type, ['invoice_proforma', 'invoice_final']);
    }
}
