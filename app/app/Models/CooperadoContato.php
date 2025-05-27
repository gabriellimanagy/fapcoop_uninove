<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperadoContato extends Model
{
    use HasFactory;

    protected $fillable = [
        'cooperado_id', 'celular', 'whatsapp', 'telefone1', 'telefone2', 'email', 'cep', 'endereco', 'zona', 'bairro', 'cidade', 'uf'
    ];

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class);
    }
}
