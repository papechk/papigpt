<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;

$testIds = [
    'letter' => 2,
    'invoice_proforma' => 3,
    'contrat' => 4,
    'note_officielle' => 5,
    'page_garde' => 6,
];

foreach ($testIds as $type => $id) {
    echo "--- Test PDF: {$type} (ID={$id}) ---\n";
    try {
        $document = Document::with('invoiceItems')->findOrFail($id);

        $view = match($document->type) {
            'invoice_proforma', 'invoice_final' => 'pdf.invoice',
            'contrat' => 'pdf.contrat',
            'note_officielle' => 'pdf.note_officielle',
            'page_garde' => 'pdf.page_garde',
            default => 'pdf.letter',
        };

        $pdf = Pdf::loadView($view, compact('document'))
            ->setPaper('a4')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true);

        $outputPath = __DIR__ . "/storage/app/test_{$type}.pdf";
        file_put_contents($outputPath, $pdf->output());

        $size = filesize($outputPath);
        echo "  OK - Fichier genere: test_{$type}.pdf ({$size} octets)\n";
    } catch (Throwable $e) {
        echo "  ERREUR: {$e->getMessage()}\n";
        echo "  Fichier: {$e->getFile()}:{$e->getLine()}\n";
    }
}

echo "\n=== Resultats PDF ===\n";
foreach ($testIds as $type => $id) {
    $path = __DIR__ . "/storage/app/test_{$type}.pdf";
    if (file_exists($path)) {
        echo "  [OK] {$type}: " . filesize($path) . " octets\n";
    } else {
        echo "  [FAIL] {$type}: fichier non genere\n";
    }
}
