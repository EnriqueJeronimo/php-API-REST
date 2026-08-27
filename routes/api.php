<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/students', function(){
    return 'Obteniendo lista de estudiantes';
});

Route::get('/students/1', function(){
    return 'Obteniendo un estudiante';
});

Route::post('/students', function(){
    return 'Creando un Estudiante';
});

Route::put('/students/{id}', function(){
    return 'Actualizando estudiante';
});

Route::delete('/students/{id}', function(){
    return 'Eliminando estudiante';
});