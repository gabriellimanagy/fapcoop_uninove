<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;
    protected $table = 'permissoes';
    protected $fillable = ['nome'];

    // Remova este método ou comente-o
    // public function departamento()
    // {
    //     return $this->belongsTo(Departamento::class);
    // }

    public function departamentos()
    {
        return $this->belongsToMany(Departamento::class, 'departamento_permissao');
    }
}
