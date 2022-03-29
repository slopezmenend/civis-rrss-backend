<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'follows';
    protected $fillable = ['seguido_id', 'seguidor_id'];

    public function seguido()
    {
        return $this->hasOne(User::class, 'id', 'seguido_id');
    }

    public function seguidor()
    {
        return $this->hasOne(User::class, 'id', 'seguidor_id');
    }
}
?>
