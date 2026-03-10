<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DashboardController extends Controller
{
    public function index()
    {
        $recentDocuments = Document::latest()->take(5)->get();
        $stats = [
            'letters' => Document::where('type', 'letter')->count(),
            'proforma' => Document::where('type', 'invoice_proforma')->count(),
            'invoices' => Document::where('type', 'invoice_final')->count(),
            'contrats' => Document::where('type', 'contrat')->count(),
            'notes' => Document::where('type', 'note_officielle')->count(),
            'pages_garde' => Document::where('type', 'page_garde')->count(),
            'total' => Document::count(),
        ];

        return view('dashboard', compact('recentDocuments', 'stats'));
    }
}
