<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    //protected static function booted()
    //{
    //    static::created(function ($departamento) {
    //        // Adicionar permissões de colaborador e administrador
    //        $departamento->permissoes()->createMany([
    //            ['nome' => 'colaborador'],
    //            ['nome' => 'administrador'],
    //        ]);
    //    });
    //}
    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class, 'departamento_permissao', 'departamento_id', 'permissao_id');
    }

}
