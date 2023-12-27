<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $table = "ingredientes";

    protected $fillable = [
        'codigo',
        'descricao'
    ];

    public function receitas()
    {
        return $this->belongsToMany(Receita::class, 'ingrediente_receita')
            ->withPivot('ordem', 'quantidade_prevista')
            ->withTimestamps();
    }
}
