<div x-data="publicaciones_index" class="flex items-center justify-center mt-20 ">

    <div class="grid grid-cols-1 lg:w-1/2  2xl:w-1/3 xl:w-1/3 xl:h-auto 2xl:h-auto sm:mx-4 md:mx-1 pb-4  rounded-xl">

        <div class="w-full flex items-center">
            <img class="w-10 h-10 object-cover rounded-full mr-1" src="{{$usuario->profile_img}}">
            <input wire:click="mostrar_modal_publicaciones()"  type="text"  class="w-full  font-serif text-xl text-black placeholder-gray-500 transition duration-500 shadow-inner cursor-pointer sm:text-sm hover:bg-gray-200 rounded-2xl focus:no-underline focus:outline-none" placeholder="Que tienes en mente {{$usuario->name}} ?" readonly="true" >
        </div>

        {{--PUBLICACIONES--}}

        @foreach ($publicaciones as $publicacion)

        <div x-data="{
                        comentarios_lista:false,
                        leer_mas: true,
                        leer_todo:false,
                        like:false,
                        peopleliked:false,
                        peoplecoment:false,
                        sileetodo() {
                            if (this.leer_mas) {
                            this.leer_mas=false;
                            this.leer_todo=true;
                            }
                        },
                        sileemenos(){
                            if (this.leer_todo) {
                                this.leer_todo=false;
                                this.leer_mas=true;
                            }
                        }
                     }"
            class="flex items-center justify-center  mb-4 mt-4 rounded-lg bg-gray-50 text-gray-900 border-2 border-white shadow-white shadow-md">
            <div class="grid grid-cols-1 w-full border-2 rounded-xl border-gray-100">

              {{--top of the post--}}

              <div class="flex items-center justify-between border-b-2 border-gray-200 mx-1">
                  <div class="flex items-center">
                        <div class="flex-shrink-0 mr-1">
                            <img class="w-11 h-11 rounded-full object-cover" src="{{$publicacion->user->profile_img}}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate dark:text-white">
                                {{$publicacion->user->name}} {{$publicacion->user->lastname}}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400 inline-flex items-center">
                                {{$publicacion->created_at->diffforhumans()}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </p>
                        </div>
                  </div>

                  <div class="flex items-center justify-center">
                    <i class="fa-solid fa-ellipsis"></i>
                  </div>
              </div>

              {{--ENDtop of the post--}}

              {{--body of the post--}}

              <div>
                  <p class="text-justify text-lg p-2">
                    @if ($this->cantidad_caracteres($publicacion->body)>=200)
                    <span x-cloak
                         x-show="leer_mas">
                       {{Str::limit($publicacion->body,200)}}
                    </span>
                    <span x-cloak
                         x-show="leer_mas"
                         @click="sileetodo"
                         class="font-extrabold text-black cursor-pointer hover:text-gray-500 transition duration-500">
                         Leer mas
                    </span>
                    <span x-cloak
                         x-show="leer_todo">
                         {{$publicacion->body}}
                    </span>
                    <span @click="sileemenos"
                         x-cloak
                         x-show="leer_todo"
                         class="font-extrabold text-black cursor-pointer hover:text-gray-500 transition duration-500">
                         Leer menos
                    </span>
                    @else
                    {{$publicacion->body}}
                    @endif
                  </p>

              </div>

              {{--END body of the post--}}

              {{--Imagen del post--}}
              @if ($publicacion->imagenes)
              <div class="flex items-center justify-center h-auto">

                @if ($this->cant_imagenes($publicacion->imagenes)==1)
                <div class="grid grid-cols-1">
                    @foreach ($publicacion->imagenes as $img)
                            <div class="">
                               <img wire:click="mostrar_modal_fotos_publicacion({{$loop->index}},{{$publicacion}})" class="w-full h-full object-cover cursor-pointer" src="{{$img->url}}">
                            </div>
                    @endforeach
                </div>
                @endif

                @if ($this->cant_imagenes($publicacion->imagenes)==2)
                <div class="grid grid-cols-2 gap-1">
                    @foreach ($publicacion->imagenes as $img)
                            <div class="">
                              <img  wire:click="mostrar_modal_fotos_publicacion({{$loop->index}},{{$publicacion}})" class="w-full h-full object-cover cursor-pointer" src="{{$img->url}}">
                            </div>
                    @endforeach
                </div>
                @endif

                @if ($this->cant_imagenes($publicacion->imagenes)==3)
                <div class="grid grid-cols-2 gap-1">
                        {{-- {{ $this->reset(['aux_imgs','rand_img']) }} --}}
                        {{ $this->reset(['aux_imgs']) }}
                        {{-- <span class="hidden">{{$this->rand_img=random_int(0,1)}}</span> --}}
                        @foreach ($publicacion->imagenes as $img)
                            <div class="{{$this->aux_imgs==0 ? 'row-span-2 h-96':'h-48'}}">
                              <img wire:click="mostrar_modal_fotos_publicacion({{$loop->index}},{{$publicacion}})" class="w-full h-full object-cover cursor-pointer" src="{{$img->url}}">
                            </div>
                            <span class="hidden">{{$this->aux_imgs++}} </span>
                        @endforeach
                </div>
                @endif

                @if ($this->cant_imagenes($publicacion->imagenes)==4)
                <div class="grid grid-cols-2 gap-1">
                      {{-- {{ $this->reset(['aux_imgs','rand_img']) }}
                      <span class="hidden">{{$this->rand_img=random_int(0,1)}}</span> --}}
                      {{ $this->reset(['aux_imgs']) }}
                      @foreach ($publicacion->imagenes as $img)
                            <div class="{{$this->aux_imgs==0 ? 'row-span-3 h-96':'h-32'}}">
                               <img wire:click="mostrar_modal_fotos_publicacion({{$loop->index}},{{$publicacion}})" class="w-full h-full object-cover cursor-pointer" src="{{$img->url}}">
                            </div>
                            <span class="hidden">{{$this->aux_imgs++}} </span>
                      @endforeach
                </div>
                @endif

                @if ($this->cant_imagenes($publicacion->imagenes)>=5)
                <div class="grid grid-cols-2 gap-1">
                    {{-- {{ $this->reset(['aux_imgs','rand_img']) }}
                    <span class="hidden">{{$this->rand_img=random_int(0,1)}}</span> --}}
                    {{ $this->reset(['aux_imgs']) }}
                    @foreach ($publicacion->imagenes as $img)
                            <div class="{{$this->aux_imgs==0 ? 'row-span-3 h-96':'h-32'}} relative">
                                <img wire:click="mostrar_modal_fotos_publicacion({{$loop->index}},{{$publicacion}})" class="w-full h-full object-cover cursor-pointer" src="{{$img->url}}">
                                @if ($this->aux_imgs==3)
                                <p style="top: 50%;right:50%;user-select: none" class="font-extrabold text-3xl hover:  absolute  flex items-center justify-center text-center  text-white ">
                                    + {{$this->cant_imagenes($publicacion->imagenes)-4}}
                                </p>
                                @endif
                            </div>
                        <span class="hidden">{{$this->aux_imgs++}} </span>
                        @if ($this->aux_imgs==4)
                            @break
                        @endif
                    @endforeach
                </div>
                @endif


              </div>
              @endif
              {{--END Imagen del post--}}

              {{--BOTTOM DEL POST--}}

              <div class="flex items-center justify-between px-2 my-3 border-b-2 border-gray-300 pb-1">
                  {{--LIKES--}}
                  <div class="flex items-center">
                    <div class="relative">
                        <i wire:click="like({{$publicacion}})" @mouseover="like=true" @mouseout="like=false" class="fa-solid fa-thumbs-up  text-sm {{$publicacion->likedBy($this->usuario)?'text-blue-600 font-bold':'text-gray-400 font-bold'}} cursor-pointer transition duration-700"></i>
                        @if ($publicacion->likedBy($this->usuario))
                        <div
                            x-show="like"
                            x-cloak
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-700"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="user-select: none"
                            class="absolute z-50 w-96 flex-shrink-0 text-left -left-1 -top-4 font-extrabold text-gray-800 text-xs">
                            ya no me gusta
                        </div>
                        @else
                        <div
                            x-show="like"
                            x-cloak
                            x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-700"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="user-select: none"
                            class="absolute z-50 w-96 flex-shrink-0 text-left -left-1 -top-4 font-extrabold text-gray-800 text-xs">
                            me gusta
                        </div>
                        @endif
                    </div>
                    @if ($publicacion->likes->count()>0)
                    <div class="relative">
                        <p style="user-select: none" @mouseover="peopleliked=true" @mouseout="peopleliked=false" class="text-left text-sm font-bold text-gray-400 ml-1">{{$publicacion->likes->count()}}</p>
                        <div
                            x-show="peopleliked"
                            x-cloak
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="user-select: none"
                            class="absolute top-0 text-xs w-52 flex items-center text-left p-2 left-7 bg-gray-900 rounded-xl opacity-75 text-white">
                            <ul class="text-justify">
                             {{$this->reset('aux_post_likes')}}
                            @foreach ($publicacion->likes()->select('*')->orderBy('id','desc')->get() as $publicacion_l)
                                <li><span class="font-extrabold">{{$publicacion_l->user->id == $this->usuario->id ? 'TÚ:':''}}</span> {{$publicacion_l->user->name}} {{$publicacion_l->user->lastname}}</li>
                                <span class="hidden">{{$this->aux_post_likes++}}</span>
                                @if ($this->aux_post_likes==10)
                                <li>mas {{($publicacion->likes->count()-10)}} personas</li>
                                    @break
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                  </div>
                  {{--END LIKES--}}

                  {{--COMENTARIOS--}}
                  <div class="flex items-center">

                    @if ($publicacion->comentarios->count()>0)
                    <div class="relative text-black text-center mr-1">
                        <p style="user-select: none" @mouseover="peoplecoment=true" @mouseout="peoplecoment=false" class="text-left text-sm font-bold text-gray-400 ml-1">  {{$publicacion->comentarios->count()}}</p>
                        <div
                            x-show="peoplecoment"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="user-select: none"
                            class="absolute top-0 text-xs z-50 w-52 flex items-center text-left p-2 left-7 bg-gray-900 rounded-xl opacity-75 text-white">
                            <ul class="text-justify">
                            {{$this->reset('aux_post_comentarios')}}
                            {{--!!!PROBLEMA 1 AQUI--}}
                            @foreach ($publicacion->comentarios()->distinct()->get('user_id') as $publicacion_c)
                                     <li><span>{{$publicacion_c->user->id==$this->usuario->id?'Tu:':''}} </span>{{$publicacion_c->user->name}} {{$publicacion_c->user->lastname}}</li>
                                     <span class="hidden">{{$this->aux_post_comentarios++}}</span>
                                     @if ($this->aux_post_comentarios==10)
                                     <li>mas {{($publicacion->comentarios()->count()-10)}} personas</li>
                                         @break
                                     @endif
                            @endforeach
                            {{--!!!END PROBLEMA 1 AQUI--}}
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div @click="comentarios_lista=!comentarios_lista" class="relative">
                        <i class="fa-solid fa-message text-gray-400 cursor-pointer"></i>
                    </div>
                  </div>
                  {{--END COMENTARIOS--}}
              </div>
              {{--LISTA COMENTARIOS--}}
              <div x-cloak x-show="comentarios_lista" class="w-full  my-1">
                     <div class="w-full flex items-center mb-1">
                         <img class="w-9 h-9 object-cover rounded-full mr-1" src="{{$usuario->profile_img}}">
                         <input wire:keydown.enter="comentar({{$publicacion}})" wire:model="comentario"  type="text"  class="w-full  font-serif text-base text-black placeholder-gray-500 transition duration-500 shadow-inner sm:text-sm  rounded-2xl focus:no-underline focus:outline-none" placeholder="Escribe aqui tus comentarios...">
                     </div>
                     <div class="overflow-y-auto{{$publicacion->comentarios->count()>10 ? ' h-96':''}}">
                     @foreach ($publicacion->comentarios()->orderBy('created_at','DESC')->get() as $publicacion_coments)
                     <div x-data="{respuesta:false,
                                   cant_respuestas:false
                                   }"

                                   >
                        <div class="flex my-2 ml-4">
                            <img class="flex self-start w-9 h-9 object-cover rounded-full mr-1" src="{{$publicacion_coments->user->profile_img}}">
                            <div class="bg-gray-200 rounded-xl py-2 px-1">
                                <span class="text-black font-bold text-sm">@auth{{$publicacion_coments->user->id==$this->usuario->id ?'TU:':'' }}@endauth{{$publicacion_coments->user->name}} {{$publicacion_coments->user->lastname}}</span>
                                <p class="text-justify text-sm">{{$publicacion_coments->comentarios}}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-around w-1/2 text-xs ml-10">

                            {{--LIKE COMENTARIO PUBLICACION--}}
                            <div><i wire:click="like_comentario_publicacion({{$publicacion_coments}})"  class="fa-solid fa-thumbs-up  text-sm {{$publicacion_coments->likedBy($this->usuario)?'text-blue-600 font-bold':'text-gray-400 font-bold'}}  cursor-pointer transition duration-700"></i>
                                <span class="text-sm font-bold text-gray-400">{{$publicacion_coments->likes->count()>0 ? $publicacion_coments->likes->count() : ''}} </span>
                            </div>
                            {{--END LIKE COMENTARIO PUBLICACION--}}

                            {{--RESPONDER COMENTARIOS--}}
                            <div class="cursor-pointer flex items-center relative">
                                <span  @click="respuesta=!respuesta">responder <span @mouseover="cant_respuestas=true" @mouseout="cant_respuestas=false" class="text-blue-500 font-extrabold">{{$publicacion_coments->replies->count()>0 ? $publicacion_coments->replies->count():''}}</span> </span>
                                <div
                                    x-show="cant_respuestas"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-700"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-700"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="user-select: none"
                                    class="absolute -top-8 transition duration-700 text-xs z-50 w-52 flex items-center text-left p-2 left-7 bg-gray-900 rounded-xl opacity-75 text-white">
                                    {{$publicacion_coments->replies->count()}} {{$publicacion_coments->replies->count()>1?'respuestas':'respuesta'}}
                                </div>
                            </div>
                            {{--END RESPONDER COMENTARIOS--}}

                            {{--FECHA COMENTARIO--}}
                            <div>{{$publicacion_coments->created_at->diffforhumans()}}</div>
                            {{--END FECHA COMENTARIO--}}
                        </div>

                        {{--LISTA RESPUESTAS--}}
                        <div
                            x-cloack
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            x-show="respuesta"
                            class="w-1/2 ml-12 border-l-2 border-b-2  rounded-md border-gray-400 pl-2">
                            {{--INPUT DE RESPUESTA AL COMENTARIO DE LA PUBLICACION--}}
                            <div class="w-full flex items-center my-2">
                                <img class="w-6 h-6 object-cover rounded-full mr-1" src="{{$usuario->profile_img}}">
                                <input wire:keydown.enter="responder_comentario_publicacion({{$publicacion_coments}})" autofocus wire:model="respuesta"  type="text"  class="w-full  font-serif text-base text-black placeholder-gray-500 transition duration-500 shadow-inner sm:text-sm  rounded-2xl focus:no-underline focus:outline-none" placeholder="Responde el comentario a {{$publicacion_coments->user->name}}">
                            </div>

                            {{--END INPUT DE RESPUESTA AL COMENTARIO DE LA PUBLICACION--}}
                            {{--LISTA DE RESPUESTAS A UN COMENTARIO--}}
                            <div class="">
                                @foreach ($publicacion_coments->replies()->orderBy('created_at','desc')->get() as $respuestas)
                                <div
                                    x-data="{respuesta_2:false,
                                            cant_respuestas_2:false,
                                            }"
                                    class="ml-4"
                                    >
                                    <div class="flex my-2 ml-4">
                                        <img class="flex self-start w-5 h-5 object-cover rounded-full mr-1" src="{{$respuestas->user->profile_img}}">
                                        <div class="bg-gray-200 rounded-xl py-2 px-1">
                                            <span class="text-black font-bold text-xs">@auth{{$respuestas->user->id==$this->usuario->id ?'TU:':'' }}@endauth{{$respuestas->user->name}} {{$respuestas->user->lastname}}</span>
                                            <p class="text-justify text-xs">{{$respuestas->comentarios}}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-around w-full text-xs ml-10">
                                         {{--like segundas respuesta--}}
                                         <div>
                                            <i  wire:click="like_respuestas({{$respuestas}})"  {{--@mouseover="like=true" @mouseout="like=false"--}} class="fa-solid fa-thumbs-up  text-sm {{$respuestas->likedBy($this->usuario)?'text-blue-600 font-bold':'text-gray-400 font-bold'}} cursor-pointer transition duration-700"></i>
                                            <span class="text-sm font-bold text-gray-400">{{$respuestas->likes->count()>0 ? $respuestas->likes->count() : ''}} </span>
                                         </div>
                                         {{--end like segundas respuesta--}}

                                         {{--resp segundas respuestas--}}
                                         <div class="cursor-pointer flex items-center relative">
                                            <span  @click="respuesta_2=!respuesta_2">resp <span @mouseover="cant_respuestas_2=true" @mouseout="cant_respuestas_2=false" class="text-blue-500 font-extrabold">{{$respuestas->replies->count()>0 ? $respuestas->replies->count():''}}</span></span>
                                            <div
                                                x-show="cant_respuestas_2"
                                                x-cloak
                                                x-transition:enter="transition ease-out duration-500"
                                                x-transition:enter-start="transform opacity-0 scale-95"
                                                x-transition:enter-end="transform opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-500"
                                                x-transition:leave-start="transform opacity-100 scale-100"
                                                x-transition:leave-end="transform opacity-0 scale-95"
                                                style="user-select: none"
                                                class="absolute -top-8 transition duration-700 text-xs z-50 w-52 flex items-center text-left p-2 left-7 bg-gray-900 rounded-xl opacity-75 text-white">
                                                {{$respuestas->replies->count()}} {{$respuestas->replies->count()>1?'respuestas':'respuesta'}}
                                            </div>
                                         </div>
                                         {{--end resp segundas respuestas--}}
                                         {{--tiempo seg respuestas--}}
                                         <div>{{$respuestas->created_at->diffforhumans()}} </div>
                                         {{--end tiempo seg respuestas--}}
                                    </div>
                                    <div
                                        x-cloack
                                        x-show="respuesta_2"
                                        class="ml-12 border-l-2 border-b-2  rounded-md border-gray-400 pl-2"
                                        >
                                        {{--INPUT DE RESPUESTA A LA RESPUESTA--}}
                                        <div class="w-full flex items-center my-2">
                                            <img class="w-5 h-5 object-cover rounded-full mr-1" src="{{$usuario->profile_img}}">
                                            <input wire:keydown.enter="responder_respuesta({{$respuestas}})" autofocus wire:model="respuesta_respuesta"  type="text"  class="w-full  font-serif text-base text-black placeholder-gray-500 transition duration-500 shadow-inner sm:text-sm  rounded-2xl focus:no-underline focus:outline-none" placeholder="Responde el comentario a {{$respuestas->user->name}}">
                                        </div>
                                        {{--END INPUT DE RESPUESTA A LA RESPUESTA--}}
                                        <div>
                                            @foreach ($respuestas->replies()->orderBy('created_at','desc')->get() as $respuestas)
                                            <div>
                                                <div class="flex my-2 ml-5">
                                                    <img class="flex self-start w-5 h-5 object-cover rounded-full mr-1" src="{{$respuestas->user->profile_img}}">
                                                    <div class="bg-gray-200 rounded-xl py-2 px-1">
                                                        <span class="text-black font-bold text-xs">@auth{{$respuestas->user->id==$this->usuario->id ?'TU:':'' }}@endauth{{$respuestas->user->name}} {{$respuestas->user->lastname}}</span>
                                                        <p class="text-justify text-xs">{{$respuestas->comentarios}}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-around w-full text-xs ml-10">
                                                    <div>like</div>
                                                    <div>resp</div>
                                                    <div>{{$respuestas->created_at->diffforhumans()}}</div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                                @endforeach
                            </div>
                            {{--END LISTA DE RESPUESTAS A UN COMENTARIO--}}
                        </div>
                        {{--END LISTA RESPUESTAS--}}

                     </div>
                     @endforeach
                     </div>
              </div>
              {{--END LISTA COMENTARIOS--}}

              {{--END BOTTOM DEL POST--}}
            </div>

        </div>

        @endforeach

        {{--ENDPUBLICACIONES--}}

    </div>

{{--MODAL--}}
<x-modal wire:model="modal_publicaciones" class="relative">

    <div class="flex items-center justify-center">

        <div wire:click="$toggle('modal_publicaciones')" class="z-10 absolute py-1 px-3 text-xl font-extrabold bg-gray-300 border-2 border-gray-300 rounded-full cursor-pointer top-1 right-1">
            <i class="fa-solid fa-xmark"></i>
        </div>

        <div class="grid grid-cols-1 mx-2 gap-2 w-full">

            <div class="border-b-2 border-gray-300">
                <h2 class="text-2xl font-bold text-center mt-2">PUBLICA</h2>
            </div>


            <div class="ml-1 flex place-items-start justify-start">
                <img class="w-10 h-10 rounded-full object-cover" src="{{$usuario->profile_img}}">
                <span class="text-gray-700 self-end font-extrabold"> {{$usuario->name}} {{$usuario->lastname}} </span>
            </div>
            {{--EL BODY DE LA PUBLICACION--}}
            <div class="w-full flex items-center justify-center mb-1">
              <div class="grid grid-cols-1 w-full overflow-y-auto h-64">
                <div class="w-full">
                         <textarea cols="30"
                          autofocus
                          rows="7"
                          name="body"
                          wire:model="body"
                          @input="redimensionar(event)"
                          @change="redimensionar(event)"
                          class="auto w-full px-2 py-1 text-xl text-justify placeholder-gray-600 transition duration-500 rounded-lg shadow-inner resize-none ta_p focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent desplazamiento_scroll"
                          placeholder="que tienes en mente {{$usuario->name}} ?"></textarea>
                </div>

                @if ($this->sonfotos())
                  <div class="flex items-center justify-center">
                   @if($this->cant_imagenes_temporales($this->imagenes_publicacion)==1)
                    <div class="grid w-full grid-cols-1">
                        @foreach($this->imagenes_publicacion as $imagenes)
                        <div class="relative flex justify-end">  {{--wire:key="{{$loop->index}}"--}}
                        <img class="object-cover w-full rounded h-72"  src="{{$imagenes->temporaryUrl()}}">
                            <button wire:click="removeMe({{$loop->index}})" class="absolute focus:outline-none" title="quitar imagen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black bg-gray-200 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                   @endif

                   @if($this->cant_imagenes_temporales($this->imagenes_publicacion)==2)
                     <div class="grid w-full grid-cols-2 gap-1">
                       @foreach($this->imagenes_publicacion as $imagenes)
                       <div class="relative flex justify-end">  {{--wire:key="{{$loop->index}}"--}}
                       <img class="object-cover w-52 rounded h-auto"  src="{{ $imagenes->temporaryUrl()}}">
                           <button wire:click="removeMe({{$loop->index}})" class="absolute focus:outline-none" title="quitar imagen">
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black bg-gray-200 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                               </svg>
                           </button>
                       </div>
                       @endforeach
                     </div>
                    @endif

                    @if($this->cant_imagenes_temporales($this->imagenes_publicacion)==3)
                     <div class="grid w-full grid-cols-3 gap-1">
                       @foreach($this->imagenes_publicacion as $imagenes)
                       <div class="relative flex justify-end">  {{--wire:key="{{$loop->index}}"--}}
                       <img class="object-cover w-32 rounded h-auto"  src="{{ $imagenes->temporaryUrl()}}">
                           <button wire:click="removeMe({{$loop->index}})" class="absolute focus:outline-none" title="quitar imagen">
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black bg-gray-200 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                               </svg>
                           </button>
                       </div>
                       @endforeach
                     </div>
                    @endif

                    @if($this->cant_imagenes_temporales($this->imagenes_publicacion)>=4)
                     <div class="grid w-full grid-cols-4 gap-1">
                       @foreach($this->imagenes_publicacion as $imagenes)
                       <div class="relative flex justify-end">  {{--wire:key="{{$loop->index}}"--}}
                       <img class="object-cover w-auto rounded h-auto"  src="{{ $imagenes->temporaryUrl()}}">
                           <button wire:click="removeMe({{$loop->index}})" class="absolute focus:outline-none" title="quitar imagen">
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black bg-gray-200 rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                   <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                               </svg>
                           </button>
                       </div>
                       @endforeach
                     </div>
                    @endif


                  </div>
                @endif

              </div>
            </div>
            {{--END EL BODY DE LA PUBLICACION--}}

            <div class="w-full flex items-stretch justify-around border-2 rounded-lg mb-1">
              <div class="grid grid-cols-2">
                <span>Agregar a la publicación</span>

                <div class="flex items-end justify-end ">
                    {{--SUBIR IMAGENES--}}
                    <label class="flex flex-col items-center tracking-wide text-blue-400 uppercase transition duration-500 rounded-lg cursor-pointer w-15 hover:text-green-200 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <input
                               id="{{$this->id_upload_images_component}}"
                               @change="imagenes(event)"
                               name="imagenes_publicacion"
                               wire:model="imagenes_publicacion"
                               type='file'
                               title="Sube una imagen"
                               accept="image/*"
                               class="hidden"
                               multiple="true"/>
                    </label>
                    {{--END SUBIR IMAGENES--}}

                    {{--EMOJIS--}}
                    <div class="relative">
                        <svg @click="emojis=!emojis" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    <div x-show="emojis"
                        @click.away="emojis=false"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute bg-white rounded-md bottom-5 right-2 h-72 w-72 ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <!-- Active: "bg-gray-100", Not Active: "" -->

                        <div class="flex items-center justify-center transition duration-500">
                            <div class="grid w-full grid-cols-7 gap-1 p-5 overflow-auto overflow-x-hidden desplazamiento_scroll h-72 ">
                                                    <div class="col-span-7">
                                                     <a name="sonrisas_y_personas" class="transition duration-500">
                                                     <h3 class="px-2 mx-2 my-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Sonrisas y personas
                                                     </h3>
                                                     </a>
                                                    </div>
                                                    <div  wire:click="añadir_emoji('😀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50">😀</div>
                                                    <div wire:click="añadir_emoji('😃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😃</div>
                                                    <div wire:click="añadir_emoji('😄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😄</div>
                                                    <div wire:click="añadir_emoji('😁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😁</div>
                                                    <div wire:click="añadir_emoji('😆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😆</div>
                                                    <div wire:click="añadir_emoji('😅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😅</div>
                                                    <div wire:click="añadir_emoji('😂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😂</div>
                                                    <div wire:click="añadir_emoji('🤣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤣</div>
                                                    <div wire:click="añadir_emoji('😇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😇</div>
                                                    <div wire:click="añadir_emoji('😉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😉</div>
                                                    <div wire:click="añadir_emoji('😊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😊</div>
                                                    <div wire:click="añadir_emoji('🙂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙂</div>
                                                    <div wire:click="añadir_emoji('🙃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙃</div>
                                                    <div wire:click="añadir_emoji('😋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😋</div>
                                                    <div wire:click="añadir_emoji('😌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😌</div>
                                                    <div wire:click="añadir_emoji('😍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😍</div>
                                                    <div wire:click="añadir_emoji('🥰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥰</div>
                                                    <div wire:click="añadir_emoji('😘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😘</div>
                                                    <div wire:click="añadir_emoji('😗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😗</div>
                                                    <div wire:click="añadir_emoji('😙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😙</div>
                                                    <div wire:click="añadir_emoji('😚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😚</div>
                                                    <div wire:click="añadir_emoji('🤪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤪</div>
                                                    <div wire:click="añadir_emoji('😜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😜</div>
                                                    <div wire:click="añadir_emoji('😝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😝</div>
                                                    <div wire:click="añadir_emoji('😛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😛</div>
                                                    <div wire:click="añadir_emoji('🤑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤑</div>
                                                    <div wire:click="añadir_emoji('😎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😎</div>
                                                    <div wire:click="añadir_emoji('🤓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤓</div>
                                                    <div wire:click="añadir_emoji('🧐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧐</div>
                                                    <div wire:click="añadir_emoji('🤠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤠</div>
                                                    <div wire:click="añadir_emoji('🥳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥳</div>
                                                    <div wire:click="añadir_emoji('🤗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤗</div>
                                                    <div wire:click="añadir_emoji('🤡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤡</div>
                                                    <div wire:click="añadir_emoji('😏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😏</div>
                                                    <div wire:click="añadir_emoji('😶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😶</div>
                                                    <div wire:click="añadir_emoji('😐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😐</div>
                                                    <div wire:click="añadir_emoji('😑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😑</div>
                                                    <div wire:click="añadir_emoji('😒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😒</div>
                                                    <div wire:click="añadir_emoji('🙄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙄</div>
                                                    <div wire:click="añadir_emoji('🤨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤨</div>
                                                    <div wire:click="añadir_emoji('🤔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤔</div>
                                                    <div wire:click="añadir_emoji('🤫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤫</div>
                                                    <div wire:click="añadir_emoji('🤭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤭</div>
                                                    <div wire:click="añadir_emoji('🤥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤥</div>
                                                    <div wire:click="añadir_emoji('😳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😳</div>
                                                    <div wire:click="añadir_emoji('😞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😞</div>
                                                    <div wire:click="añadir_emoji('😟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😟</div>
                                                    <div wire:click="añadir_emoji('😠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😠</div>
                                                    <div wire:click="añadir_emoji('😡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😡</div>
                                                    <div wire:click="añadir_emoji('🤬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤬</div>
                                                    <div wire:click="añadir_emoji('😔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😔</div>
                                                    <div wire:click="añadir_emoji('😕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😕</div>
                                                    <div wire:click="añadir_emoji('🙁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙁</div>
                                                    <div wire:click="añadir_emoji('☹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☹</div>
                                                    <div wire:click="añadir_emoji('😬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😬</div>
                                                    <div wire:click="añadir_emoji('🥺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥺</div>
                                                    <div wire:click="añadir_emoji('😣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😣</div>
                                                    <div wire:click="añadir_emoji('😖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😖</div>
                                                    <div wire:click="añadir_emoji('😫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😫</div>
                                                    <div wire:click="añadir_emoji('🥱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥱</div>
                                                    <div wire:click="añadir_emoji('😤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😤</div>
                                                    <div wire:click="añadir_emoji('😮‍💨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😮‍💨</div>
                                                    <div wire:click="añadir_emoji('😮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😮</div>
                                                    <div wire:click="añadir_emoji('😱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😱</div>
                                                    <div wire:click="añadir_emoji('😨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😨</div>
                                                    <div wire:click="añadir_emoji('😰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😰</div>
                                                    <div wire:click="añadir_emoji('😯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😯</div>
                                                    <div wire:click="añadir_emoji('😦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😦</div>
                                                    <div wire:click="añadir_emoji('😧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😧</div>
                                                    <div wire:click="añadir_emoji('😢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😢</div>
                                                    <div wire:click="añadir_emoji('😥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😥</div>
                                                    <div wire:click="añadir_emoji('😪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😪</div>
                                                    <div wire:click="añadir_emoji('🤤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤤</div>
                                                    <div wire:click="añadir_emoji('😓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😓</div>
                                                    <div wire:click="añadir_emoji('😭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😭</div>
                                                    <div wire:click="añadir_emoji('🤩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤩</div>
                                                    <div wire:click="añadir_emoji('😵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😵</div>
                                                    <div wire:click="añadir_emoji('😵‍💫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😵‍💫</div>
                                                    <div wire:click="añadir_emoji('🥴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥴</div>
                                                    <div wire:click="añadir_emoji('😲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😲</div>
                                                    <div wire:click="añadir_emoji('🤯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤯</div>
                                                    <div wire:click="añadir_emoji('🤐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤐</div>
                                                    <div wire:click="añadir_emoji('😷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😷</div>
                                                    <div wire:click="añadir_emoji('🤕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤕</div>
                                                    <div wire:click="añadir_emoji('🤒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤒</div>
                                                    <div wire:click="añadir_emoji('🤮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤮</div>
                                                    <div wire:click="añadir_emoji('🤢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤢</div>
                                                    <div wire:click="añadir_emoji('🤧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤧</div>
                                                    <div wire:click="añadir_emoji('🥵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥵</div>
                                                    <div wire:click="añadir_emoji('🥶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥶</div>
                                                    <div wire:click="añadir_emoji('😶‍🌫️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😶‍🌫️</div>
                                                    <div wire:click="añadir_emoji('😴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😴</div>
                                                    <div wire:click="añadir_emoji('💤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💤</div>
                                                    <div wire:click="añadir_emoji('😈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😈</div>
                                                    <div wire:click="añadir_emoji('👿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👿</div>
                                                    <div wire:click="añadir_emoji('👹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👹</div>
                                                    <div wire:click="añadir_emoji('👺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👺</div>
                                                    <div wire:click="añadir_emoji('💩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💩</div>
                                                    <div wire:click="añadir_emoji('👻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👻</div>
                                                    <div wire:click="añadir_emoji('💀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💀</div>
                                                    <div wire:click="añadir_emoji('☠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☠</div>
                                                    <div wire:click="añadir_emoji('👽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👽</div>
                                                    <div wire:click="añadir_emoji('🤖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤖</div>
                                                    <div wire:click="añadir_emoji('🎃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎃</div>
                                                    <div wire:click="añadir_emoji('😺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😺</div>
                                                    <div wire:click="añadir_emoji('😸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😸</div>
                                                    <div wire:click="añadir_emoji('😹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😹</div>
                                                    <div wire:click="añadir_emoji('😻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😻</div>
                                                    <div wire:click="añadir_emoji('😼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😼</div>
                                                    <div wire:click="añadir_emoji('😽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😽</div>
                                                    <div wire:click="añadir_emoji('🙀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙀</div>
                                                    <div wire:click="añadir_emoji('😿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😿</div>
                                                    <div wire:click="añadir_emoji('😾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">😾</div>
                                                    <div wire:click="añadir_emoji('👐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👐</div>
                                                    <div wire:click="añadir_emoji('🤲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤲</div>
                                                    <div wire:click="añadir_emoji('🙌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙌</div>
                                                    <div wire:click="añadir_emoji('👏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👏</div>
                                                    <div wire:click="añadir_emoji('🙏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙏</div>
                                                    <div wire:click="añadir_emoji('🤝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤝</div>
                                                    <div wire:click="añadir_emoji('👍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👍</div>
                                                    <div wire:click="añadir_emoji('👎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👎</div>
                                                    <div wire:click="añadir_emoji('👊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👊</div>
                                                    <div wire:click="añadir_emoji('✊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✊</div>
                                                    <div wire:click="añadir_emoji('🤛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤛</div>
                                                    <div wire:click="añadir_emoji('🤜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤜</div>
                                                    <div wire:click="añadir_emoji('🤞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤞</div>
                                                    <div wire:click="añadir_emoji('✌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✌</div>
                                                    <div wire:click="añadir_emoji('🤘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤘</div>
                                                    <div wire:click="añadir_emoji('🤟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤟</div>
                                                    <div wire:click="añadir_emoji('👌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👌</div>
                                                    <div wire:click="añadir_emoji('🤏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤏</div>
                                                    <div wire:click="añadir_emoji('👈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👈</div>
                                                    <div wire:click="añadir_emoji('👉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👉</div>
                                                    <div wire:click="añadir_emoji('👆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👆</div>
                                                    <div wire:click="añadir_emoji('👇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👇</div>
                                                    <div wire:click="añadir_emoji('☝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☝</div>
                                                    <div wire:click="añadir_emoji('✋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✋</div>
                                                    <div wire:click="añadir_emoji('🤚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤚</div>
                                                    <div wire:click="añadir_emoji('🖐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖐</div>
                                                    <div wire:click="añadir_emoji('🖖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖖</div>
                                                    <div wire:click="añadir_emoji('👋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👋</div>
                                                    <div wire:click="añadir_emoji('🤙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤙</div>
                                                    <div wire:click="añadir_emoji('💪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💪</div>
                                                    <div wire:click="añadir_emoji('🦾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦾</div>
                                                    <div wire:click="añadir_emoji('🖕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖕</div>
                                                    <div wire:click="añadir_emoji('✍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✍</div>
                                                    <div wire:click="añadir_emoji('🤳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤳</div>
                                                    <div wire:click="añadir_emoji('💅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💅</div>
                                                    <div wire:click="añadir_emoji('🦵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦵</div>
                                                    <div wire:click="añadir_emoji('🦿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦿</div>
                                                    <div wire:click="añadir_emoji('🦶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦶</div>
                                                    <div wire:click="añadir_emoji('👄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👄</div>
                                                    <div wire:click="añadir_emoji('🦷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦷</div>
                                                    <div wire:click="añadir_emoji('👅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👅</div>
                                                    <div wire:click="añadir_emoji('👂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👂</div>
                                                    <div wire:click="añadir_emoji('🦻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦻</div>
                                                    <div wire:click="añadir_emoji(''👃)" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👃</div>
                                                    <div wire:click="añadir_emoji('👁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👁</div>
                                                    <div wire:click="añadir_emoji('👀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👀</div>
                                                    <div wire:click="añadir_emoji('🧠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧠</div>
                                                    <div wire:click="añadir_emoji('🦴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦴</div>
                                                    <div wire:click="añadir_emoji('👤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👤</div>
                                                    <div wire:click="añadir_emoji('👥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👥</div>
                                                    <div wire:click="añadir_emoji('🗣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗣</div>
                                                    <div wire:click="añadir_emoji('👶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👶</div>
                                                    <div wire:click="añadir_emoji('👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👧</div>
                                                    <div wire:click="añadir_emoji('🧒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧒</div>
                                                    <div wire:click="añadir_emoji('👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👦</div>
                                                    <div wire:click="añadir_emoji('👩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩</div>
                                                    <div wire:click="añadir_emoji('🧑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑</div>
                                                    <div wire:click="añadir_emoji('👨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨</div>
                                                    <div wire:click="añadir_emoji('👩‍🦱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🦱</div>
                                                    <div wire:click="añadir_emoji('🧑‍🦱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🦱</div>
                                                    <div wire:click="añadir_emoji('👨‍🦱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🦱</div>
                                                    <div wire:click="añadir_emoji('👩‍🦰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🦰</div>
                                                    <div wire:click="añadir_emoji('🧑‍🦰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🦰</div>
                                                    <div wire:click="añadir_emoji('👨‍🦰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🦰</div>
                                                    <div wire:click="añadir_emoji('👱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👱</div>
                                                    <div wire:click="añadir_emoji('👩‍🦳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🦳</div>
                                                    <div wire:click="añadir_emoji('🧑‍🦳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🦳</div>
                                                    <div wire:click="añadir_emoji('👨‍🦳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🦳</div>
                                                    <div wire:click="añadir_emoji('👩‍🦲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🦲</div>
                                                    <div wire:click="añadir_emoji('🧑‍🦲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🦲</div>
                                                    <div wire:click="añadir_emoji('👨‍🦲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🦲</div>
                                                    <div wire:click="añadir_emoji('🧔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧔</div>
                                                    <div wire:click="añadir_emoji('👵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👵</div>
                                                    <div wire:click="añadir_emoji('🧓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧓</div>
                                                    <div wire:click="añadir_emoji('👴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👴</div>
                                                    <div wire:click="añadir_emoji('👲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👲</div>
                                                    <div wire:click="añadir_emoji('👳‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👳‍</div>
                                                    <div wire:click="añadir_emoji('🧕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧕</div>
                                                    <div wire:click="añadir_emoji('👼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👼</div>
                                                    <div wire:click="añadir_emoji('👸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👸</div>
                                                    <div wire:click="añadir_emoji('🤴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤴</div>
                                                    <div wire:click="añadir_emoji('👰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👰</div>
                                                    <div wire:click="añadir_emoji('👰‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👰‍</div>
                                                    <div wire:click="añadir_emoji('🤵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤵</div>
                                                    <div wire:click="añadir_emoji('🙇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙇</div>
                                                    <div wire:click="añadir_emoji('💁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💁</div>
                                                    <div wire:click="añadir_emoji('🙅‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙅‍</div>
                                                    <div wire:click="añadir_emoji('🙅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙅</div>
                                                    <div wire:click="añadir_emoji('🙆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙆</div>
                                                    <div wire:click="añadir_emoji('🤷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤷</div>
                                                    <div wire:click="añadir_emoji('🙋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙋</div>
                                                    <div wire:click="añadir_emoji('🤦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤦</div>
                                                    <div wire:click="añadir_emoji('🧏‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧏‍</div>
                                                    <div wire:click="añadir_emoji('🙎‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙎‍</div>
                                                    <div wire:click="añadir_emoji('💇‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💇‍</div>
                                                    <div wire:click="añadir_emoji('💆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💆</div>
                                                    <div wire:click="añadir_emoji('🤰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤰</div>
                                                    <div wire:click="añadir_emoji('🤱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤱</div>
                                                    <div wire:click="añadir_emoji('👩‍🍼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🍼</div>
                                                    <div wire:click="añadir_emoji('🧑‍🍼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🍼</div>
                                                    <div wire:click="añadir_emoji('👨‍🍼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🍼</div>
                                                    <div wire:click="añadir_emoji('🧍‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧍‍</div>
                                                    <div wire:click="añadir_emoji('🚶‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚶‍</div>
                                                    <div wire:click="añadir_emoji(''👩‍🦯)" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🦯</div>
                                                    <div wire:click="añadir_emoji('🧑‍🦯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🦯</div>
                                                    <div wire:click="añadir_emoji('👨‍🦯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🦯</div>
                                                    <div wire:click="añadir_emoji('🏃‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏃‍</div>
                                                    <div wire:click="añadir_emoji('👩‍🦼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🦼</div>
                                                    <div wire:click="añadir_emoji('🧑‍🦼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🦼</div>
                                                    <div wire:click="añadir_emoji('💃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💃</div>
                                                    <div wire:click="añadir_emoji('🕺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕺</div>
                                                    <div wire:click="añadir_emoji('👫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👫</div>
                                                    <div wire:click="añadir_emoji('👭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👭</div>
                                                    <div wire:click="añadir_emoji('👩‍❤️‍👨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍❤️‍👨</div>
                                                    <div wire:click="añadir_emoji('❤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❤</div>
                                                    <div wire:click="añadir_emoji('🧡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧡</div>
                                                    <div wire:click="añadir_emoji('💛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💛</div>
                                                    <div wire:click="añadir_emoji('💚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💚</div>
                                                    <div wire:click="añadir_emoji('💙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💙</div>
                                                    <div wire:click="añadir_emoji('💜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💜</div>
                                                    <div wire:click="añadir_emoji('🤎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤎</div>
                                                    <div wire:click="añadir_emoji('🖤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖤</div>
                                                    <div wire:click="añadir_emoji('🤍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤍</div>
                                                    <div wire:click="añadir_emoji('💔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💔</div>
                                                    <div wire:click="añadir_emoji('❣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❣</div>
                                                    <div wire:click="añadir_emoji('💕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💕</div>
                                                    <div wire:click="añadir_emoji('💞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💞</div>
                                                    <div wire:click="añadir_emoji('💓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💓</div>
                                                    <div wire:click="añadir_emoji('💗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💗</div>
                                                    <div wire:click="añadir_emoji('💖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💖</div>
                                                    <div wire:click="añadir_emoji('💘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💘</div>
                                                    <div wire:click="añadir_emoji('💝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💝</div>
                                                    <div wire:click="añadir_emoji('❤️‍🔥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❤️‍🔥</div>
                                                    <div wire:click="añadir_emoji('❤️‍🩹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❤️‍🩹</div>
                                                    <div wire:click="añadir_emoji('💟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💟</div>
                                                    <div class="col-span-7 my-2">
                                                      <a name="animales_y_naturaleza">
                                                     <h3 class="px-2 mx-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Animales y naturaleza</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('🐶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐶</div>
                                                    <div wire:click="añadir_emoji('🐱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐱</div>
                                                    <div wire:click="añadir_emoji('🐭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐭</div>
                                                    <div wire:click="añadir_emoji('🐹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐹</div>
                                                    <div wire:click="añadir_emoji('🐰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐰</div>
                                                    <div wire:click="añadir_emoji('🐻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐻</div>
                                                    <div wire:click="añadir_emoji('🧸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧸</div>
                                                    <div wire:click="añadir_emoji('🐼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐼</div>
                                                    <div wire:click="añadir_emoji('🐻‍❄️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐻‍❄️</div>
                                                    <div wire:click="añadir_emoji('🐨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐨</div>
                                                    <div wire:click="añadir_emoji('🐯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐯</div>
                                                    <div wire:click="añadir_emoji('🦁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦁</div>
                                                    <div wire:click="añadir_emoji('🐮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐮</div>
                                                    <div wire:click="añadir_emoji('🐷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐷</div>
                                                    <div wire:click="añadir_emoji('🐽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐽</div>
                                                    <div wire:click="añadir_emoji('🐸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐸</div>
                                                    <div wire:click="añadir_emoji('🐵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐵</div>
                                                    <div wire:click="añadir_emoji('🙈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙈</div>
                                                    <div wire:click="añadir_emoji('🙉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙉</div>
                                                    <div wire:click="añadir_emoji('🙊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🙊</div>
                                                    <div wire:click="añadir_emoji('🐒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐒</div>
                                                    <div wire:click="añadir_emoji('🦍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦍</div>
                                                    <div wire:click="añadir_emoji('🦧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦧</div>
                                                    <div wire:click="añadir_emoji('🐔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐔</div>
                                                    <div wire:click="añadir_emoji('🐧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐧</div>
                                                    <div wire:click="añadir_emoji('🐦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐦</div>
                                                    <div wire:click="añadir_emoji('🐤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐤</div>
                                                    <div wire:click="añadir_emoji('🐣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐣</div>
                                                    <div wire:click="añadir_emoji('🐥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐥</div>
                                                    <div wire:click="añadir_emoji('🐺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐺</div>
                                                    <div wire:click="añadir_emoji('🦊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦊</div>
                                                    <div wire:click="añadir_emoji('🦝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦝</div>
                                                    <div wire:click="añadir_emoji('🐗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐗</div>
                                                    <div wire:click="añadir_emoji('🐴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐴</div>
                                                    <div wire:click="añadir_emoji('🦓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦓</div>
                                                    <div wire:click="añadir_emoji('🦒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦒</div>
                                                    <div wire:click="añadir_emoji('🦌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦌</div>
                                                    <div wire:click="añadir_emoji('🦘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦘</div>
                                                    <div wire:click="añadir_emoji('🦥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦥</div>
                                                    <div wire:click="añadir_emoji('🦦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦦</div>
                                                    <div wire:click="añadir_emoji('🦄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦄</div>
                                                    <div wire:click="añadir_emoji('🐝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐝</div>
                                                    <div wire:click="añadir_emoji('🐛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐛</div>
                                                    <div wire:click="añadir_emoji('🦋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦋</div>
                                                    <div wire:click="añadir_emoji('🐌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐌</div>
                                                    <div wire:click="añadir_emoji('🐞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐞</div>
                                                    <div wire:click="añadir_emoji('🐜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐜</div>
                                                    <div wire:click="añadir_emoji('🦗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦗</div>
                                                    <div wire:click="añadir_emoji('🕷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕷</div>
                                                    <div wire:click="añadir_emoji('🕸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕸</div>
                                                    <div wire:click="añadir_emoji('🦂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦂</div>
                                                    <div wire:click="añadir_emoji('🦟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦟</div>
                                                    <div wire:click="añadir_emoji('🦠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦠</div>
                                                    <div wire:click="añadir_emoji('🐢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐢</div>
                                                    <div wire:click="añadir_emoji('🐍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐍</div>
                                                    <div wire:click="añadir_emoji('🦎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦎</div>
                                                    <div wire:click="añadir_emoji('🐙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐙</div>
                                                    <div wire:click="añadir_emoji('🦑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦑</div>
                                                    <div wire:click="añadir_emoji('🦞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦞</div>
                                                    <div wire:click="añadir_emoji('🦀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦀</div>
                                                    <div wire:click="añadir_emoji('🦐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦐</div>
                                                    <div wire:click="añadir_emoji('🦪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦪</div>
                                                    <div wire:click="añadir_emoji('🐠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐠</div>
                                                    <div wire:click="añadir_emoji('🐟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐟</div>
                                                    <div wire:click="añadir_emoji('🐡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐡</div>
                                                    <div wire:click="añadir_emoji('🐬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐬</div>
                                                    <div wire:click="añadir_emoji('🦈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦈</div>
                                                    <div wire:click="añadir_emoji('🐳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐳</div>
                                                    <div wire:click="añadir_emoji('🐋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐋</div>
                                                    <div wire:click="añadir_emoji('🐊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐊</div>
                                                    <div wire:click="añadir_emoji('🐆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐆</div>
                                                    <div wire:click="añadir_emoji('🐅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐅</div>
                                                    <div wire:click="añadir_emoji('🐃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐃</div>
                                                    <div wire:click="añadir_emoji('🐂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐂</div>
                                                    <div wire:click="añadir_emoji('🐄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐄</div>
                                                    <div wire:click="añadir_emoji('🐪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐪</div>
                                                    <div wire:click="añadir_emoji('🐫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐫</div>
                                                    <div wire:click="añadir_emoji('🦙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦙</div>
                                                    <div wire:click="añadir_emoji('🐘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐘</div>
                                                    <div wire:click="añadir_emoji('🦏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦏</div>
                                                    <div wire:click="añadir_emoji('🦛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦛</div>
                                                    <div wire:click="añadir_emoji('🐐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐐</div>
                                                    <div wire:click="añadir_emoji('🐏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐏</div>
                                                    <div wire:click="añadir_emoji('🐑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐑</div>
                                                    <div wire:click="añadir_emoji('🐎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐎</div>
                                                    <div wire:click="añadir_emoji('🐖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐖</div>
                                                    <div wire:click="añadir_emoji('🦇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦇</div>
                                                    <div wire:click="añadir_emoji('🐓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐓</div>
                                                    <div wire:click="añadir_emoji('🦃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦃</div>
                                                    <div wire:click="añadir_emoji('🕊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕊</div>
                                                    <div wire:click="añadir_emoji('🦅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦅</div>
                                                    <div wire:click="añadir_emoji('🦆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦆</div>
                                                    <div wire:click="añadir_emoji('🦢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦢</div>
                                                    <div wire:click="añadir_emoji('🦉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦉</div>
                                                    <div wire:click="añadir_emoji('🦩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦩</div>
                                                    <div wire:click="añadir_emoji('🦚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦚</div>
                                                    <div wire:click="añadir_emoji('🦜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦜</div>
                                                    <div wire:click="añadir_emoji('🐕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐕</div>
                                                    <div wire:click="añadir_emoji('🦮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦮</div>
                                                    <div wire:click="añadir_emoji('🐕‍🦺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐕‍🦺</div>
                                                    <div wire:click="añadir_emoji('🐩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐩</div>
                                                    <div wire:click="añadir_emoji('🐈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐈</div>
                                                    <div wire:click="añadir_emoji('🐈‍⬛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐈‍⬛</div>
                                                    <div wire:click="añadir_emoji('🐇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐇</div>
                                                    <div wire:click="añadir_emoji('🐀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐀</div>
                                                    <div wire:click="añadir_emoji('🐁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐁</div>
                                                    <div wire:click="añadir_emoji('🐿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐿</div>
                                                    <div wire:click="añadir_emoji('🦨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦨</div>
                                                    <div wire:click="añadir_emoji('🦡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦡</div>
                                                    <div wire:click="añadir_emoji('🦔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦔</div>
                                                    <div wire:click="añadir_emoji('🐾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐾</div>
                                                    <div wire:click="añadir_emoji('🐉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐉</div>
                                                    <div wire:click="añadir_emoji('🐲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐲</div>
                                                    <div wire:click="añadir_emoji('🦕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦕</div>
                                                    <div wire:click="añadir_emoji('🦖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦖</div>
                                                    <div wire:click="añadir_emoji('🌵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌵</div>
                                                    <div wire:click="añadir_emoji('🎄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎄</div>
                                                    <div wire:click="añadir_emoji('🌲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌲</div>
                                                    <div wire:click="añadir_emoji('🌳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌳</div>
                                                    <div wire:click="añadir_emoji('🌴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌴</div>
                                                    <div wire:click="añadir_emoji('🌱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌱</div>
                                                    <div wire:click="añadir_emoji('🌿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌿</div>
                                                    <div wire:click="añadir_emoji('☘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☘</div>
                                                    <div wire:click="añadir_emoji('🍀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍀</div>
                                                    <div wire:click="añadir_emoji('🎍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎍</div>
                                                    <div wire:click="añadir_emoji('🎋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎋</div>
                                                    <div wire:click="añadir_emoji('🍃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍃</div>
                                                    <div wire:click="añadir_emoji('🍂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍂</div>
                                                    <div wire:click="añadir_emoji('🍁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍁</div>
                                                    <div wire:click="añadir_emoji('🌾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌾</div>
                                                    <div wire:click="añadir_emoji('🌺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌺</div>
                                                    <div wire:click="añadir_emoji('🌻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌻</div>
                                                    <div wire:click="añadir_emoji('🌹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌹</div>
                                                    <div wire:click="añadir_emoji('🥀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥀</div>
                                                    <div wire:click="añadir_emoji('🌷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌷</div>
                                                    <div wire:click="añadir_emoji('🌼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌼</div>
                                                    <div wire:click="añadir_emoji('🌸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌸</div>
                                                    <div wire:click="añadir_emoji('💐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💐</div>
                                                    <div wire:click="añadir_emoji('🍄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍄</div>
                                                    <div wire:click="añadir_emoji('🌰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌰</div>
                                                    <div wire:click="añadir_emoji('🐚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🐚</div>
                                                    <div wire:click="añadir_emoji('🌎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌎</div>
                                                    <div wire:click="añadir_emoji('🌍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌍</div>
                                                    <div wire:click="añadir_emoji('🌏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌏</div>
                                                    <div wire:click="añadir_emoji('🌕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌕</div>
                                                    <div wire:click="añadir_emoji('🌖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌖</div>
                                                    <div wire:click="añadir_emoji('🌗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌗</div>
                                                    <div wire:click="añadir_emoji('🌔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌔</div>
                                                    <div wire:click="añadir_emoji('🌙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌙</div>
                                                    <div wire:click="añadir_emoji('🌚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌚</div>
                                                    <div wire:click="añadir_emoji('🌝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌝</div>
                                                    <div wire:click="añadir_emoji('🌛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌛</div>
                                                    <div wire:click="añadir_emoji('🌜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌜</div>
                                                    <div wire:click="añadir_emoji('⭐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⭐</div>
                                                    <div wire:click="añadir_emoji('🌟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌟</div>
                                                    <div wire:click="añadir_emoji('💫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💫</div>
                                                    <div wire:click="añadir_emoji('✨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✨</div>
                                                    <div wire:click="añadir_emoji('☄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☄</div>
                                                    <div wire:click="añadir_emoji('🪐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪐</div>
                                                    <div wire:click="añadir_emoji('🌞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌞</div>
                                                    <div wire:click="añadir_emoji('☀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☀</div>
                                                    <div wire:click="añadir_emoji('🌤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌤</div>
                                                    <div wire:click="añadir_emoji('⛅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛅</div>
                                                    <div wire:click="añadir_emoji('🌥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌥</div>
                                                    <div wire:click="añadir_emoji('🌦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌦</div>
                                                    <div wire:click="añadir_emoji('☁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☁</div>
                                                    <div wire:click="añadir_emoji('🌧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌧</div>
                                                    <div wire:click="añadir_emoji('⛈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛈</div>
                                                    <div wire:click="añadir_emoji('🌩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌩</div>
                                                    <div wire:click="añadir_emoji('⚡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚡</div>
                                                    <div wire:click="añadir_emoji('🔥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔥</div>
                                                    <div wire:click="añadir_emoji('💥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💥</div>
                                                    <div wire:click="añadir_emoji('❄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❄</div>
                                                    <div wire:click="añadir_emoji('🌨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌨</div>
                                                    <div wire:click="añadir_emoji('☃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☃</div>
                                                    <div wire:click="añadir_emoji('⛄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛄</div>
                                                    <div wire:click="añadir_emoji('🌬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌬</div>
                                                    <div wire:click="añadir_emoji('💨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💨</div>
                                                    <div wire:click="añadir_emoji('🌫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌫</div>
                                                    <div wire:click="añadir_emoji('🌈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌈</div>
                                                    <div wire:click="añadir_emoji('☔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☔</div>
                                                    <div wire:click="añadir_emoji('💧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💧</div>
                                                    <div wire:click="añadir_emoji('💦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💦</div>
                                                    <div wire:click="añadir_emoji('🌊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌊</div>
                                                    <div class="col-span-7 my-2">
                                                      <a name="comida_y_bebida">
                                                       <h3 class="px-2 mx-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Comida y bebida</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('🍏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍏</div>
                                                    <div wire:click="añadir_emoji('🍎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍎</div>
                                                    <div wire:click="añadir_emoji('🍐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍐</div>
                                                    <div wire:click="añadir_emoji('🍊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍊</div>
                                                    <div wire:click="añadir_emoji('🍋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍋</div>
                                                    <div wire:click="añadir_emoji('🍌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍌</div>
                                                    <div wire:click="añadir_emoji('🍉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍉</div>
                                                    <div wire:click="añadir_emoji('🍇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍇</div>
                                                    <div wire:click="añadir_emoji('🍓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍓</div>
                                                    <div wire:click="añadir_emoji('🍈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍈</div>
                                                    <div wire:click="añadir_emoji('🍒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍒</div>
                                                    <div wire:click="añadir_emoji('🍑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍑</div>
                                                    <div wire:click="añadir_emoji('🥭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥭</div>
                                                    <div wire:click="añadir_emoji('🍍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍍</div>
                                                    <div wire:click="añadir_emoji('🥥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥥</div>
                                                    <div wire:click="añadir_emoji('🥝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥝</div>
                                                    <div wire:click="añadir_emoji('🍅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍅</div>
                                                    <div wire:click="añadir_emoji('🥑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥑</div>
                                                    <div wire:click="añadir_emoji('🍆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍆</div>
                                                    <div wire:click="añadir_emoji('🌶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌶</div>
                                                    <div wire:click="añadir_emoji('🥒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥒</div>
                                                    <div wire:click="añadir_emoji('🥬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥬</div>
                                                    <div wire:click="añadir_emoji('🥦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥦</div>
                                                    <div wire:click="añadir_emoji('🧄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧄</div>
                                                    <div wire:click="añadir_emoji('🧅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧅</div>
                                                    <div wire:click="añadir_emoji('🌽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌽</div>
                                                    <div wire:click="añadir_emoji('🥕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥕</div>
                                                    <div wire:click="añadir_emoji('🥗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥗</div>
                                                    <div wire:click="añadir_emoji('🥔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥔</div>
                                                    <div wire:click="añadir_emoji('🍠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍠</div>
                                                    <div wire:click="añadir_emoji('🥜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥜</div>
                                                    <div wire:click="añadir_emoji('🍯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍯</div>
                                                    <div wire:click="añadir_emoji('🍞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍞</div>
                                                    <div wire:click="añadir_emoji('🥐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥐</div>
                                                    <div wire:click="añadir_emoji('🥖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥖</div>
                                                    <div wire:click="añadir_emoji('🥨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥨</div>
                                                    <div wire:click="añadir_emoji('🥯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥯</div>
                                                    <div wire:click="añadir_emoji('🥞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥞</div>
                                                    <div wire:click="añadir_emoji('🧇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧇</div>
                                                    <div wire:click="añadir_emoji('🧀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧀</div>
                                                    <div wire:click="añadir_emoji('🍗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍗</div>
                                                    <div wire:click="añadir_emoji('🍖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍖</div>
                                                    <div wire:click="añadir_emoji('🥩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥩</div>
                                                    <div wire:click="añadir_emoji('🍤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍤</div>
                                                    <div wire:click="añadir_emoji('🥚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥚</div>
                                                    <div wire:click="añadir_emoji('🍳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍳</div>
                                                    <div wire:click="añadir_emoji('🥓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥓</div>
                                                    <div wire:click="añadir_emoji('🍔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍔</div>
                                                    <div wire:click="añadir_emoji('🍟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍟</div>
                                                    <div wire:click="añadir_emoji('🌭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌭</div>
                                                    <div wire:click="añadir_emoji('🍕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍕</div>
                                                    <div wire:click="añadir_emoji('🍝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍝</div>
                                                    <div wire:click="añadir_emoji('🥪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥪</div>
                                                    <div wire:click="añadir_emoji('🌮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌮</div>
                                                    <div wire:click="añadir_emoji('🌯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌯</div>
                                                    <div wire:click="añadir_emoji('🥙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥙</div>
                                                    <div wire:click="añadir_emoji('🧆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧆</div>
                                                    <div wire:click="añadir_emoji('🍜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍜</div>
                                                    <div wire:click="añadir_emoji('🥘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥘</div>
                                                    <div wire:click="añadir_emoji('🍲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍲</div>
                                                    <div wire:click="añadir_emoji('🥫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥫</div>
                                                    <div wire:click="añadir_emoji('🧂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧂</div>
                                                    <div wire:click="añadir_emoji('🧈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧈</div>
                                                    <div wire:click="añadir_emoji('🍥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍥</div>
                                                    <div wire:click="añadir_emoji('🍣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍣</div>
                                                    <div wire:click="añadir_emoji('🍱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍱</div>
                                                    <div wire:click="añadir_emoji('🍛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍛</div>
                                                    <div wire:click="añadir_emoji('🍙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍙</div>
                                                    <div wire:click="añadir_emoji('🍚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍚</div>
                                                    <div wire:click="añadir_emoji('🍘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍘</div>
                                                    <div wire:click="añadir_emoji('🥟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥟</div>
                                                    <div wire:click="añadir_emoji('🍢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍢</div>
                                                    <div wire:click="añadir_emoji('🍡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍡</div>
                                                    <div wire:click="añadir_emoji('🍧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍧</div>
                                                    <div wire:click="añadir_emoji('🍨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍨</div>
                                                    <div wire:click="añadir_emoji('🍦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍦</div>
                                                    <div wire:click="añadir_emoji('🍰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍰</div>
                                                    <div wire:click="añadir_emoji('🎂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎂</div>
                                                    <div wire:click="añadir_emoji('🧁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧁</div>
                                                    <div wire:click="añadir_emoji('🥧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥧</div>
                                                    <div wire:click="añadir_emoji('🍮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍮</div>
                                                    <div wire:click="añadir_emoji('🍭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍭</div>
                                                    <div wire:click="añadir_emoji('🍬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍬</div>
                                                    <div wire:click="añadir_emoji('🍫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍫</div>
                                                    <div wire:click="añadir_emoji('🍿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍿</div>
                                                    <div wire:click="añadir_emoji('🍩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍩</div>
                                                    <div wire:click="añadir_emoji('🍪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍪</div>
                                                    <div wire:click="añadir_emoji('🥠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥠</div>
                                                    <div wire:click="añadir_emoji('🥮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥮</div>
                                                    <div wire:click="añadir_emoji('☕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☕</div>
                                                    <div wire:click="añadir_emoji('🍵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍵</div>
                                                    <div wire:click="añadir_emoji('🥣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥣</div>
                                                    <div wire:click="añadir_emoji('🍼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍼</div>
                                                    <div wire:click="añadir_emoji('🥤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥤</div>
                                                    <div wire:click="añadir_emoji('🧃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧃</div>
                                                    <div wire:click="añadir_emoji('🧉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧉</div>
                                                    <div wire:click="añadir_emoji('🥛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥛</div>
                                                    <div wire:click="añadir_emoji('🍺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍺</div>
                                                    <div wire:click="añadir_emoji('🍻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍻</div>
                                                    <div wire:click="añadir_emoji('🍷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍷</div>
                                                    <div wire:click="añadir_emoji('🥂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥂</div>
                                                    <div wire:click="añadir_emoji('🥃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥃</div>
                                                    <div wire:click="añadir_emoji('🍸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍸</div>
                                                    <div wire:click="añadir_emoji('🍹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍹</div>
                                                    <div wire:click="añadir_emoji('🍾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍾</div>
                                                    <div wire:click="añadir_emoji('🍶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍶</div>
                                                    <div wire:click="añadir_emoji('🧊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧊</div>
                                                    <div wire:click="añadir_emoji('🥄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥄</div>
                                                    <div wire:click="añadir_emoji('🍴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍴</div>
                                                    <div wire:click="añadir_emoji('🍽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🍽</div>
                                                    <div wire:click="añadir_emoji('🥢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥢</div>
                                                    <div wire:click="añadir_emoji('🥡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥡</div>
                                                    <div class="col-span-7 my-2">
                                                      <a name="actividades">
                                                       <h3 class="px-2 mx-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Actividades</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('⚽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚽</div>
                                                    <div wire:click="añadir_emoji('🏀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏀</div>
                                                    <div wire:click="añadir_emoji('🏈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏈</div>
                                                    <div wire:click="añadir_emoji('⚾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚾</div>
                                                    <div wire:click="añadir_emoji('🥎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥎</div>
                                                    <div wire:click="añadir_emoji('🎾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎾</div>
                                                    <div wire:click="añadir_emoji('🏐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏐</div>
                                                    <div wire:click="añadir_emoji('🏉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏉</div>
                                                    <div wire:click="añadir_emoji('🎱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎱</div>
                                                    <div wire:click="añadir_emoji('🥏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥏</div>
                                                    <div wire:click="añadir_emoji('🏓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏓</div>
                                                    <div wire:click="añadir_emoji('🏸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏸</div>
                                                    <div wire:click="añadir_emoji('🥅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥅</div>
                                                    <div wire:click="añadir_emoji('🏒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏒</div>
                                                    <div wire:click="añadir_emoji('🏑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏑</div>
                                                    <div wire:click="añadir_emoji('🏏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏏</div>
                                                    <div wire:click="añadir_emoji('🥍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥍</div>
                                                    <div wire:click="añadir_emoji('🥌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥌</div>
                                                    <div wire:click="añadir_emoji('⛳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛳</div>
                                                    <div wire:click="añadir_emoji('🏹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏹</div>
                                                    <div wire:click="añadir_emoji('🎣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎣</div>
                                                    <div wire:click="añadir_emoji('🤿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤿</div>
                                                    <div wire:click="añadir_emoji('🥊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥊</div>
                                                    <div wire:click="añadir_emoji('🥋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥋</div>
                                                    <div wire:click="añadir_emoji('⛸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛸</div>
                                                    <div wire:click="añadir_emoji('🎿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎿</div>
                                                    <div wire:click="añadir_emoji('🛷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛷</div>
                                                    <div wire:click="añadir_emoji('⛷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛷</div>
                                                    <div wire:click="añadir_emoji('🏂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏂</div>
                                                    <div wire:click="añadir_emoji('🏋️‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏋️‍</div>
                                                    <div wire:click="añadir_emoji('🤺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤺</div>
                                                    <div wire:click="añadir_emoji('🤼‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤼‍</div>
                                                    <div wire:click="añadir_emoji('🤸‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤸‍</div>
                                                    <div wire:click="añadir_emoji('⛹️‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛹️‍</div>
                                                    <div wire:click="añadir_emoji('🤾‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤾‍</div>
                                                    <div wire:click="añadir_emoji('🧗‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧗‍</div>
                                                    <div wire:click="añadir_emoji('🏌️‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏌️‍</div>
                                                    <div wire:click="añadir_emoji('🧘‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧘‍</div>
                                                    <div wire:click="añadir_emoji('🧖‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧖‍</div>
                                                    <div wire:click="añadir_emoji('🏄‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏄‍</div>
                                                    <div wire:click="añadir_emoji('🏊‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏊‍</div>
                                                    <div wire:click="añadir_emoji('🤽‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤽‍</div>
                                                    <div wire:click="añadir_emoji('🚣‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚣‍</div>
                                                    <div wire:click="añadir_emoji('🏇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏇</div>
                                                    <div wire:click="añadir_emoji('🚴‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚴‍</div>
                                                    <div wire:click="añadir_emoji('🚵‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚵‍</div>
                                                    <div wire:click="añadir_emoji('🎽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎽</div>
                                                    <div wire:click="añadir_emoji('🎖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎖</div>
                                                    <div wire:click="añadir_emoji('🏅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏅</div>
                                                    <div wire:click="añadir_emoji('🥇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥇</div>
                                                    <div wire:click="añadir_emoji('🥈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥈</div>
                                                    <div wire:click="añadir_emoji('🥉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥉</div>
                                                    <div wire:click="añadir_emoji('🏆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏆</div>
                                                    <div wire:click="añadir_emoji('🏵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏵</div>
                                                    <div wire:click="añadir_emoji('🎗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎗</div>
                                                    <div wire:click="añadir_emoji('🎫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎫</div>
                                                    <div wire:click="añadir_emoji('🎟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎟</div>
                                                    <div wire:click="añadir_emoji('🎪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎪</div>
                                                    <div wire:click="añadir_emoji('🤹‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤹‍</div>
                                                    <div wire:click="añadir_emoji('🎭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎭</div>
                                                    <div wire:click="añadir_emoji('🎨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎨</div>
                                                    <div wire:click="añadir_emoji('🎬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎬</div>
                                                    <div wire:click="añadir_emoji('🎤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎤</div>
                                                    <div wire:click="añadir_emoji('🎧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎧</div>
                                                    <div wire:click="añadir_emoji('🎼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎼</div>
                                                    <div wire:click="añadir_emoji('🎹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎹</div>
                                                    <div wire:click="añadir_emoji('🥁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥁</div>
                                                    <div wire:click="añadir_emoji('🎷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎷</div>
                                                    <div wire:click="añadir_emoji('🎺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎺</div>
                                                    <div wire:click="añadir_emoji('🎸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎸</div>
                                                    <div wire:click="añadir_emoji('🪕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪕</div>
                                                    <div wire:click="añadir_emoji('🎻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎻</div>
                                                    <div wire:click="añadir_emoji('🎲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎲</div>
                                                    <div wire:click="añadir_emoji('🧩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧩</div>
                                                    <div wire:click="añadir_emoji('🎯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎯</div>
                                                    <div wire:click="añadir_emoji('🎳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎳</div>
                                                    <div wire:click="añadir_emoji('🪀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪀</div>
                                                    <div wire:click="añadir_emoji('🪁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪁</div>
                                                    <div wire:click="añadir_emoji('🎮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎮</div>
                                                    <div wire:click="añadir_emoji('👾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👾</div>
                                                    <div wire:click="añadir_emoji('🎰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎰</div>
                                                    <div wire:click="añadir_emoji('👮‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👮‍</div>
                                                    <div wire:click="añadir_emoji('👩‍🚒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🚒</div>
                                                    <div wire:click="añadir_emoji('🧑‍🚒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🚒</div>
                                                    <div wire:click="añadir_emoji('👨‍🚒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🚒</div>
                                                    <div wire:click="añadir_emoji('👷‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👷‍</div>
                                                    <div wire:click="añadir_emoji('👩‍🏭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🏭</div>
                                                    <div wire:click="añadir_emoji('🧑‍🏭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🏭</div>
                                                    <div wire:click="añadir_emoji('👨‍🏭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🏭</div>
                                                    <div wire:click="añadir_emoji('👩‍🔧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🔧</div>
                                                    <div wire:click="añadir_emoji('👩‍🌾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🌾</div>
                                                    <div wire:click="añadir_emoji('🧑‍🌾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🌾</div>
                                                    <div wire:click="añadir_emoji('👨‍🌾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🌾</div>
                                                    <div wire:click="añadir_emoji('👩‍🍳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🍳</div>
                                                    <div wire:click="añadir_emoji('👩‍🎤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🎤</div>
                                                    <div wire:click="añadir_emoji('🧑‍🎤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🎤</div>
                                                    <div wire:click="añadir_emoji('👨‍🎤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🎤</div>
                                                    <div wire:click="añadir_emoji('👩‍🎨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🎨</div>
                                                    <div wire:click="añadir_emoji('🧑‍🎨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🎨</div>
                                                    <div wire:click="añadir_emoji('👨‍🎨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🎨</div>
                                                    <div wire:click="añadir_emoji('👩‍🏫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🏫</div>
                                                    <div wire:click="añadir_emoji('🧑‍🏫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🏫</div>
                                                    <div wire:click="añadir_emoji('👨‍🏫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🏫</div>
                                                    <div wire:click="añadir_emoji('👩‍🎓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🎓</div>
                                                    <div wire:click="añadir_emoji('🧑‍🎓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🎓</div>
                                                    <div wire:click="añadir_emoji('👨‍🎓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🎓</div>
                                                    <div wire:click="añadir_emoji('👩‍💼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍💼</div>
                                                    <div wire:click="añadir_emoji('🧑‍💼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍💼</div>
                                                    <div wire:click="añadir_emoji('👨‍💼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍💼</div>
                                                    <div wire:click="añadir_emoji('👩‍💻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍💻</div>
                                                    <div wire:click="añadir_emoji('🧑‍💻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍💻</div>
                                                    <div wire:click="añadir_emoji('👩‍🔬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🔬</div>
                                                    <div wire:click="añadir_emoji('🧑‍🔬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🔬</div>
                                                    <div wire:click="añadir_emoji('👨‍🔬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🔬</div>
                                                    <div wire:click="añadir_emoji('👩‍🚀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍🚀</div>
                                                    <div wire:click="añadir_emoji('🧑‍🚀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🚀</div>
                                                    <div wire:click="añadir_emoji('👨‍🚀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍🚀</div>
                                                    <div wire:click="añadir_emoji('👩‍⚕️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍⚕️</div>
                                                    <div wire:click="añadir_emoji('🧑‍⚕️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍⚕️</div>
                                                    <div wire:click="añadir_emoji('👨‍⚕️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍⚕️</div>
                                                    <div wire:click="añadir_emoji('👩‍⚖️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍⚖️</div>
                                                    <div wire:click="añadir_emoji('🧑‍⚖️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍⚖️</div>
                                                    <div wire:click="añadir_emoji('👨‍⚖️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍⚖️</div>
                                                    <div wire:click="añadir_emoji('👩‍✈️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍✈️</div>
                                                    <div wire:click="añadir_emoji('🧑‍✈️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍✈️</div>
                                                    <div wire:click="añadir_emoji('👨‍✈️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍✈️</div>
                                                    <div wire:click="añadir_emoji('💂‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💂‍</div>
                                                    <div wire:click="añadir_emoji('🕵️‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕵️‍</div>
                                                    <div wire:click="añadir_emoji('🤶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🤶</div>
                                                    <div wire:click="añadir_emoji('🧑‍🎄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧑‍🎄</div>
                                                    <div wire:click="añadir_emoji('🎅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎅</div>
                                                    <div wire:click="añadir_emoji('🕴️‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕴️‍</div>
                                                    <div wire:click="añadir_emoji('🦸‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦸‍</div>
                                                    <div wire:click="añadir_emoji('🦹‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦹‍</div>
                                                    <div wire:click="añadir_emoji('🧙‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧙‍</div>
                                                    <div wire:click="añadir_emoji('🧝‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧝‍</div>
                                                    <div wire:click="añadir_emoji('🧚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧚</div>
                                                    <div wire:click="añadir_emoji('🧞‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧞‍</div>
                                                    <div wire:click="añadir_emoji('🧜‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧜‍</div>
                                                    <div wire:click="añadir_emoji('🧛‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧛‍</div>
                                                    <div wire:click="añadir_emoji('🧟‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧟‍</div>
                                                    <div wire:click="añadir_emoji('👯‍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👯‍</div>
                                                    <div wire:click="añadir_emoji('👪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👪</div>
                                                    <div wire:click="añadir_emoji('👨‍👩‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👩‍👧</div>
                                                    <div wire:click="añadir_emoji('👨‍👩‍👧‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👩‍👧‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👩‍👦‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👩‍👦‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👩‍👧‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👩‍👧‍👧</div>
                                                    <div wire:click="añadir_emoji('👩‍👩‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👩‍👦</div>
                                                    <div wire:click="añadir_emoji('👩‍👩‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👩‍👧</div>
                                                    <div wire:click="añadir_emoji('👩‍👩‍👧‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👩‍👧‍👦</div>
                                                    <div wire:click="añadir_emoji('👩‍👩‍👦‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👩‍👦‍👦</div>
                                                    <div wire:click="añadir_emoji('👩‍👩‍👧‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👩‍👧‍👧</div>
                                                    <div wire:click="añadir_emoji('👨‍👨‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👨‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👨‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👨‍👧</div>
                                                    <div wire:click="añadir_emoji('👨‍👨‍👧‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👨‍👧‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👨‍👦‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👨‍👦‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👨‍👧‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👨‍👧‍👧</div>
                                                    <div wire:click="añadir_emoji('👩‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👦</div>
                                                    <div wire:click="añadir_emoji('👩‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👧</div>
                                                    <div wire:click="añadir_emoji('👩‍👧‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👧‍👦</div>
                                                    <div wire:click="añadir_emoji('👩‍👦‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👦‍👦</div>
                                                    <div wire:click="añadir_emoji('👩‍👧‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👩‍👧‍👧</div>
                                                    <div wire:click="añadir_emoji('👨‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👧</div>
                                                    <div wire:click="añadir_emoji('👨‍👧‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👧‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👧‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👧‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👦‍👦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👦‍👦</div>
                                                    <div wire:click="añadir_emoji('👨‍👧‍👧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👨‍👧‍👧</div>
                                                    <div class="col-span-7 my-2">
                                                      <a name="Viajes_y_lugares">
                                                       <h3 class="px-2 mx-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Viajes y lugares</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('🚗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚗</div>
                                                    <div wire:click="añadir_emoji('🚙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚙</div>
                                                    <div wire:click="añadir_emoji('🚕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚕</div>
                                                    <div wire:click="añadir_emoji('🛺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛺</div>
                                                    <div wire:click="añadir_emoji('🚌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚌</div>
                                                    <div wire:click="añadir_emoji('🚎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚎</div>
                                                    <div wire:click="añadir_emoji('🏎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏎</div>
                                                    <div wire:click="añadir_emoji('🚓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚓</div>
                                                    <div wire:click="añadir_emoji('🚑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚑</div>
                                                    <div wire:click="añadir_emoji('🚒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚒</div>
                                                    <div wire:click="añadir_emoji('🚐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚐</div>
                                                    <div wire:click="añadir_emoji('🚚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚚</div>
                                                    <div wire:click="añadir_emoji('🚛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚛</div>
                                                    <div wire:click="añadir_emoji('🚜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚜</div>
                                                    <div wire:click="añadir_emoji('🏍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏍</div>
                                                    <div wire:click="añadir_emoji('🛵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛵</div>
                                                    <div wire:click="añadir_emoji('🚲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚲</div>
                                                    <div wire:click="añadir_emoji('🦼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦼</div>
                                                    <div wire:click="añadir_emoji('🦽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦽</div>
                                                    <div wire:click="añadir_emoji('🛴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛴</div>
                                                    <div wire:click="añadir_emoji('🛹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛹</div>
                                                    <div wire:click="añadir_emoji('🚨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚨</div>
                                                    <div wire:click="añadir_emoji('🚔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚔</div>
                                                    <div wire:click="añadir_emoji('🚍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚍</div>
                                                    <div wire:click="añadir_emoji('🚘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚘</div>
                                                    <div wire:click="añadir_emoji('🚖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚖</div>
                                                    <div wire:click="añadir_emoji('🚡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚡</div>
                                                    <div wire:click="añadir_emoji('🚠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚠</div>
                                                    <div wire:click="añadir_emoji('🚟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚟</div>
                                                    <div wire:click="añadir_emoji('🚃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚃</div>
                                                    <div wire:click="añadir_emoji('🚋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚋</div>
                                                    <div wire:click="añadir_emoji('🚝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚝</div>
                                                    <div wire:click="añadir_emoji('🚄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚄</div>
                                                    <div wire:click="añadir_emoji('🚈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚈</div>
                                                    <div wire:click="añadir_emoji('🚞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚞</div>
                                                    <div wire:click="añadir_emoji('🚂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚂</div>
                                                    <div wire:click="añadir_emoji('🚆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚆</div>
                                                    <div wire:click="añadir_emoji('🚇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚇</div>
                                                    <div wire:click="añadir_emoji('🚊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚊</div>
                                                    <div wire:click="añadir_emoji('🚉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚉</div>
                                                    <div wire:click="añadir_emoji('🚁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚁</div>
                                                    <div wire:click="añadir_emoji('🛩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛩</div>
                                                    <div wire:click="añadir_emoji('✈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✈</div>
                                                    <div wire:click="añadir_emoji('🛫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛫</div>
                                                    <div wire:click="añadir_emoji('🛬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛬</div>
                                                    <div wire:click="añadir_emoji('🪂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪂</div>
                                                    <div wire:click="añadir_emoji('💺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💺</div>
                                                    <div wire:click="añadir_emoji('🛰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛰</div>
                                                    <div wire:click="añadir_emoji('🚀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚀</div>
                                                    <div wire:click="añadir_emoji('🛸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛸</div>
                                                    <div wire:click="añadir_emoji('🛶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛶</div>
                                                    <div wire:click="añadir_emoji('⛵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛵</div>
                                                    <div wire:click="añadir_emoji('🛥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛥</div>
                                                    <div wire:click="añadir_emoji('🚤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚤</div>
                                                    <div wire:click="añadir_emoji('⛴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛴</div>
                                                    <div wire:click="añadir_emoji('🛳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛳</div>
                                                    <div wire:click="añadir_emoji('🚢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚢</div>
                                                    <div wire:click="añadir_emoji('⚓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚓</div>
                                                    <div wire:click="añadir_emoji('⛽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛽</div>
                                                    <div wire:click="añadir_emoji('🚧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚧</div>
                                                    <div wire:click="añadir_emoji('🚏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚏</div>
                                                    <div wire:click="añadir_emoji('🚦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚦</div>
                                                    <div wire:click="añadir_emoji('🚥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚥</div>
                                                    <div wire:click="añadir_emoji('🛑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛑</div>
                                                    <div wire:click="añadir_emoji('🎡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎡</div>
                                                    <div wire:click="añadir_emoji('🎢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎢</div>
                                                    <div wire:click="añadir_emoji('🎠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎠</div>
                                                    <div wire:click="añadir_emoji('🏗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏗</div>
                                                    <div wire:click="añadir_emoji('🌁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌁</div>
                                                    <div wire:click="añadir_emoji('🗼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗼</div>
                                                    <div wire:click="añadir_emoji('🏭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏭</div>
                                                    <div wire:click="añadir_emoji('⛲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛲</div>
                                                    <div wire:click="añadir_emoji('🎑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎑</div>
                                                    <div wire:click="añadir_emoji('⛰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛰</div>
                                                    <div wire:click="añadir_emoji('🏔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏔</div>
                                                    <div wire:click="añadir_emoji('🗻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗻</div>
                                                    <div wire:click="añadir_emoji('🌋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌋</div>
                                                    <div wire:click="añadir_emoji('🗾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗾</div>
                                                    <div wire:click="añadir_emoji('🏕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏕</div>
                                                    <div wire:click="añadir_emoji('⛺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛺</div>
                                                    <div wire:click="añadir_emoji('🏞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏞</div>
                                                    <div wire:click="añadir_emoji('🛣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛣</div>
                                                    <div wire:click="añadir_emoji('🛤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛤</div>
                                                    <div wire:click="añadir_emoji('🌅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌅</div>
                                                    <div wire:click="añadir_emoji('🌄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌄</div>
                                                    <div wire:click="añadir_emoji('🏜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏜</div>
                                                    <div wire:click="añadir_emoji('🏖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏖</div>
                                                    <div wire:click="añadir_emoji('🏝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏝</div>
                                                    <div wire:click="añadir_emoji('🌇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌇</div>
                                                    <div wire:click="añadir_emoji('🌆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌆</div>
                                                    <div wire:click="añadir_emoji('🏙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏙</div>
                                                    <div wire:click="añadir_emoji('🌃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌃</div>
                                                    <div wire:click="añadir_emoji('🌉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌉</div>
                                                    <div wire:click="añadir_emoji('🌌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌌</div>
                                                    <div wire:click="añadir_emoji('🌠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌠</div>
                                                    <div wire:click="añadir_emoji('🎇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎇</div>
                                                    <div wire:click="añadir_emoji('🎆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎆</div>
                                                    <div wire:click="añadir_emoji('🏘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏘</div>
                                                    <div wire:click="añadir_emoji('🏰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏰</div>
                                                    <div wire:click="añadir_emoji('🏯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏯</div>
                                                    <div wire:click="añadir_emoji('🏟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏟</div>
                                                    <div wire:click="añadir_emoji('🗽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗽</div>
                                                    <div wire:click="añadir_emoji('🏠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏠</div>
                                                    <div wire:click="añadir_emoji('🏡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏡</div>
                                                    <div wire:click="añadir_emoji('🏚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏚</div>
                                                    <div wire:click="añadir_emoji('🏢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏢</div>
                                                    <div wire:click="añadir_emoji('🏬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏬</div>
                                                    <div wire:click="añadir_emoji('🏣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏣</div>
                                                    <div wire:click="añadir_emoji('🏤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏤</div>
                                                    <div wire:click="añadir_emoji('🏥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏥</div>
                                                    <div wire:click="añadir_emoji('🏦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏦</div>
                                                    <div wire:click="añadir_emoji('🏨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏨</div>
                                                    <div wire:click="añadir_emoji('🏪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏪</div>
                                                    <div wire:click="añadir_emoji('🏫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏫</div>
                                                    <div wire:click="añadir_emoji('🏩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏩</div>
                                                    <div wire:click="añadir_emoji('💒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💒</div>
                                                    <div wire:click="añadir_emoji('🏛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏛</div>
                                                    <div wire:click="añadir_emoji('⛪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛪</div>
                                                    <div wire:click="añadir_emoji('🕌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕌</div>
                                                    <div wire:click="añadir_emoji('🛕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛕</div>
                                                    <div wire:click="añadir_emoji('🕍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕍</div>
                                                    <div wire:click="añadir_emoji('🕋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕋</div>
                                                    <div wire:click="añadir_emoji('⛩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛩</div>
                                                    <div class="col-span-7 my-2">
                                                      <a name="Objetos">
                                                       <h3 class="px-2 mx-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Objetos</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('⌚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⌚</div>
                                                    <div wire:click="añadir_emoji('📱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📱</div>
                                                    <div wire:click="añadir_emoji('📲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📲</div>
                                                    <div wire:click="añadir_emoji('💻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💻</div>
                                                    <div wire:click="añadir_emoji('⌨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⌨</div>
                                                    <div wire:click="añadir_emoji('🖥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖥</div>
                                                    <div wire:click="añadir_emoji('🖨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖨</div>
                                                    <div wire:click="añadir_emoji('🖱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖱</div>
                                                    <div wire:click="añadir_emoji('🖲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖲</div>
                                                    <div wire:click="añadir_emoji('🕹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕹</div>
                                                    <div wire:click="añadir_emoji('🗜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗜</div>
                                                    <div wire:click="añadir_emoji('💽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💽</div>
                                                    <div wire:click="añadir_emoji('💾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💾</div>
                                                    <div wire:click="añadir_emoji('💿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💿</div>
                                                    <div wire:click="añadir_emoji('📀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📀</div>
                                                    <div wire:click="añadir_emoji('📼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📼</div>
                                                    <div wire:click="añadir_emoji('📷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📷</div>
                                                    <div wire:click="añadir_emoji('📸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📸</div>
                                                    <div wire:click="añadir_emoji('📹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📹</div>
                                                    <div wire:click="añadir_emoji('🎥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎥</div>
                                                    <div wire:click="añadir_emoji('📽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📽</div>
                                                    <div wire:click="añadir_emoji('🎞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎞</div>
                                                    <div wire:click="añadir_emoji('📞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📞</div>
                                                    <div wire:click="añadir_emoji('☎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☎</div>
                                                    <div wire:click="añadir_emoji('📟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📟</div>
                                                    <div wire:click="añadir_emoji('📠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📠</div>
                                                    <div wire:click="añadir_emoji('📺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📺</div>
                                                    <div wire:click="añadir_emoji('📻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📻</div>
                                                    <div wire:click="añadir_emoji('🎙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎙</div>
                                                    <div wire:click="añadir_emoji('🎚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎚</div>
                                                    <div wire:click="añadir_emoji('🎛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎛</div>
                                                    <div wire:click="añadir_emoji('⏱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏱</div>
                                                    <div wire:click="añadir_emoji('⏲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏲</div>
                                                    <div wire:click="añadir_emoji('⏰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏰</div>
                                                    <div wire:click="añadir_emoji('🕰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕰</div>
                                                    <div wire:click="añadir_emoji('⏳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏳</div>
                                                    <div wire:click="añadir_emoji('⌛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⌛</div>
                                                    <div wire:click="añadir_emoji('🧮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧮</div>
                                                    <div wire:click="añadir_emoji('📡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📡</div>
                                                    <div wire:click="añadir_emoji('🔋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔋</div>
                                                    <div wire:click="añadir_emoji('🔌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔌</div>
                                                    <div wire:click="añadir_emoji('💡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💡</div>
                                                    <div wire:click="añadir_emoji('🔦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔦</div>
                                                    <div wire:click="añadir_emoji('🕯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕯</div>
                                                    <div wire:click="añadir_emoji('🧯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧯</div>
                                                    <div wire:click="añadir_emoji('🗑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗑</div>
                                                    <div wire:click="añadir_emoji('🛢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛢</div>
                                                    <div wire:click="añadir_emoji('🛒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛒</div>
                                                    <div wire:click="añadir_emoji('💸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💸</div>
                                                    <div wire:click="añadir_emoji('💵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💵</div>
                                                    <div wire:click="añadir_emoji('💴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💴</div>
                                                    <div wire:click="añadir_emoji('💶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💶</div>
                                                    <div wire:click="añadir_emoji('💷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💷</div>
                                                    <div wire:click="añadir_emoji('💰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💰</div>
                                                    <div wire:click="añadir_emoji('💳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💳</div>
                                                    <div wire:click="añadir_emoji('🧾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧾</div>
                                                    <div wire:click="añadir_emoji('💎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💎</div>
                                                    <div wire:click="añadir_emoji('⚖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚖</div>
                                                    <div wire:click="añadir_emoji('🦯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦯</div>
                                                    <div wire:click="añadir_emoji('🧰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧰</div>
                                                    <div wire:click="añadir_emoji('🔧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔧</div>
                                                    <div wire:click="añadir_emoji('🔨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔨</div>
                                                    <div wire:click="añadir_emoji('⚒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚒</div>
                                                    <div wire:click="añadir_emoji('🛠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛠</div>
                                                    <div wire:click="añadir_emoji('⛏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛏</div>
                                                    <div wire:click="añadir_emoji('🪓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪓</div>
                                                    <div wire:click="añadir_emoji('🔩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔩</div>
                                                    <div wire:click="añadir_emoji('⚙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚙</div>
                                                    <div wire:click="añadir_emoji('⛓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛓</div>
                                                    <div wire:click="añadir_emoji('🧱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧱</div>
                                                    <div wire:click="añadir_emoji('🔫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔫</div>
                                                    <div wire:click="añadir_emoji('🧨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧨</div>
                                                    <div wire:click="añadir_emoji('💣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💣</div>
                                                    <div wire:click="añadir_emoji('🔪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔪</div>
                                                    <div wire:click="añadir_emoji('🗡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗡</div>
                                                    <div wire:click="añadir_emoji('⚔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚔</div>
                                                    <div wire:click="añadir_emoji('🛡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛡</div>
                                                    <div wire:click="añadir_emoji('🚬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚬</div>
                                                    <div wire:click="añadir_emoji('⚰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚰</div>
                                                    <div wire:click="añadir_emoji('⚱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚱</div>
                                                    <div wire:click="añadir_emoji('🏺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏺</div>
                                                    <div wire:click="añadir_emoji('🔮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔮</div>
                                                    <div wire:click="añadir_emoji('📿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📿</div>
                                                    <div wire:click="añadir_emoji('🧿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧿</div>
                                                    <div wire:click="añadir_emoji('💈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💈</div>
                                                    <div wire:click="añadir_emoji('🧲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧲</div>
                                                    <div wire:click="añadir_emoji('⚗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚗</div>
                                                    <div wire:click="añadir_emoji('🧪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧪</div>
                                                    <div wire:click="añadir_emoji('🧫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧫</div>
                                                    <div wire:click="añadir_emoji('🧬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧬</div>
                                                    <div wire:click="añadir_emoji('🔭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔭</div>
                                                    <div wire:click="añadir_emoji('🔬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔬</div>
                                                    <div wire:click="añadir_emoji('🕳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕳</div>
                                                    <div wire:click="añadir_emoji('💊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💊</div>
                                                    <div wire:click="añadir_emoji('💉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💉</div>
                                                    <div wire:click="añadir_emoji('🩸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩸</div>
                                                    <div wire:click="añadir_emoji('🩹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩹</div>
                                                    <div wire:click="añadir_emoji('🩺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩺</div>
                                                    <div wire:click="añadir_emoji('🌡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌡</div>
                                                    <div wire:click="añadir_emoji('🏷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏷</div>
                                                    <div wire:click="añadir_emoji('🔖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔖</div>
                                                    <div wire:click="añadir_emoji('🚽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚽</div>
                                                    <div wire:click="añadir_emoji('🚿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚿</div>
                                                    <div wire:click="añadir_emoji('🛁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛁</div>
                                                    <div wire:click="añadir_emoji('🛀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛀</div>
                                                    <div wire:click="añadir_emoji('🪒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪒</div>
                                                    <div wire:click="añadir_emoji('🧴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧴</div>
                                                    <div wire:click="añadir_emoji('🧻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧻</div>
                                                    <div wire:click="añadir_emoji('🧼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧼</div>
                                                    <div wire:click="añadir_emoji('🧽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧽</div>
                                                    <div wire:click="añadir_emoji('🧹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧹</div>
                                                    <div wire:click="añadir_emoji('🧺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧺</div>
                                                    <div wire:click="añadir_emoji('🔑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔑</div>
                                                    <div wire:click="añadir_emoji('🗝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗝</div>
                                                    <div wire:click="añadir_emoji('🛋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛋</div>
                                                    <div wire:click="añadir_emoji('🪑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪑</div>
                                                    <div wire:click="añadir_emoji('🛌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛌</div>
                                                    <div wire:click="añadir_emoji('🛏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛏</div>
                                                    <div wire:click="añadir_emoji('🚪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚪</div>
                                                    <div wire:click="añadir_emoji('🧳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧳</div>
                                                    <div wire:click="añadir_emoji('🛎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛎</div>
                                                    <div wire:click="añadir_emoji('🖼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖼</div>
                                                    <div wire:click="añadir_emoji('🧭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧭</div>
                                                    <div wire:click="añadir_emoji('🗺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗺</div>
                                                    <div wire:click="añadir_emoji('⛱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛱</div>
                                                    <div wire:click="añadir_emoji('🗿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗿</div>
                                                    <div wire:click="añadir_emoji('🛍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛍</div>
                                                    <div wire:click="añadir_emoji('🎈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎈</div>
                                                    <div wire:click="añadir_emoji('🎏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎏</div>
                                                    <div wire:click="añadir_emoji('🎀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎀</div>
                                                    <div wire:click="añadir_emoji('🧧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧧</div>
                                                    <div wire:click="añadir_emoji('🎁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎁</div>
                                                    <div wire:click="añadir_emoji('🎊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎊</div>
                                                    <div wire:click="añadir_emoji('🎉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎉</div>
                                                    <div wire:click="añadir_emoji('🎎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎎</div>
                                                    <div wire:click="añadir_emoji('🎐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎐</div>
                                                    <div wire:click="añadir_emoji('🏮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏮</div>
                                                    <div wire:click="añadir_emoji('🪔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🪔</div>
                                                    <div wire:click="añadir_emoji('✉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✉</div>
                                                    <div wire:click="añadir_emoji('📩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📩</div>
                                                    <div wire:click="añadir_emoji('📨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📨</div>
                                                    <div wire:click="añadir_emoji('📧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📧</div>
                                                    <div wire:click="añadir_emoji('💌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💌</div>
                                                    <div wire:click="añadir_emoji('📮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📮</div>
                                                    <div wire:click="añadir_emoji('📪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📪</div>
                                                    <div wire:click="añadir_emoji('📫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📫</div>
                                                    <div wire:click="añadir_emoji('📬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📬</div>
                                                    <div wire:click="añadir_emoji('📭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📭</div>
                                                    <div wire:click="añadir_emoji('📦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📦</div>
                                                    <div wire:click="añadir_emoji('📯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📯</div>
                                                    <div wire:click="añadir_emoji('📥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📥</div>
                                                    <div wire:click="añadir_emoji('📜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📜</div>
                                                    <div wire:click="añadir_emoji('📃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📃</div>
                                                    <div wire:click="añadir_emoji('📑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📑</div>
                                                    <div wire:click="añadir_emoji('📊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📊</div>
                                                    <div wire:click="añadir_emoji('📈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📈</div>
                                                    <div wire:click="añadir_emoji('📉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📉</div>
                                                    <div wire:click="añadir_emoji('📄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📄</div>
                                                    <div wire:click="añadir_emoji('📅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📅</div>
                                                    <div wire:click="añadir_emoji('📆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📆</div>
                                                    <div wire:click="añadir_emoji('🗓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗓</div>
                                                    <div wire:click="añadir_emoji('📇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📇</div>
                                                    <div wire:click="añadir_emoji('🗃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗃</div>
                                                    <div wire:click="añadir_emoji('🗳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗳</div>
                                                    <div wire:click="añadir_emoji('🗄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗄</div>
                                                    <div wire:click="añadir_emoji('📋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📋</div>
                                                    <div wire:click="añadir_emoji('🗒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗒</div>
                                                    <div wire:click="añadir_emoji('📁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📁</div>
                                                    <div wire:click="añadir_emoji('📂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📂</div>
                                                    <div wire:click="añadir_emoji('🗂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗂</div>
                                                    <div wire:click="añadir_emoji('🗞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗞</div>
                                                    <div wire:click="añadir_emoji('📰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📰</div>
                                                    <div wire:click="añadir_emoji('📓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📓</div>
                                                    <div wire:click="añadir_emoji('📕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📕</div>
                                                    <div wire:click="añadir_emoji('📗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📗</div>
                                                    <div wire:click="añadir_emoji('📘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📘</div>
                                                    <div wire:click="añadir_emoji('📙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📙</div>
                                                    <div wire:click="añadir_emoji('📔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📔</div>
                                                    <div wire:click="añadir_emoji('📒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📒</div>
                                                    <div wire:click="añadir_emoji('📚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📚</div>
                                                    <div wire:click="añadir_emoji('📖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📖</div>
                                                    <div wire:click="añadir_emoji('🔗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔗</div>
                                                    <div wire:click="añadir_emoji('📎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📎</div>
                                                    <div wire:click="añadir_emoji('🖇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖇</div>
                                                    <div wire:click="añadir_emoji('✂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✂</div>
                                                    <div wire:click="añadir_emoji('📐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📐</div>
                                                    <div wire:click="añadir_emoji('📏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📏</div>
                                                    <div wire:click="añadir_emoji('📌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📌</div>
                                                    <div wire:click="añadir_emoji('📍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📍</div>
                                                    <div wire:click="añadir_emoji('🧷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧷</div>
                                                    <div wire:click="añadir_emoji('🧵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧵</div>
                                                    <div wire:click="añadir_emoji('🧶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧶</div>
                                                    <div wire:click="añadir_emoji('🔐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔐</div>
                                                    <div wire:click="añadir_emoji('🔒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔒</div>
                                                    <div wire:click="añadir_emoji('🔓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔓</div>
                                                    <div wire:click="añadir_emoji('🔏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔏</div>
                                                    <div wire:click="añadir_emoji('🖊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖊</div>
                                                    <div wire:click="añadir_emoji('🖋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖋</div>
                                                    <div wire:click="añadir_emoji('✒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✒</div>
                                                    <div wire:click="añadir_emoji('📝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📝</div>
                                                    <div wire:click="añadir_emoji('✏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✏</div>
                                                    <div wire:click="añadir_emoji('🖍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖍</div>
                                                    <div wire:click="añadir_emoji('🖌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🖌</div>
                                                    <div wire:click="añadir_emoji('🔍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔍</div>
                                                    <div wire:click="añadir_emoji('👚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👚</div>
                                                    <div wire:click="añadir_emoji('👕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👕</div>
                                                    <div wire:click="añadir_emoji('🥼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥼</div>
                                                    <div wire:click="añadir_emoji('🦺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🦺</div>
                                                    <div wire:click="añadir_emoji('🧥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧥</div>
                                                    <div wire:click="añadir_emoji('👖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👖</div>
                                                    <div wire:click="añadir_emoji('👔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👔</div>
                                                    <div wire:click="añadir_emoji('👗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👗</div>
                                                    <div wire:click="añadir_emoji('👘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👘</div>
                                                    <div wire:click="añadir_emoji('🥻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥻</div>
                                                    <div wire:click="añadir_emoji('🩱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩱</div>
                                                    <div wire:click="añadir_emoji('👙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👙</div>
                                                    <div wire:click="añadir_emoji('🩲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩲</div>
                                                    <div wire:click="añadir_emoji('🩳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩳</div>
                                                    <div wire:click="añadir_emoji('💄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💄</div>
                                                    <div wire:click="añadir_emoji('💋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💋</div>
                                                    <div wire:click="añadir_emoji('👣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👣</div>
                                                    <div wire:click="añadir_emoji('🧦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧦</div>
                                                    <div wire:click="añadir_emoji('👠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👠</div>
                                                    <div wire:click="añadir_emoji('👡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👡</div>
                                                    <div wire:click="añadir_emoji('👢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👢</div>
                                                    <div wire:click="añadir_emoji('🥿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥿</div>
                                                    <div wire:click="añadir_emoji('👞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👞</div>
                                                    <div wire:click="añadir_emoji('👟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👟</div>
                                                    <div wire:click="añadir_emoji('🩰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🩰</div>
                                                    <div wire:click="añadir_emoji('🥾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥾</div>
                                                    <div wire:click="añadir_emoji('🧢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧢</div>
                                                    <div wire:click="añadir_emoji('👒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👒</div>
                                                    <div wire:click="añadir_emoji('🎩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎩</div>
                                                    <div wire:click="añadir_emoji('🎓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎓</div>
                                                    <div wire:click="añadir_emoji('👑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👑</div>
                                                    <div wire:click="añadir_emoji('⛑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛑</div>
                                                    <div wire:click="añadir_emoji('🎒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎒</div>
                                                    <div wire:click="añadir_emoji('👝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👝</div>
                                                    <div wire:click="añadir_emoji('👛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👛</div>
                                                    <div wire:click="añadir_emoji('👜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👜</div>
                                                    <div wire:click="añadir_emoji('💼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💼</div>
                                                    <div wire:click="añadir_emoji('👓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👓</div>
                                                    <div wire:click="añadir_emoji('🕶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕶</div>
                                                    <div wire:click="añadir_emoji('🥽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🥽</div>
                                                    <div wire:click="añadir_emoji('🧣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧣</div>
                                                    <div wire:click="añadir_emoji('🧤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🧤</div>
                                                    <div wire:click="añadir_emoji('💍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💍</div>
                                                    <div wire:click="añadir_emoji('🌂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌂</div>
                                                    <div wire:click="añadir_emoji('☂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☂</div>
                                                    <div class="col-span-7 my-2">
                                                      <a name="Simbolos">
                                                       <h3 class="px-2 mx-2 text-base font-extrabold text-center uppercase border-b border-blue-200">Símbolos</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('☮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☮</div>
                                                    <div wire:click="añadir_emoji('✝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✝</div>
                                                    <div wire:click="añadir_emoji('☪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☪</div>
                                                    <div wire:click="añadir_emoji('🕉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕉</div>
                                                    <div wire:click="añadir_emoji('☸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☸</div>
                                                    <div wire:click="añadir_emoji('✡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✡</div>
                                                    <div wire:click="añadir_emoji('🕎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕎</div>
                                                    <div wire:click="añadir_emoji('☯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☯</div>
                                                    <div wire:click="añadir_emoji('☦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☦</div>
                                                    <div wire:click="añadir_emoji('🛐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛐</div>
                                                    <div wire:click="añadir_emoji('⛎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛎</div>
                                                    <div wire:click="añadir_emoji('♈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♈</div>
                                                    <div wire:click="añadir_emoji('♉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♉</div>
                                                    <div wire:click="añadir_emoji('♊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♊</div>
                                                    <div wire:click="añadir_emoji('♋')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♋</div>
                                                    <div wire:click="añadir_emoji('♌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♌</div>
                                                    <div wire:click="añadir_emoji('♍')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♍</div>
                                                    <div wire:click="añadir_emoji('♎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♎</div>
                                                    <div wire:click="añadir_emoji('♏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♏</div>
                                                    <div wire:click="añadir_emoji('♐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♐</div>
                                                    <div wire:click="añadir_emoji('♑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♑</div>
                                                    <div wire:click="añadir_emoji('♒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♒</div>
                                                    <div wire:click="añadir_emoji('♓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♓</div>
                                                    <div wire:click="añadir_emoji('🆔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆔</div>
                                                    <div wire:click="añadir_emoji('⚛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚛</div>
                                                    <div wire:click="añadir_emoji('⚕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚕</div>
                                                    <div wire:click="añadir_emoji('☢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☢</div>
                                                    <div wire:click="añadir_emoji('☣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☣</div>
                                                    <div wire:click="añadir_emoji('📴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📴</div>
                                                    <div wire:click="añadir_emoji('📳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📳</div>
                                                    <div wire:click="añadir_emoji('🈶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈶</div>
                                                    <div wire:click="añadir_emoji('🈚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈚</div>
                                                    <div wire:click="añadir_emoji('🈸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈸</div>
                                                    <div wire:click="añadir_emoji('🈺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈺</div>
                                                    <div wire:click="añadir_emoji('🈷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈷</div>
                                                    <div wire:click="añadir_emoji('✴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✴</div>
                                                    <div wire:click="añadir_emoji('🆚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆚</div>
                                                    <div wire:click="añadir_emoji('🉑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🉑</div>
                                                    <div wire:click="añadir_emoji('💮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💮</div>
                                                    <div wire:click="añadir_emoji('🉐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🉐</div>
                                                    <div wire:click="añadir_emoji('㊙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">㊙</div>
                                                    <div wire:click="añadir_emoji('㊗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">㊗</div>
                                                    <div wire:click="añadir_emoji('🈴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈴</div>
                                                    <div wire:click="añadir_emoji('🈵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈵</div>
                                                    <div wire:click="añadir_emoji('🈹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈹</div>
                                                    <div wire:click="añadir_emoji('🈲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈲</div>
                                                    <div wire:click="añadir_emoji('🅰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🅰</div>
                                                    <div wire:click="añadir_emoji('🅱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🅱</div>
                                                    <div wire:click="añadir_emoji('🆎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆎</div>
                                                    <div wire:click="añadir_emoji('🆑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆑</div>
                                                    <div wire:click="añadir_emoji('🅾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🅾</div>
                                                    <div wire:click="añadir_emoji('🆘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆘</div>
                                                    <div wire:click="añadir_emoji('⛔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⛔</div>
                                                    <div wire:click="añadir_emoji('📛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📛</div>
                                                    <div wire:click="añadir_emoji('🚫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚫</div>
                                                    <div wire:click="añadir_emoji('❌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❌</div>
                                                    <div wire:click="añadir_emoji('⭕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⭕</div>
                                                    <div wire:click="añadir_emoji('💢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💢</div>
                                                    <div wire:click="añadir_emoji('♨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♨</div>
                                                    <div wire:click="añadir_emoji('🚷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚷</div>
                                                    <div wire:click="añadir_emoji('🚯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚯</div>
                                                    <div wire:click="añadir_emoji('🚳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚳</div>
                                                    <div wire:click="añadir_emoji('🚱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚱</div>
                                                    <div wire:click="añadir_emoji('🔞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔞</div>
                                                    <div wire:click="añadir_emoji('📵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📵</div>
                                                    <div wire:click="añadir_emoji('🚭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚭</div>
                                                    <div wire:click="añadir_emoji('❗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❗</div>
                                                    <div wire:click="añadir_emoji('❕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❕</div>
                                                    <div wire:click="añadir_emoji('❓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❓</div>
                                                    <div wire:click="añadir_emoji('❔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❔</div>
                                                    <div wire:click="añadir_emoji('‼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">‼</div>
                                                    <div wire:click="añadir_emoji('⁉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⁉</div>
                                                    <div wire:click="añadir_emoji('💯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💯</div>
                                                    <div wire:click="añadir_emoji('🔅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔅</div>
                                                    <div wire:click="añadir_emoji('🔆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔆</div>
                                                    <div wire:click="añadir_emoji('🔱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔱</div>
                                                    <div wire:click="añadir_emoji('⚜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚜</div>
                                                    <div wire:click="añadir_emoji('〽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">〽</div>
                                                    <div wire:click="añadir_emoji('⚠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚠</div>
                                                    <div wire:click="añadir_emoji('🚸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚸</div>
                                                    <div wire:click="añadir_emoji('🔰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔰</div>
                                                    <div wire:click="añadir_emoji('♻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♻</div>
                                                    <div wire:click="añadir_emoji('🈯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈯</div>
                                                    <div wire:click="añadir_emoji('💹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💹</div>
                                                    <div wire:click="añadir_emoji('❇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❇</div>
                                                    <div wire:click="añadir_emoji('❎')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">❎</div>
                                                    <div wire:click="añadir_emoji('✅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✅</div>
                                                    <div wire:click="añadir_emoji('💠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💠</div>
                                                    <div wire:click="añadir_emoji('🌀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌀</div>
                                                    <div wire:click="añadir_emoji('➿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">➿</div>
                                                    <div wire:click="añadir_emoji('🌐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🌐</div>
                                                    <div wire:click="añadir_emoji('♾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♾</div>
                                                    <div wire:click="añadir_emoji('Ⓜ')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">Ⓜ</div>
                                                    <div wire:click="añadir_emoji('🏧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏧</div>
                                                    <div wire:click="añadir_emoji('🚾')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚾</div>
                                                    <div wire:click="añadir_emoji('♿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♿</div>
                                                    <div wire:click="añadir_emoji('🅿')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🅿</div>
                                                    <div wire:click="añadir_emoji('🈳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈳</div>
                                                    <div wire:click="añadir_emoji('🈂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈂</div>
                                                    <div wire:click="añadir_emoji('🛂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛂</div>
                                                    <div wire:click="añadir_emoji('🛃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛃</div>
                                                    <div wire:click="añadir_emoji('🛄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛄</div>
                                                    <div wire:click="añadir_emoji('🚰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚰</div>
                                                    <div wire:click="añadir_emoji('🛗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🛗</div>
                                                    <div wire:click="añadir_emoji('🚹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚹</div>
                                                    <div wire:click="añadir_emoji('♂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♂</div>
                                                    <div wire:click="añadir_emoji('🚺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚺</div>
                                                    <div wire:click="añadir_emoji('♀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♀</div>
                                                    <div wire:click="añadir_emoji('⚧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚧</div>
                                                    <div wire:click="añadir_emoji('🚼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚼</div>
                                                    <div wire:click="añadir_emoji('🚻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚻</div>
                                                    <div wire:click="añadir_emoji('🚮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚮</div>
                                                    <div wire:click="añadir_emoji('🎦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎦</div>
                                                    <div wire:click="añadir_emoji('📶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📶</div>
                                                    <div wire:click="añadir_emoji('🈁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🈁</div>
                                                    <div wire:click="añadir_emoji('🆖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆖</div>
                                                    <div wire:click="añadir_emoji('🆗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆗</div>
                                                    <div wire:click="añadir_emoji('🆙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆙</div>
                                                    <div wire:click="añadir_emoji('🆒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆒</div>
                                                    <div wire:click="añadir_emoji('🆕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆕</div>
                                                    <div wire:click="añadir_emoji('🆓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🆓</div>
                                                    <div wire:click="añadir_emoji('0⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">0⃣</div>
                                                    <div wire:click="añadir_emoji('1⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">1⃣</div>
                                                    <div wire:click="añadir_emoji('2⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">2⃣</div>
                                                    <div wire:click="añadir_emoji('3⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">3⃣</div>
                                                    <div wire:click="añadir_emoji('4⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">4⃣</div>
                                                    <div wire:click="añadir_emoji('5⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">5⃣</div>
                                                    <div wire:click="añadir_emoji('6⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">6⃣</div>
                                                    <div wire:click="añadir_emoji('7⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">7⃣</div>
                                                    <div wire:click="añadir_emoji('8⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">8⃣</div>
                                                    <div wire:click="añadir_emoji('9⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">9⃣</div>
                                                    <div wire:click="añadir_emoji('🔟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔟</div>
                                                    <div wire:click="añadir_emoji('🔢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔢</div>
                                                    <div wire:click="añadir_emoji('▶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">▶</div>
                                                    <div wire:click="añadir_emoji('⏸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏸</div>
                                                    <div wire:click="añadir_emoji('⏯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏯</div>
                                                    <div wire:click="añadir_emoji('⏹')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏹</div>
                                                    <div wire:click="añadir_emoji('⏺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏺</div>
                                                    <div wire:click="añadir_emoji('⏏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏏</div>
                                                    <div wire:click="añadir_emoji('⏭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏭</div>
                                                    <div wire:click="añadir_emoji('⏮')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏮</div>
                                                    <div wire:click="añadir_emoji('⏩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏩</div>
                                                    <div wire:click="añadir_emoji('⏪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏪</div>
                                                    <div wire:click="añadir_emoji('🔀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔀</div>
                                                    <div wire:click="añadir_emoji('🔁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔁</div>
                                                    <div wire:click="añadir_emoji('🔂')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔂</div>
                                                    <div wire:click="añadir_emoji('◀')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">◀</div>
                                                    <div wire:click="añadir_emoji('🔼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔼</div>
                                                    <div wire:click="añadir_emoji('🔽')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔽</div>
                                                    <div wire:click="añadir_emoji('⏫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏫</div>
                                                    <div wire:click="añadir_emoji('⏬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⏬</div>
                                                    <div wire:click="añadir_emoji('➡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">➡</div>
                                                    <div wire:click="añadir_emoji('⬅')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⬅</div>
                                                    <div wire:click="añadir_emoji('⬆')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⬆</div>
                                                    <div wire:click="añadir_emoji('⬇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⬇</div>
                                                    <div wire:click="añadir_emoji('↗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↗</div>
                                                    <div wire:click="añadir_emoji('↘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↘</div>
                                                    <div wire:click="añadir_emoji('↙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↙</div>
                                                    <div wire:click="añadir_emoji('↖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↖</div>
                                                    <div wire:click="añadir_emoji('↕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↕</div>
                                                    <div wire:click="añadir_emoji('↔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↔</div>
                                                    <div wire:click="añadir_emoji('🔄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔄</div>
                                                    <div wire:click="añadir_emoji('↪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↪</div>
                                                    <div wire:click="añadir_emoji('↩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">↩</div>
                                                    <div wire:click="añadir_emoji('🔃')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔃</div>
                                                    <div wire:click="añadir_emoji('⤴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⤴</div>
                                                    <div wire:click="añadir_emoji('⤵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⤵</div>
                                                    <div wire:click="añadir_emoji('#⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">#⃣</div>
                                                    <div wire:click="añadir_emoji('*⃣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">*⃣</div>
                                                    <div wire:click="añadir_emoji('ℹ')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">ℹ</div>
                                                    <div wire:click="añadir_emoji('🔤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔤</div>
                                                    <div wire:click="añadir_emoji('🔡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔡</div>
                                                    <div wire:click="añadir_emoji('🔠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔠</div>
                                                    <div wire:click="añadir_emoji('🔣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔣</div>
                                                    <div wire:click="añadir_emoji('🎵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎵</div>
                                                    <div wire:click="añadir_emoji('🎶')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎶</div>
                                                    <div wire:click="añadir_emoji('〰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">〰</div>
                                                    <div wire:click="añadir_emoji('➰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">➰</div>
                                                    <div wire:click="añadir_emoji('✔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✔</div>
                                                    <div wire:click="añadir_emoji('➕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">➕</div>
                                                    <div wire:click="añadir_emoji('➖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">➖</div>
                                                    <div wire:click="añadir_emoji('➗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">➗</div>
                                                    <div wire:click="añadir_emoji('✖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">✖</div>
                                                    <div wire:click="añadir_emoji('🟰')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟰</div>
                                                    <div wire:click="añadir_emoji('💲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💲</div>
                                                    <div wire:click="añadir_emoji('💱')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💱</div>
                                                    <div wire:click="añadir_emoji('©')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">©</div>
                                                    <div wire:click="añadir_emoji('®')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">®</div>
                                                    <div wire:click="añadir_emoji('™')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">™</div>
                                                    <div wire:click="añadir_emoji('🔚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔚</div>
                                                    <div wire:click="añadir_emoji('🔙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔙</div>
                                                    <div wire:click="añadir_emoji('🔛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔛</div>
                                                    <div wire:click="añadir_emoji('🔝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔝</div>
                                                    <div wire:click="añadir_emoji('🔜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔜</div>
                                                    <div wire:click="añadir_emoji('☑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">☑</div>
                                                    <div wire:click="añadir_emoji('🔘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔘</div>
                                                    <div wire:click="añadir_emoji('🔴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔴</div>
                                                    <div wire:click="añadir_emoji('🟠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟠</div>
                                                    <div wire:click="añadir_emoji('🟡')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟡</div>
                                                    <div wire:click="añadir_emoji('🟢')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟢</div>
                                                    <div wire:click="añadir_emoji('🔵')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔵</div>
                                                    <div wire:click="añadir_emoji('🟣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟣</div>
                                                    <div wire:click="añadir_emoji('🟤')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟤</div>
                                                    <div wire:click="añadir_emoji('⚫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚫</div>
                                                    <div wire:click="añadir_emoji('⚪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⚪</div>
                                                    <div wire:click="añadir_emoji('🟥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟥</div>
                                                    <div wire:click="añadir_emoji('🟧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟧</div>
                                                    <div wire:click="añadir_emoji('🟨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟨</div>
                                                    <div wire:click="añadir_emoji('🟩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟩</div>
                                                    <div wire:click="añadir_emoji('🟦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟦</div>
                                                    <div wire:click="añadir_emoji('🟪')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟪</div>
                                                    <div wire:click="añadir_emoji('🟫')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🟫</div>
                                                    <div wire:click="añadir_emoji('⬛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⬛</div>
                                                    <div wire:click="añadir_emoji('⬜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">⬜</div>
                                                    <div wire:click="añadir_emoji('◼')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">◼</div>
                                                    <div wire:click="añadir_emoji('◻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">◻</div>
                                                    <div wire:click="añadir_emoji('🔸')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔸</div>
                                                    <div wire:click="añadir_emoji('🔷')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔷</div>
                                                    <div wire:click="añadir_emoji('🔺')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔺</div>
                                                    <div wire:click="añadir_emoji('🔻')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔻</div>
                                                    <div wire:click="añadir_emoji('🔲')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔲</div>
                                                    <div wire:click="añadir_emoji('🔈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔈</div>
                                                    <div wire:click="añadir_emoji('🔉')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔉</div>
                                                    <div wire:click="añadir_emoji('🔊')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔊</div>
                                                    <div wire:click="añadir_emoji('🔇')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔇</div>
                                                    <div wire:click="añadir_emoji('📣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">📣</div>
                                                    <div wire:click="añadir_emoji('🔔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔔</div>
                                                    <div wire:click="añadir_emoji('🔕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🔕</div>
                                                    <div wire:click="añadir_emoji('🃏')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🃏</div>
                                                    <div wire:click="añadir_emoji('🀄')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🀄</div>
                                                    <div wire:click="añadir_emoji('♠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♠</div>
                                                    <div wire:click="añadir_emoji('♣')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♣</div>
                                                    <div wire:click="añadir_emoji('♥')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♥</div>
                                                    <div wire:click="añadir_emoji('♦')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">♦</div>
                                                    <div wire:click="añadir_emoji('🎴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎴</div>
                                                    <div wire:click="añadir_emoji('👁‍🗨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">👁‍🗨</div>
                                                    <div wire:click="añadir_emoji('🗨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗨</div>
                                                    <div wire:click="añadir_emoji('💭')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💭</div>
                                                    <div wire:click="añadir_emoji('🗯')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🗯</div>
                                                    <div wire:click="añadir_emoji('💬')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">💬</div>
                                                    <div wire:click="añadir_emoji('🕐')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕐</div>
                                                    <div wire:click="añadir_emoji('🕑')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕑</div>
                                                    <div wire:click="añadir_emoji('🕒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕒</div>
                                                    <div wire:click="añadir_emoji('🕒')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕒</div>
                                                    <div wire:click="añadir_emoji('🕓')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕓</div>
                                                    <div wire:click="añadir_emoji('🕔')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕔</div>
                                                    <div wire:click="añadir_emoji('🕕')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕕</div>
                                                    <div wire:click="añadir_emoji('🕖')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕖</div>
                                                    <div wire:click="añadir_emoji('🕗')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕗</div>
                                                    <div wire:click="añadir_emoji('🕘')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕘</div>
                                                    <div wire:click="añadir_emoji('🕙')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕙</div>
                                                    <div wire:click="añadir_emoji('🕚')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕚</div>
                                                    <div wire:click="añadir_emoji('🕛')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕛</div>
                                                    <div wire:click="añadir_emoji('🕜')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕜</div>
                                                    <div wire:click="añadir_emoji('🕝')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕝</div>
                                                    <div wire:click="añadir_emoji('🕞')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕞</div>
                                                    <div wire:click="añadir_emoji('🕟')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕟</div>
                                                    <div wire:click="añadir_emoji('🕠')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕠</div>
                                                    <div wire:click="añadir_emoji('🕧')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🕧</div>
                                                    {{-- <div class="col-span-7 my-2">
                                                      <a name="Banderas">
                                                       <h3 class="px-2 mx-2 text-lg font-extrabold  text-justify uppercase border-b border-blue-200">Banderas</h3>
                                                      </a>
                                                    </div>
                                                    <div wire:click="añadir_emoji('🏳')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏳</div>
                                                    <div wire:click="añadir_emoji('🏴')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏴</div>
                                                    <div wire:click="añadir_emoji('🏁')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏁</div>
                                                    <div wire:click="añadir_emoji('🚩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🚩</div>
                                                    <div wire:click="añadir_emoji('🎌')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🎌</div>
                                                    <div wire:click="añadir_emoji('🏴‍☠️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏴‍☠️</div>
                                                    <div wire:click="añadir_emoji('🏳️‍🌈')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏳️‍🌈</div>
                                                    <div wire:click="añadir_emoji('🏳️')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🏳️</div>
                                                    <div wire:click="añadir_emoji('🇦🇨')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🇦🇨</div>
                                                    <div wire:click="añadir_emoji('🇦🇩')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 ">🇦🇩</div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div>
                                                    <div wire:click="añadir_emoji('')" class="text-3xl text-center transition duration-500 rounded-full cursor-pointer hover:opacity-50 "></div> --}}
                            </div>
                      </div>
                      <div class="flex items-center justify-center bg-gray-200 border-2 border-gray-100 rounded-b-lg">
                          <div class="grid w-full grid-cols-7 px-2">
                            <div title="Sonrisas y Personas">
                             <a href="#sonrisas_y_personas">
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg> --}}
                                <i class="fa-solid fa-face-grin-beam-sweat"></i>
                             </a>
                            </div>
                            <div title="Animales y Naturaleza">
                              <a href="#animales_y_naturaleza">
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                   </svg> --}}
                                   <i class="fa-solid fa-dog"></i>
                              </a>
                            </div>
                            <div title="Comida y Bebida">
                              <a href="#comida_y_bebida">
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                   </svg> --}}
                                   <i class="fa-solid fa-bowl-food"></i>
                              </a>
                            </div>
                            <div title="Actividades">
                              <a href="#actividades" alt="actividades">
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                   </svg> --}}
                                   <i class="fa-solid fa-person-swimming"></i>
                              </a>
                            </div>
                            <div title="Viajes y Lugares">
                              <a href="#Viajes_y_lugares" >
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                   </svg> --}}
                                   <i class="fa-solid fa-car-on"></i>
                              </a>
                            </div>
                            <div title="Objetos">
                              <a href="#Objetos" >
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                   </svg> --}}
                                   <i class="fa-solid fa-mobile-retro"></i>
                              </a>
                            </div>
                            <div title="Simbolos">
                              <a href="#Simbolos" >
                                {{-- <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                   </svg> --}}
                                   <i class="fa-solid fa-wheelchair-move"></i>
                              </a>
                            </div>
                            {{-- <div title="Banderas">
                              <a href="#Banderas" >
                                <i class="fa-solid fa-building-flag"></i>
                              </a>
                            </div> --}}
                          </div>
                      </div>


                    </div>
                    </div>
                    {{--ENDEMOJIS--}}


                </div>
              </div>
            </div>

            <div class="flex items-center justify-center  w-full">
                <button
                  type="submit"
                  :class="btn_add_publicacion ? 'bg-blue-600 hover:bg-blue-800 ': 'cursor-not-allowed opacity-25 bg-gray-500' "
                  class="w-full px-4 py-1 mb-2 font-medium text-white transition duration-500  rounded  focus:outline-none focus:ring-gray-200 focus:border-transparent  focus:ring-2 "
                  wire:click="publicar"
                  >
                 PUBLICAR
                </button>
            </div>

        </div>

    </div>

</x-modal>
<x-modal_fotos_publicacion wire:model="modal_fotos_publicacion">
 @if ($this->indice_publicacion)
    <div x-data="{
        like:false,
        like_imgs:false,
        peopleliked:false,
        peopleliked_imgs:false,
        people_coment_imgs:false,
        leer_mas:true,
        leer_menos:false,
        sileemas() {
                    if (this.leer_mas) {
       this.leer_mas=false;
       this.leer_menos=true;
                    }
        },
        sileemenos(){
                    if (this.leer_menos) {
                        this.leer_menos=false;
                        this.leer_mas=true;
                    }
        },
        }"

        class="relative">

        <div wire:click="cerrar_modal_imagenes()" class="absolute px-4 text-xl  py-2 font-extrabold cursor-pointer  bg-white border-2 border-gray-300 rounded-full top-10 left-2 z-50">
            <i class="fa-solid fa-xmark"></i>
        </div>

        <div class="flex mt-6">

          <div class="grid   sm:grid-cols-2  md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 2xl:grid-cols-1 ">

            {{--SECCION IMAGENES--}}
            <div class=" md:w-4/5 lg:w-4/5  xl:w-4/5 2xl:w-4/5 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 m-auto">

                <div class="overflow-x-auto w-full relative overflow-y-hidden m-auto" style="height:770px">
                    <div class="flex  m-auto overflow-y-hidden" style="width:400px;height:770px;max-height: 770px;">
                        @for ($i=$this->indice_img;$i<count($indice_publicacion->imagenes);$i++)

                            <img class="w-full h-full object-contain m-auto" src="{{$indice_publicacion->imagenes[$i]->url}}">

                        @endfor
                    </div>

                    @if ($indice_publicacion->imagenes->count()>1)

                    @if ($this->indice_img>0)

                    <div wire:click="atras()" class="absolute left-0 cursor-pointer opacity-10 hover:opacity-50 transition duration-700" style="top: 50%"  id="slider_left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-200 transition duration-700 hover:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>

                    @endif

                    @if ($this->indice_img < ($this->indice_publicacion->imagenes->count()-1))

                    <div  wire:click="adelante()" class="absolute right-0 cursor-pointer opacity-10 hover:opacity-50 transition duration-700" style="top: 50%" id="slider_right">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-200 transition duration-700 hover:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>

                    @endif

                    @endif

                </div>
            </div>
            {{--END SECCION IMAGENES--}}

            {{--SECCION COMENTARIOS LIKES--}}
            <div class=" md:w-1/5 lg:w-1/5  xl:w-1/5 2xl:w-1/5 flex items-start px-1 mt-5 ">
                <div class="grid grid-cols-1 w-full ">


                    {{--USUARIO PUBLICACION--}}
                     {{-- <div class="h-1/5"> --}}
                    <div class="flex items-center justify-between border-b-2 w-full border-gray-300 pb-2 px-2 mx-1 mt-5">

                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-1">
                                <img class="w-10 h-10 rounded-full object-cover" src="{{$this->indice_publicacion->user->profile_img}}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate dark:text-white">
                                    {{$this->indice_publicacion->user->name}} {{$this->indice_publicacion->user->lastname}}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400 inline-flex items-center">
                                    {{$this->indice_publicacion->created_at->diffforhumans()}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </p>
                            </div>
                          </div>
                          <div class="flex items-center justify-center">
                            <i class="fa-solid fa-ellipsis"></i>
                          </div>
                    </div>
                    {{--END USUARIO PUBLICACION--}}
                    {{--THE BODY OF THE POST--}}
                    <div class="flex items-start justify-start mt-2">
                        @if ($this->indice_publicacion->body)
                            <p :class="leer_menos?'overflow-y-auto h-40':''" class="text-base font-bold text-justify   text-gray-900 dark:text-white">
                                @if ($this->cantidad_caracteres($this->indice_publicacion->body)>=200)
                                <span x-cloak
                                      x-show="leer_mas">
                                     {{Str::limit($this->indice_publicacion->body,200)}}
                                </span>
                                <span x-cloak
                                      x-show="leer_mas"
                                      @click="sileemas"
                                      class="font-extrabold text-black cursor-pointer hover:text-gray-500 transition duration-500">
                                      Leer mas
                                </span>
                                <span x-cloak
                                      x-show="leer_menos">
                                     {{$this->indice_publicacion->body}}
                                </span>
                                <span @click="sileemenos"
                                      x-cloak
                                      x-show="leer_menos"
                                      class="font-extrabold text-black cursor-pointer text-xl hover:text-gray-500 transition duration-500">
                                      Leer menos
                                </span>
                                @else
                                    {{$this->indice_publicacion->body}}
                                @endif

                            </p>
                        @endif
                    </div>
                    {{--END THE BODY OF THE POST--}}

                    {{--LIKES Y COMENTARIOS LOGO--}}
                    <div class="flex items-center justify-between  mx-1 my-2 border-y-2 border-gray-200 py-2">
                        {{--LIKES--}}
                        <div class="flex items-center">
                            <div class="relative">
                                <i wire:click="like_img({{$this->indice_publicacion->imagenes[$this->indice_img]}})" @mouseover="like_imgs=true" @mouseout="like_imgs=false"  class="fa-solid fa-thumbs-up  text-sm {{$this->indice_publicacion->imagenes[$this->indice_img]->likedBy($this->usuario)?'text-blue-600 font-bold':'text-gray-400 font-bold'}} cursor-pointer transition duration-700"></i>
                                @if ($this->indice_publicacion->imagenes[$this->indice_img]->likedBy($this->usuario))
                                <div
                                    x-show="like_imgs"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-700"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-700"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="user-select: none"
                                    class="absolute z-50 w-96 flex-shrink-0 text-left -left-1 -top-4 font-extrabold text-gray-800 text-xs">
                                    ya no me gusta
                                </div>
                                @else
                                <div
                                    x-show="like_imgs"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-700"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-700"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="user-select: none"
                                    class="absolute z-50 w-96 flex-shrink-0 text-left -left-1 -top-4 font-extrabold text-gray-800 text-xs">
                                    me gusta
                                </div>
                                @endif
                            </div>
                            @if ($this->indice_publicacion->imagenes[$this->indice_img]->likes()->count()>0)
                            <div class="relative">
                                <p style="user-select: none" @mouseover="peopleliked_imgs=true" @mouseout="peopleliked_imgs=false" class="text-left text-sm font-bold text-gray-400 ml-1">{{$this->indice_publicacion->imagenes[$this->indice_img]->likes()->count()}}</p>
                                <div
                                    x-show="peopleliked_imgs"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-500"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="user-select: none"
                                    class="absolute top-0 text-xs w-52 z-50 flex items-center text-left p-2 left-7 bg-gray-900 rounded-xl opacity-75 text-white">
                                    <ul class="text-justify">
                                    @foreach ($this->indice_publicacion->imagenes[$this->indice_img]->likes()->latest()->get() as $publicacion_l_im)
                                        <li><span class="font-bold">{{$publicacion_l_im->user->id == $this->usuario->id ? 'TÚ:':''}}</span> {{$publicacion_l_im->user->name}} {{$publicacion_l_im->user->lastname}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                        {{--END LIKES--}}
                        {{--COMENTARIOS--}}
                        <div class="flex items-center">

                            @if ($this->indice_publicacion->imagenes[$this->indice_img]->comentarios->count()>0)
                            <div class="relative text-black text-center mr-1">
                                <p style="user-select: none" @mouseover="people_coment_imgs=true" @mouseout="people_coment_imgs=false" class="text-left text-sm font-bold text-gray-400 ml-1">  {{$this->indice_publicacion->imagenes[$this->indice_img]->comentarios->count()}}</p>
                                <div
                                    x-show="people_coment_imgs"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="user-select: none"
                                    class="absolute top-0 text-xs z-50 w-52 flex items-center text-left p-2  -left-52 bg-gray-900 rounded-xl opacity-75 text-white">

                                    <ul class="text-justify">
                                    {{--!!!! PROBLEMA 1 AQUI!!  --}}
                                    @foreach ($this->indice_publicacion->imagenes[$this->indice_img]->comentarios()->distinct()->get('user_id') as $publicacion_c_img)
                                            <li><span class="font-bold">{{$publicacion_c_img->user->id==$this->usuario->id?'Tu:':''}} </span>{{$publicacion_c_img->user->name}} {{$publicacion_c_img->user->lastname}}</li>
                                    @endforeach
                                    {{--!!!!END PROBLEMA 1 AQUI!!  --}}
                                    </ul>
                                </div>
                            </div>
                            @endif
                            <div class="relative">
                                <i class="fa-solid fa-message text-gray-400 cursor-pointer"></i>
                            </div>

                        </div>
                        {{--END COMENTARIOS--}}
                    </div>
                    {{--END LIKES Y COMENTARIOS LOGO--}}
                     {{-- </div> --}}

                    {{--CAMPO Y LISTA DE COMENTARIOS--}}
                    <div class="w-full {{--overflow-y-auto  h-96--}}border-2 border-gray-100">

                        <div class="w-full flex items-center  mb-1 z-50 ">
                            <img class="w-9 h-9 object-cover rounded-full mr-1" src="{{$this->usuario->profile_img}}">
                            <input wire:keydown.enter="comentar_img({{$this->indice_publicacion->imagenes[$this->indice_img]}})" wire:model="comentario_img"  type="text"  class="w-full  font-serif text-base text-black placeholder-gray-500 transition duration-500 shadow-inner sm:text-sm  rounded-2xl focus:no-underline focus:outline-none" placeholder="Escribe aqui tus comentarios...">
                        </div>

                        <div class="overflow-y-auto h-96">
                        @foreach ($this->indice_publicacion->imagenes[$this->indice_img]->comentarios()->orderBy('created_at','DESC')->get() as $imagen_coments)

                            <div class="flex my-2 ml-4">
                                <img class="flex self-start w-9 h-9 object-cover rounded-full mr-1" src="{{$imagen_coments->user->profile_img}}">
                                <div class="bg-gray-200 rounded-xl py-2 px-1">
                                    <span class="text-black font-bold text-sm">@auth{{$imagen_coments->user->id==$this->usuario->id ?'TU:':'' }}@endauth{{$imagen_coments->user->name}} {{$imagen_coments->user->lastname}}</span>
                                    <p class="text-justify text-sm">{{$imagen_coments->comentarios}}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-arround  text-xs ml-10">
                                <div class="flex items-center justify-center mr-3">
                                  <i wire:click="like_comentario_imagen({{$imagen_coments}})" class="fa-solid fa-thumbs-up text-xs {{$imagen_coments->likedBy($this->usuario)?'text-blue-600 font-bold':'text-gray-400 font-bold'}}   cursor-pointer transition duration-700 mr-1"></i>
                                  <span class="text-sm font-bold text-gray-400">{{$imagen_coments->likes->count()>0 ? $imagen_coments->likes->count():'' }} </span>
                                </div>
                                <div class="text-xs mr-3">responder</div>
                                <div class="text-xs">{{$imagen_coments->created_at->diffforhumans()}}</div>
                            </div>

                        @endforeach
                        </div>
                    </div>
                    {{-- END CAMPO Y LISTA DE COMENTARIOS--}}

                </div>
            </div>
            {{--END SECCION COMENTARIOS LIKES --}}
          </div>

        </div>

    </div>
 @endif
</x-modal_fotos_publicacion>
{{--END MODAL--}}

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('publicaciones_index', () => ({

            emojis:false,
                //like:false,
                body:'',
                //respuesta:false,
                btn_add_publicacion:@entangle('btn_add_publicacion'),
                hay_img:@entangle('hay_img'),
                redimensionar(event){
                    if (event.target.value) {

                        this.btn_add_publicacion=true;

                    }else{
                        if(this.hay_img){
                            this.btn_add_publicacion=true;
                        }else{
                            this.btn_add_publicacion=false;
                        }

                    }
                },
                imagenes(event){
                    if (event.target.value) {
                         this.btn_add_publicacion=true;
                         this.hay_img=true;
                    }else{
                        this.btn_add_publicacion=false;
                        this.hay_img=false;
                    }
                }
        }))
    })
</script>
</div>

