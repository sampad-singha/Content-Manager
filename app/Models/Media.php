<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'path',
        'content_id'

    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
