<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Livros;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/livros', Livros::class)->name('livros');
