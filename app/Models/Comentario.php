<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'comentarios',
        'editado'
    ];

    public function likedBy(User $usuario){
        return $this->likes->contains('user_id',$usuario->id);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }

    //relacion a si mismo

     public function parent(){
         return $this->belongsTo(Comentario::class);
     }


     public function replies(){
         return $this->hasMany(Comentario::class,'parent_id');
     }
    //end relacion a si mismo

    public function comentarioable(){
        return $this->morphTo();
    }
}
