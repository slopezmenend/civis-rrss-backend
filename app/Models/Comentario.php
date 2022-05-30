<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentarios';
    protected $fillable = ['user_id', 'parent_id', 'titulo', 'texto', 'idcivis', 'tipo_civis'];

    public function diputado()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
?>
