<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacypolicy extends Model
{
    use HasFactory;

    protected $table = 'privacypolicys';

    protected $fillable = [
        'privacy',
        'policy'
    ];
}
