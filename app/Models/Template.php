<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $fillable = ['name', 'type', 'category', 'design', 'content', 'variables'];

    protected $casts = [
        'variables' => 'array',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Substitue les variables {clé} dans le contenu du template.
     */
    public function render(array $values): string
    {
        $content = $this->content;
        foreach ($values as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }
}
