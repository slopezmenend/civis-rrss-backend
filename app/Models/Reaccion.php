<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaccion extends Model
{
    use HasFactory;
    protected $table = 'reaciones';
    protected $fillable = ['user_id', 'comentario_id', 'tipo'];

    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function commentario()
    {
        return $this->hasOne(Comentario::class, 'id', 'comentario_id');
    }
}
?>
