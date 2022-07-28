<div class="mt-20    2xl:mx-20 xl:mx-20 lg:mx-10 md:mx-8 sm:mx-1">

    <div class="border-2 rounded-md border-gray-900 p-2 flex items-center">

        <div class="h-48 w-48 rounded-xl mr-2">
            <img class="object-cover w-full h-full rounded-xl" src="{{$this->usuario->profile_img}} ">
        </div>
        <div class="flex self-end text-xl font-bold">
            <span>{{$this->usuario->name}} {{$this->usuario->lastname}} </span>
        </div>

    </div>
    <div x-data="{tab:'publicaciones'}" class="w-full border-2 rounded-md bg-white border-gray-900 p-2 my-2">

        <div class="flex w-full">

            <a class="cursor-pointer p-1 bg-gray-200 text-gray-600 rounded-t-lg" :class="tab=='publicaciones'?'bg-gray-700 text-white':''" @click.prevent="tab='publicaciones'" >Tus publicaciones</a>
            <a class="cursor-pointer p-1 bg-gray-200 text-gray-600 rounded-t-lg" :class="tab=='fotos'?'bg-gray-700 text-white':''"  @click.prevent="tab='fotos'" >Tus fotos</a>
            <a class="cursor-pointer p-1 bg-gray-200 text-gray-600 rounded-t-lg" :class="tab=='amigos'?'bg-gray-700 text-white':''"  @click.prevent="tab='amigos'" >Tus amigos</a>

        </div>
        <div class="border-2 border-gray-400 rounded-b-lg">
            {{--TAB PUBLICACIONES--}}
            <div class="p-2 flex items-center justify-center"
                x-cloak
                x-show="tab==='publicaciones'"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                {{-- x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95" --}}
                >
                <div class="grid grid-cols-1">

                <div class="">

                @foreach ($publicaciones as $publicacion)
                <div
                        x-data="{
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
                    class="{{--lg:w-1/2  2xl:w-1/2 xl:w-1/2 xl:h-auto 2xl:h-auto sm:mx-4 md:mx-1--}} flex items-center justify-center  mb-4 mt-4 rounded-lg bg-gray-50 text-gray-900 border-2 border-white shadow-white shadow-md">

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
                        {{--END top of the post--}}

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

                    </div>
                </div>
                @endforeach

                </div>
                </div>
            </div>
            {{--END TAB PUBLICACIONES--}}

            {{--TAB FOTOS--}}
            <div class="p-2"
                x-cloak
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                {{-- x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95" --}}
                x-show="tab==='fotos'">
                <p>Tus fotos</p>
                <div class="text-justify p-2">
                    Aqui va la info de las fotos albums etc
                </div>
            </div>
            {{--END TAB FOTOS--}}

            {{--TAB AMIGOS--}}
            <div class="p-2"
                 x-cloak
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 {{-- x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95" --}}
                 x-show="tab==='amigos'"
                 >
                <p>Tus amigos</p>
                <div class="text-justify p-2">
                    Aqui info de los amigos que puedes tener.
                </div>
            </div>
            {{--END TAB AMIGOS--}}
        </div>

    </div>

</div>
