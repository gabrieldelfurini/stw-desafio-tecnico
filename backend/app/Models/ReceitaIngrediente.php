<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceitaIngrediente extends Model
{
    use HasFactory;
    
    protected $table = 'ingrediente_receita';

    protected $fillable = [
        'receita_id', 
        'ingrediente_id',
        'ordem',
        'quantidade_prevista'
    ];

    public $timestamps = false;
}