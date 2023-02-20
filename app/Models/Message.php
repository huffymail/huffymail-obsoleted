<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected array $columns = [
        'id',
        'message_id',
        'from',
        'to',
        'spam_verdict',
        'virus_verdict',
        'subject',
        'html',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'message_id',
        'from',
        'to',
        'spam_verdict',
        'virus_verdict',
        'subject',
        'html',
    ];

    public function scopeExclude(Builder $query, array $columns = []): void
    {
        $query->select(array_diff($this->columns, $columns));
    }
}
