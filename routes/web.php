<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ShowPosts;
use App\Livewire\CreateDesignation;
use App\Livewire\EditDesignation;
use App\Livewire\Designations;



//Route::get('/', CreatePost::class);

Route::get('/designations',Designations::class)->name('designations.index');
Route::get('/designations/create',CreateDesignation::class)->name('designations.create');
Route::get('/designations/{designation}/edit',EditDesignation::class)->name('designations.edit');
