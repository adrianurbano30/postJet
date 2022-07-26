<?php

use App\Http\Livewire\PublicacionesIndex;
use App\Http\Livewire\Perfil;
use Illuminate\Support\Facades\Route;




Route::get('/',PublicacionesIndex::class)->name('/')->middleware('auth');
Route::get('/perfil',Perfil::Class)->name('perfil')->middleware('auth');
Route::get('/prueba',function(){
    return view('prueba');
})->name('prueba')->middleware('auth');



