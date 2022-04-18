<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NMuro extends Model
{
    use HasFactory;
    protected $table = 'muros';
    protected $fillable = ['usuario_id', 'texto'];

    /*public function diputado()
    {
        return $this->hasMany(Diputado::class);
    }*/

}
?>
