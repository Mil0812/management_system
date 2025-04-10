<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasUlids, HasFactory;
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['description', 'amount', 'month', 'year',];

    protected $casts = [
        'amount' => 'decimal:2',
        'month' => 'string',
        'year' => 'integer',
    ];
}
