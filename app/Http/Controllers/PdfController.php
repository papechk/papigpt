<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PdfController extends Controller
{
    public function download(Document $document, string $format = 'pdf')
    {
        $document->load('invoiceItems');

        if ($format === 'word') {
            return $this->downloadWord($document);
        }

        if ($format === 'excel') {
            return $this->downloadExcel($document);
        }

        return $this->downloadPdf($document);
    }

    private function downloadPdf(Document $document)
    {
        $view = match ($document->type) {
            'letter' => 'pdf.letter-' . (in_array($document->design, ['simple', 'classique', 'moderne', 'elegant', 'corporate']) ? $document->design : 'classique'),
            'invoice_proforma', 'invoice_final' => 'pdf.invoice',
            'contrat' => 'pdf.contrat',
            'note_officielle' => 'pdf.note_officielle',
            'page_garde' => 'pdf.page_garde',
            default => abort(404, 'Type de document non supporté'),
        };

        $pdf = Pdf::loadView($view, compact('document'))
            ->setPaper('a4')
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true);

        $filename = $this->getFilename($document, 'pdf');

        return $pdf->download($filename);
    }

    private function downloadWord(Document $document)
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 800,
            'marginBottom' => 1000,
            'marginLeft' => 800,
            'marginRight' => 800,
        ]);

        // SST Header
        $this->addSstWordHeader($section);

        if ($document->type === 'letter') {
            $this->buildLetterWord($section, $document);
        } elseif ($document->isInvoice()) {
            $this->buildInvoiceWord($section, $phpWord, $document);
        } elseif ($document->type === 'contrat') {
            $this->buildContratWord($section, $document);
        } elseif ($document->type === 'note_officielle') {
            $this->buildNoteOfficielleWord($section, $document);
        } elseif ($document->type === 'page_garde') {
            $this->buildPageGardeWord($section, $document);
        }

        // SST Footer
        $this->addSstWordFooter($section);

        $filename = $this->getFilename($document, 'docx');
        $tempFile = storage_path('app/private/' . $filename);

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    private function addSstWordHeader($section)
    {
        $header = $section->addHeader();
        $logoPath = public_path('images/logo_sst.jpg');
        if (file_exists($logoPath)) {
            $header->addImage($logoPath, [
                'width' => 60,
                'height' => 60,
                'alignment' => Jc::CENTER,
            ]);
        }
        $header->addText(
            'SINIING SOHOMA TILO SARL (SST)',
            ['bold' => true, 'size' => 12],
            ['alignment' => Jc::CENTER]
        );
    }

    private function addSstWordFooter($section)
    {
        $footer = $section->addFooter();
        $footer->addText(
            'SINIING SOHOMA TILO SARL (SST) | RCCM SN-DKR-2025-B-50427 | NINEA 0127043012A2',
            ['size' => 7, 'color' => '666666'],
            ['alignment' => Jc::CENTER]
        );
        $footer->addText(
            'Villa 21, Unité 23 Parcelles Assainies Dakar – Sénégal | +221 77 549 90 38',
            ['size' => 7, 'color' => '666666'],
            ['alignment' => Jc::CENTER]
        );
    }

    private function buildLetterWord($section, Document $document)
    {
        $section->addText(
            'Dakar, le ' . $document->created_at->format('d/m/Y'),
            ['size' => 10],
            ['alignment' => Jc::END]
        );
        $section->addTextBreak(1);

        $destinataire = ($document->civilite ? $document->civilite . ' ' : '') . $document->client_name;
        $section->addText($destinataire, ['bold' => true, 'size' => 11]);
        if ($document->titre_destinataire) {
            $section->addText($document->titre_destinataire, ['size' => 10]);
        }
        if ($document->client_address) {
            $section->addText($document->client_address, ['size' => 10]);
        }
        if ($document->telephone_destinataire) {
            $section->addText($document->telephone_destinataire, ['size' => 10]);
        }
        $section->addTextBreak(1);

        if ($document->objet) {
            $section->addText('Objet : ' . $document->objet, ['bold' => true, 'size' => 10]);
            $section->addTextBreak(1);
        }

        $greeting = $document->civilite ? $document->civilite . ' ' . $document->client_name : 'Madame, Monsieur';
        $section->addText($greeting . ',');
        $section->addTextBreak(1);

        $lines = explode("\n", $document->content);
        foreach ($lines as $line) {
            $section->addText(trim($line));
        }

        $section->addTextBreak(1);
        $section->addText('Cordialement,');

        $section->addTextBreak(2);
        $section->addText('Sidi Hairou Camara', ['bold' => true, 'size' => 10], ['alignment' => Jc::END]);
        $section->addText('Producteur / Réalisateur', ['size' => 9, 'color' => '666666'], ['alignment' => Jc::END]);
    }

    private function buildInvoiceWord($section, PhpWord $phpWord, Document $document)
    {
        $typeLabel = $document->type === 'invoice_proforma' ? 'FACTURE PROFORMA' : 'FACTURE';

        $section->addText(
            $typeLabel,
            ['bold' => true, 'size' => 18],
            ['alignment' => Jc::CENTER]
        );
        $section->addTextBreak(1);

        $section->addText('Client : ' . $document->client_name, ['bold' => true, 'size' => 12]);
        $section->addText('Adresse : ' . $document->client_address);
        $section->addText('Date : ' . $document->created_at->format('d/m/Y'));
        $section->addTextBreak(1);

        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '999999',
            'cellMargin' => 80,
        ];
        $phpWord->addTableStyle('InvoiceTable', $tableStyle);

        $table = $section->addTable('InvoiceTable');

        $headerStyle = ['bold' => true, 'color' => 'FFFFFF'];
        $headerCellStyle = ['bgColor' => '333333', 'valign' => 'center'];

        $table->addRow();
        $table->addCell(4500, $headerCellStyle)->addText('Désignation', $headerStyle);
        $table->addCell(1500, $headerCellStyle)->addText('Qté', $headerStyle, ['alignment' => Jc::CENTER]);
        $table->addCell(2000, $headerCellStyle)->addText('Prix Unit.', $headerStyle, ['alignment' => Jc::END]);
        $table->addCell(2000, $headerCellStyle)->addText('Total', $headerStyle, ['alignment' => Jc::END]);

        foreach ($document->invoiceItems as $item) {
            $table->addRow();
            $table->addCell(4500)->addText($item->designation);
            $table->addCell(1500)->addText($item->quantity, [], ['alignment' => Jc::CENTER]);
            $table->addCell(2000)->addText(number_format($item->price, 0, ',', ' ') . ' FCFA', [], ['alignment' => Jc::END]);
            $table->addCell(2000)->addText(number_format($item->total, 0, ',', ' ') . ' FCFA', [], ['alignment' => Jc::END]);
        }

        $section->addTextBreak(1);
        $section->addText(
            'TOTAL : ' . number_format($document->total, 0, ',', ' ') . ' FCFA',
            ['bold' => true, 'size' => 14],
            ['alignment' => Jc::END]
        );

        $section->addTextBreak(2);
        $section->addText('Signature et cachet', ['bold' => true, 'size' => 10], ['alignment' => Jc::END]);
        $section->addTextBreak(2);
        $section->addText('Sidi Hairou Camara', ['bold' => true, 'size' => 10], ['alignment' => Jc::END]);
        $section->addText('Producteur / Réalisateur', ['size' => 9, 'color' => '666666'], ['alignment' => Jc::END]);
    }

    private function buildContratWord($section, Document $document)
    {
        $section->addText(
            'CONTRAT DE PRESTATION',
            ['bold' => true, 'size' => 16],
            ['alignment' => Jc::CENTER]
        );
        $section->addTextBreak(1);

        $section->addText('Entre : SINIING SOHOMA TILO SARL (SST)', ['bold' => true]);
        $section->addText('Et : ' . $document->client_name, ['bold' => true]);
        $section->addTextBreak(1);

        if ($document->objet) {
            $section->addText('Objet du contrat : ' . $document->objet, ['bold' => true]);
        }
        if ($document->duree) {
            $section->addText('Durée : ' . $document->duree);
        }
        $section->addTextBreak(1);

        $lines = explode("\n", $document->content);
        foreach ($lines as $line) {
            $section->addText(trim($line));
        }

        $section->addTextBreak(1);
        $section->addText('Fait à Dakar, le ' . $document->created_at->format('d/m/Y'));
        $section->addTextBreak(2);
        $section->addText('Signatures des parties', ['bold' => true, 'size' => 11], ['alignment' => Jc::CENTER]);
    }

    private function buildNoteOfficielleWord($section, Document $document)
    {
        $section->addText(
            'NOTE OFFICIELLE',
            ['bold' => true, 'size' => 16],
            ['alignment' => Jc::CENTER]
        );
        $section->addTextBreak(1);

        if ($document->reference) {
            $section->addText('Référence : ' . $document->reference, ['bold' => true]);
        }
        if ($document->objet) {
            $section->addText('Objet : ' . $document->objet, ['bold' => true]);
        }
        $section->addText('Date : ' . $document->created_at->format('d/m/Y'));
        $section->addTextBreak(1);

        $lines = explode("\n", $document->content);
        foreach ($lines as $line) {
            $section->addText(trim($line));
        }

        $section->addTextBreak(2);
        $section->addText('Sidi Hairou Camara', ['bold' => true, 'size' => 10], ['alignment' => Jc::END]);
        $section->addText('Producteur / Réalisateur', ['size' => 9, 'color' => '666666'], ['alignment' => Jc::END]);
    }

    private function buildPageGardeWord($section, Document $document)
    {
        $logoPath = public_path('images/logo_sst.jpg');
        if (file_exists($logoPath)) {
            $section->addImage($logoPath, [
                'width' => 100,
                'height' => 100,
                'alignment' => Jc::CENTER,
            ]);
        }

        $section->addTextBreak(3);
        $section->addText(
            $document->content,
            ['bold' => true, 'size' => 22],
            ['alignment' => Jc::CENTER]
        );
        $section->addTextBreak(2);
        $section->addText(
            'Un film de Sidi Hairou Camara (SHC)',
            ['size' => 14],
            ['alignment' => Jc::CENTER]
        );
        $section->addTextBreak(2);
        $section->addText(
            'Production : SINIING SOHOMA TILO SARL (SST)',
            ['bold' => true, 'size' => 12],
            ['alignment' => Jc::CENTER]
        );
    }

    private function downloadExcel(Document $document)
    {
        if (!$document->isInvoice()) {
            abort(404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Facture');

        // -- En-tête entreprise --
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'SINIING SOHOMA TILO SARL (SST)');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', 'Villa 21, Unité 23 Parcelles Assainies Dakar – Sénégal | +221 77 549 90 38');
        $sheet->getStyle('A2')->getFont()->setSize(9)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF666666'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A3:D3');
        $sheet->setCellValue('A3', 'RCCM SN-DKR-2025-B-50427 | NINEA 0127043012A2');
        $sheet->getStyle('A3')->getFont()->setSize(9)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF666666'));
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // -- Type de facture --
        $typeLabel = $document->type === 'invoice_proforma' ? 'FACTURE PROFORMA' : 'FACTURE';
        $sheet->mergeCells('A5:D5');
        $sheet->setCellValue('A5', $typeLabel);
        $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // -- Infos client --
        $sheet->setCellValue('A7', 'Client :');
        $sheet->setCellValue('B7', $document->client_name);
        $sheet->getStyle('A7')->getFont()->setBold(true);
        $sheet->setCellValue('A8', 'Adresse :');
        $sheet->setCellValue('B8', $document->client_address);
        $sheet->getStyle('A8')->getFont()->setBold(true);
        $sheet->setCellValue('A9', 'Date :');
        $sheet->setCellValue('B9', $document->created_at->format('d/m/Y'));
        $sheet->getStyle('A9')->getFont()->setBold(true);
        $sheet->setCellValue('A10', 'Réf :');
        $sheet->setCellValue('B10', $typeLabel . ' N° ' . $document->id);
        $sheet->getStyle('A10')->getFont()->setBold(true);

        // -- Tableau des articles --
        $headerRow = 12;
        $columns = ['A', 'B', 'C', 'D'];
        $headers = ['Désignation', 'Quantité', 'Prix Unitaire (FCFA)', 'Total (FCFA)'];
        foreach ($headers as $col => $header) {
            $sheet->setCellValue($columns[$col] . $headerRow, $header);
        }
        $headerRange = 'A' . $headerRow . ':D' . $headerRow;
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('333333');
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $row = $headerRow + 1;
        foreach ($document->invoiceItems as $item) {
            $sheet->setCellValue('A' . $row, $item->designation);
            $sheet->setCellValue('B' . $row, $item->quantity);
            $sheet->setCellValue('C' . $row, $item->price);
            $sheet->setCellValue('D' . $row, $item->total);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $row++;
        }

        // -- Total --
        $totalRow = $row + 1;
        $sheet->mergeCells('A' . $totalRow . ':C' . $totalRow);
        $sheet->setCellValue('A' . $totalRow, 'TOTAL');
        $sheet->getStyle('A' . $totalRow)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue('D' . $totalRow, $document->total);
        $sheet->getStyle('D' . $totalRow)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('D' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');

        // -- Bordures tableau --
        $tableRange = 'A' . $headerRow . ':D' . ($row - 1);
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $totalRange = 'A' . $totalRow . ':D' . $totalRow;
        $sheet->getStyle($totalRange)->getBorders()->getTop()->setBorderStyle(Border::BORDER_DOUBLE);

        // -- Largeurs de colonnes --
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);

        // -- Signature --
        $sigRow = $totalRow + 3;
        $sheet->setCellValue('D' . $sigRow, 'Signature et cachet');
        $sheet->getStyle('D' . $sigRow)->getFont()->setBold(true);
        $sheet->setCellValue('D' . ($sigRow + 2), 'Sidi Hairou Camara');
        $sheet->getStyle('D' . ($sigRow + 2))->getFont()->setBold(true);
        $sheet->setCellValue('D' . ($sigRow + 3), 'Producteur / Réalisateur');
        $sheet->getStyle('D' . ($sigRow + 3))->getFont()->setSize(9)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF666666'));

        $filename = $this->getFilename($document, 'xlsx');
        $tempFile = storage_path('app/private/' . $filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    private function getFilename(Document $document, string $extension): string
    {
        $prefix = match ($document->type) {
            'letter' => 'lettre',
            'invoice_proforma' => 'facture-proforma',
            'invoice_final' => 'facture',
            'contrat' => 'contrat',
            'note_officielle' => 'note-officielle',
            'page_garde' => 'page-garde',
            default => 'document',
        };

        return $prefix . '-' . $document->id . '.' . $extension;
    }
}
