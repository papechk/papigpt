<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->get();
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(StoreTemplateRequest $request)
    {
        $data = $request->validated();
        if (isset($data['variables']) && is_string($data['variables'])) {
            $data['variables'] = json_decode($data['variables'], true);
        }
        Template::create($data);
        return redirect()->route('templates.index')->with('success', 'Template créé avec succès.');
    }

    public function edit(Template $template)
    {
        return view('templates.edit', compact('template'));
    }

    public function update(UpdateTemplateRequest $request, Template $template)
    {
        $data = $request->validated();
        if (isset($data['variables']) && is_string($data['variables'])) {
            $data['variables'] = json_decode($data['variables'], true);
        }
        $template->update($data);
        return redirect()->route('templates.index')->with('success', 'Template mis à jour.');
    }

    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template supprimé.');
    }

    /**
     * API: retourne les variables d'un template en JSON.
     */
    public function variables(Template $template)
    {
        return response()->json([
            'variables' => $template->variables ?? [],
            'content' => $template->content,
            'category' => $template->category,
            'design' => $template->design ?? 'classique',
        ]);
    }
}
