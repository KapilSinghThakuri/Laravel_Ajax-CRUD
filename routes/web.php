<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/students',[StudentController::class, 'index']);
Route::post('/students',[StudentController::class, 'store']);
Route::get('/fetch-students',[StudentController::class, 'fetchStudent']);
Route::get('/edit-student/{id}',[StudentController::class,'editStudent']);
Route::put('student-update/{id}',[StudentController::class,'updateStudent']);
Route::delete('Student-delete/{id}',[StudentController::class,'deleteStudent']);


