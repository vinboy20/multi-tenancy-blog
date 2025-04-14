<?php

use App\Livewire\Crud\EditBlog;
use App\Livewire\Crud\CreateBlog;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('/create-blog', function () {
        return view('crud.create');
    })->name('posts.create');

    // Route::get('/edit-blog/{post}', CreateBlog::class)->name('posts.edit');
    Route::get('/edit-blog/{post}', EditBlog::class)->name('posts.edit');

    // Route::get('/edit-blog/{id}', function () {
    //     return view('crud.edit');
    // })->name('posts.edit');
   
});

require __DIR__.'/auth.php';
require __DIR__.'/tenant.php';
