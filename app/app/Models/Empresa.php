<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'razao_social',
        'fantasia',
        'cnpj',
        'insc_estadual',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone1',
        'telefone2',
        'email',
        'taxa_cheque',
        'taxa_transf',
        'taxa_pix',
        'taxa_adm_cota',
        'lancar_automaticamente',
    ];
}
