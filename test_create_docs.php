<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
echo "User: {$user->email}\n";

// Test Letter
$doc = App\Models\Document::create([
    'user_id' => $user->id,
    'type' => 'letter',
    'client_name' => 'Test Client Lettre',
    'content' => "Ceci est une lettre de test pour PapiGPT.\nNous vous remercions de votre confiance.",
]);
echo "Lettre creee ID: {$doc->id}\n";

// Test Invoice Proforma
$doc2 = App\Models\Document::create([
    'user_id' => $user->id,
    'type' => 'invoice_proforma',
    'client_name' => 'Client Facture Test',
    'content' => '',
    'total' => 150000,
]);
App\Models\InvoiceItem::create(['document_id' => $doc2->id, 'designation' => 'Production video', 'quantity' => 1, 'price' => 100000, 'total' => 100000]);
App\Models\InvoiceItem::create(['document_id' => $doc2->id, 'designation' => 'Montage', 'quantity' => 2, 'price' => 25000, 'total' => 50000]);
echo "Facture proforma creee ID: {$doc2->id}\n";

// Test Contrat
$doc3 = App\Models\Document::create([
    'user_id' => $user->id,
    'type' => 'contrat',
    'client_name' => 'Client Contrat Test',
    'objet' => 'Realisation documentaire',
    'duree' => '3 mois',
    'content' => "Article 1 : Le prestataire s'engage a realiser un documentaire.\nArticle 2 : Le client s'engage a payer le montant convenu.",
]);
echo "Contrat cree ID: {$doc3->id}\n";

// Test Note Officielle
$doc4 = App\Models\Document::create([
    'user_id' => $user->id,
    'type' => 'note_officielle',
    'reference' => 'NO-2025-001',
    'objet' => 'Organisation du tournage',
    'content' => "Par la presente note, nous informons l'ensemble du personnel que le tournage debutera le 15 janvier 2025.",
]);
echo "Note officielle creee ID: {$doc4->id}\n";

// Test Page de Garde
$doc5 = App\Models\Document::create([
    'user_id' => $user->id,
    'type' => 'page_garde',
    'content' => "LE GRAND VOYAGE\nDocumentaire",
]);
echo "Page de garde creee ID: {$doc5->id}\n";

echo "Total documents: " . App\Models\Document::count() . "\n";
echo "--- IDs pour test PDF ---\n";
echo "LETTER_ID={$doc->id}\n";
echo "INVOICE_ID={$doc2->id}\n";
echo "CONTRAT_ID={$doc3->id}\n";
echo "NOTE_ID={$doc4->id}\n";
echo "PAGE_GARDE_ID={$doc5->id}\n";
