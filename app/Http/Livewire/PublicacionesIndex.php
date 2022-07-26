<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Imagen;
use App\Models\Comentario;
use App\Models\Respuesta;

class PublicacionesIndex extends Component
{

    use WithFileUploads;

    public $usuario;
    public $imagenes_publicacion=[];
    public $hay_img=false;
    public $body;
    public $btn_add_publicacion=false;

    public $modal_publicaciones=false;

    public $modal_fotos_publicacion=false;
    public $indice_img;
    public $indice_publicacion;

    public $id_upload_images_component;
    public $aux_imgs=0;
    public $rand_img=0;


    //conteo cant likes y comentarios to show
    public $aux_post_likes=0;
    public $aux_post_comentarios=0;

    public $comentario;
    public $comentario_img;
    public $respuesta;
    public $respuesta_respuesta;

    protected $listeners=['render'];

    public function mount(){
        $this->usuario=Auth::user();
        $this->id_upload_images_component=rand();
    }


    protected function rules(){

        return [
            'body' => 'nullable|max:5000',
            'imagenes_publicacion.*' => 'nullable|image|max:8192',
        ];

    }

    protected $messages = [
        'imagenes_publicacion.image' => 'El o los archivos de publicacion deben ser una imagen.',
        'imagenes_publicacion.max' => 'La imagen debe tener un maximo de 8 megabytes.',
        'body.max' => 'La cantidad maxima de caracteres para la publicacion es 1000.',
    ];

    protected $validationAttributes = [
        'body' => 'texto de publicación',
        'imagenes_publicacion.*' => 'imagenes de publicacion',
    ];

    public function publicar(){


        $this->validate();

        if ($this->body || $this->imagenes_publicacion) {


                $publicacion = $this->usuario->publicaciones()->create([
                    'body'=>$this->body,
                ]);

                if ($this->imagenes_publicacion) {

                    $img_publicacion_path='imagenes/publicaciones/';

                    foreach ($this->imagenes_publicacion as $imagen ) {

                        $img_publicacion_unica=time().'-'.$imagen->getClientOriginalName();

                        $imagen->storeAs($img_publicacion_path,$img_publicacion_unica,'subidas_publicas');

                        $img_publicacion_a_guardar = $img_publicacion_path.$img_publicacion_unica;

                        $publicacion->imagenes()->create([
                            'url'=>$img_publicacion_a_guardar,
                            'estado'=>false
                        ]);

                    }
                }
                $this->reset('imagenes_publicacion','hay_img','body','btn_add_publicacion','modal_publicaciones');
                $this->id_upload_images_component=rand();



        }

    }

    public function like(Publicacion $publicacion){

        if (!$publicacion->likedBy($this->usuario)) {

            $publicacion->likes()->create([
                'user_id'=>$this->usuario->id,
            ]);

        }else{
            $publicacion->likes()
            ->where('user_id',$this->usuario->id)
            ->delete();
        }
    }

    public function like_comentario_publicacion(Comentario $comentario){

             if (!$comentario->likedBy($this->usuario)) {

                 $comentario->likes()->create([
                     'user_id'=>$this->usuario->id,
                 ]);

             }else{
                 $comentario->likes()
                 ->where('user_id',$this->usuario->id)
                 ->delete();
             }
    }

    public function like_comentario_imagen(Comentario $comentario){

             if (!$comentario->likedBy($this->usuario)) {

                 $comentario->likes()->create([
                     'user_id'=>$this->usuario->id,
                 ]);
             }else{
                 $comentario->likes()
                  ->where('user_id',$this->usuario->id)
                  ->delete();
              }
    }

    public function like_img(Imagen $imagen){

        if (!$imagen->likedBy($this->usuario)) {

            $imagen->likes()->create([
                'user_id'=>$this->usuario->id,
            ]);
            $this->render();
        }else{
            $imagen->likes()
            ->where('user_id',$this->usuario->id)
            ->delete();
            $this->render();
        }

    }

    public function like_respuestas(Comentario $comentario){

        if (!$comentario->likedBy($this->usuario)) {

            $comentario->likes()->create([
                'user_id'=>$this->usuario->id,
            ]);

        }else{
            $comentario->likes()
            ->where('user_id',$this->usuario->id)
            ->delete();
        }
    }

    public function comentar(Publicacion $publicacion){

        if ($this->comentario) {
         $publicacion->comentarios()->create([
             'user_id'=>$this->usuario->id,
             'comentarios'=>$this->comentario,
             'editado'=>false
         ]);
         $this->reset('comentario');
         }
    }

    public function comentar_img(Imagen $imagen){

        if ($this->comentario_img) {
            $imagen->comentarios()->create([
                'user_id'=>$this->usuario->id,
                'comentarios'=>$this->comentario_img,
                'editado'=>false
            ]);
            $this->render();
            $this->reset('comentario_img');
        }

    }


    public function responder_comentario_publicacion(Comentario $comentario){

          if($this->respuesta){

              $comentario->replies()->create([
                  'user_id'=>$this->usuario->id,
                  'comentarios'=>$this->respuesta,
                  'editado'=>false
              ]);

                $this->reset('respuesta');

          }

    }
    public function responder_respuesta(Comentario $comentario){

            //dd($comentario);
            if($this->respuesta_respuesta){

                $comentario->replies()->create([
                    'user_id'=>$this->usuario->id,
                    'comentarios'=>$this->respuesta_respuesta,
                    'editado'=>false
                ]);

                  $this->reset('respuesta_respuesta');

            }
    }

    public function mostrar_modal_publicaciones(){
        $this->modal_publicaciones = true;
    }

    public function mostrar_modal_fotos_publicacion($index,Publicacion $publicacion){

        $this->render();
        $this->indice_img=$index;
        $this->indice_publicacion = $publicacion;
        $this->modal_fotos_publicacion=true;

    }

    public function adelante(){
        $this->indice_img++;
    }

    public function atras(){
        $this->indice_img--;
    }

    public function cerrar_modal_imagenes(){
        $this->modal_fotos_publicacion=false;
    }

    public function sonfotos(){

        if($this->imagenes_publicacion){

            foreach($this->imagenes_publicacion as $imgss){

                if(substr($imgss->getMimeType(),0,5)=='image'){
                    $this->btn_add_publicacion=true;
                    return true;
                }else{
                    $this->btn_add_publicacion=false;
                    return false;
                }

            }
        }

    }

    public function removeMe($index){
        array_splice($this->imagenes_publicacion, $index, 1);
        if(count($this->imagenes_publicacion)==0){
            if($this->body){
            $this->btn_add_publicacion=true;
            //$this->hay_img=false;
            }else{
                $this->btn_add_publicacion=false;
            }
            $this->hay_img=false;
        }
    }

    public function cant_imagenes_temporales(){

        return  count($this->imagenes_publicacion);
    }

    public function cant_imagenes($imagen){

        return  count($imagen);
    }

    public function añadir_emoji($value){

        if ($value) {
            $this->body = $this->body.$value;
            $this->btn_add_publicacion=true;
        }


    }

    public function cantidad_caracteres($texto){
        return strlen($texto);
    }

    public function render()
    {
        return view('livewire.publicaciones-index',[
            'publicaciones'=> Publicacion::select('*')->orderBy('created_at','desc')->get()
        ])
        ->layout(\App\View\Components\AppLayout::class)
        ->slot('slot');
    }
}
