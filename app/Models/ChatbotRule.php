<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatbotRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'keyword',
        'response',
        'type',
        'priority',
        'status',
    ];

    protected $casts = [
        'priority' => 'integer',
    ];
}
