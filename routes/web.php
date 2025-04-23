<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth', function () {
    return view('auth.auth');
});
Route::get('/', function () {
    return view('layouts.app', [
        'tanggal' => 'Min, 13 April',
        'jam' => '11:39:32',
        'format' => 'AM',
        'headline' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, perspiciatis.'
    ]);
});
