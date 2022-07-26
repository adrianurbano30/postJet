<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'comentarios',
        'editado'
    ];

    //relacion a si mismo
    public function parent(){
        return $this->belongsTo(Respuesta::class);
    }

    public function respuestas(){
        return $this->hasMany(Respuesta::class,'parent_id');
    }
    //end relacion a si mismo

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comentarios(){
        return $this->belongsTo(Comentario::class);
    }

}
