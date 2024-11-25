<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::controller(ImageController::class)->prefix('image')->group(function () {
  Route::get('show', 'index')->name('image.show');
  Route::post('store', 'store')->name('image.store');
  Route::get('edit/{id}', 'edit')->name('image.edit');
  Route::put('update/{id}', 'update')->name('image.update');
  Route::delete('destroy/{id}', 'destroy')->name('image.destroy');
});