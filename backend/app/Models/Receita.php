<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receita extends Model
{
    use HasFactory;

    protected $table = "receitas"; 

    protected $fillable = [
        'codigo',
        'descricao'
    ];

    public function ingredientes(){
        $this->belongsToMany('App\Models\Ingrediente');
    }
}
