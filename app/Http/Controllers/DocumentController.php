<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\InvoiceItem;
use App\Models\Template;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->paginate(15);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $type = request('type', 'letter');
        $templates = Template::where('type', $type)->get();
        return view('documents.create', compact('type', 'templates'));
    }

    public function store(StoreDocumentRequest $request)
    {
        $data = $request->validated();
        $type = $data['type'];

        if (in_array($type, ['invoice_proforma', 'invoice_final'])) {
            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            $document = Document::create([
                'type' => $type,
                'template_id' => $data['template_id'] ?? null,
                'design' => $data['design'] ?? 'classique',
                'client_name' => $data['client_name'],
                'client_address' => $data['client_address'],
                'total' => $total,
            ]);

            foreach ($data['items'] as $item) {
                $document->invoiceItems()->create([
                    'designation' => $item['designation'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }
        } elseif ($type === 'contrat') {
            $document = Document::create([
                'type' => $type,
                'template_id' => $data['template_id'] ?? null,
                'design' => $data['design'] ?? 'classique',
                'client_name' => $data['client_name'],
                'objet' => $data['objet'],
                'duree' => $data['duree'] ?? null,
                'content' => $data['content'],
            ]);
        } elseif ($type === 'note_officielle') {
            $document = Document::create([
                'type' => $type,
                'template_id' => $data['template_id'] ?? null,
                'design' => $data['design'] ?? 'classique',
                'reference' => $data['reference'] ?? null,
                'objet' => $data['objet'],
                'content' => $data['content'],
            ]);
        } elseif ($type === 'page_garde') {
            $document = Document::create([
                'type' => $type,
                'template_id' => $data['template_id'] ?? null,
                'design' => $data['design'] ?? 'classique',
                'content' => $data['content'],
            ]);
        } else {
            // Letter type
            $content = $data['content'] ?? '';
            $templateId = $data['template_id'] ?? null;
            $template = $templateId ? Template::find($templateId) : null;

            // Si un template avec variables est sélectionné, générer le contenu
            if ($template && !empty($data['variables']) && !empty($template->variables)) {
                $content = $template->render($data['variables']);
            }

            // Le design vient du formulaire (sélecteur visuel dans Step 2)
            $design = $data['design'] ?? ($template && $template->design ? $template->design : 'classique');

            $document = Document::create([
                'type' => $type,
                'template_id' => $templateId,
                'design' => $design,
                'civilite' => $data['civilite'],
                'objet' => $data['objet'],
                'client_name' => $data['client_name'],
                'titre_destinataire' => $data['titre_destinataire'] ?? null,
                'client_address' => $data['client_address'] ?? null,
                'telephone_destinataire' => $data['telephone_destinataire'] ?? null,
                'content' => $content,
            ]);
        }

        return redirect()->route('documents.show', $document)->with('success', 'Document créé avec succès.');
    }

    public function show(Document $document)
    {
        $document->load('invoiceItems', 'template');
        return view('documents.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document supprimé.');
    }
}
