<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use PHPUnit\Framework\MockObject\Builder\Stub;

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

// jQuery-Ajax CRUD OPERATIONS

Route::get('/students',[StudentController::class, 'index']);
// FOR DATA STORE
Route::post('/students',[StudentController::class, 'store']);
// FOR DATA FETCH IN FRONTEND
Route::get('/fetch-students',[StudentController::class, 'fetchStudent']);
// FOR EDIT DATA
Route::get('/edit-student/{id}',[StudentController::class,'editStudent']);
// FOR UPDATE DATA
Route::put('student-update/{id}',[StudentController::class,'updateStudent']);
// FOR DELETE DATA
Route::delete('Student-delete/{id}',[StudentController::class,'deleteStudent']);


// FOR SEARCHING FUNCTION
Route::get('/search',[StudentController::class,'search']);





// jQuery-Ajax IMAGE CRUD OPERATIONS

// FOR EMPLOYEE DETAILS DASHBOARD
Route::get('/employee',[EmployeeController::class,'index']);
// FOR STORING EMPLOYEE DATA
Route::post('employee',[EmployeeController::class,'store']);

