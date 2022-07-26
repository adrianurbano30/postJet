<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $fillable=[
        'url',
    ];

    public function likedBy(User $usuario){
        return $this->likes->contains('user_id',$usuario->id);
    }

    public function imageable(){
        return $this->morphTo();
    }

    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }

    public function comentarios(){
        return $this->morphMany(Comentario::class,'comentarioable');
    }
}
