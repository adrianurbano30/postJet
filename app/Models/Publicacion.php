<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;
    protected $fillable=[
        'body'
    ];

    public function likedBy(User $user){
        return $this->likes->contains('user_id',$user->id);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function imagenes(){
        return $this->morphMany(Imagen::class,'imageable');
    }

    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }
    public function comentarios(){
        return $this->morphMany(Comentario::class,'comentarioable')->whereNull('parent_id');
    }
}
