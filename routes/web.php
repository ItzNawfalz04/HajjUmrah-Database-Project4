<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/download/hajj-template', function () {
    return response()->download(public_path('templates/hajj_participant_template.xlsx'));
})->name('download.hajj-template');

