<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ShowPosts;
use App\Livewire\Dashboard;

use App\Livewire\Designations;
use App\Livewire\CreateDesignation;
use App\Livewire\EditDesignation;
use App\Livewire\Employees;
use App\Livewire\CreateEmployee;
use App\Livewire\EditEmployee;

//Route::get('/', CreatePost::class);

//Route::get('/',Dashboard::class)->name('dashboard');

Route::get('/',Designations::class)->name('designations.index');
Route::get('/designations/create',CreateDesignation::class)->name('designations.create');
Route::get('/designations/{designation}/edit',EditDesignation::class)->name('designations.edit');

Route::get('/employees',Employees::class)->name('employees.index');
Route::get('/employees/create',CreateEmployee::class)->name('employees.create');
Route::get('/employees/{employee}/edit',EditEmployee::class)->name('employees.edit');
