<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;

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
    $jlhpegawai = Employee::count();
    $jlhpegawaicowo = Employee::where('jenkel','cowo')->count();
    $jlhpegawaicewe = Employee::where('jenkel','cewe')->count();

    return view('welcome', compact('jlhpegawai','jlhpegawaicowo','jlhpegawaicewe'));
})->middleware('auth');

Route::get('/pegawai', [EmployeeController::class, 'index'])->name('pegawai')->middleware('auth');

Route::get('/tambahpegawai', [EmployeeController::class, 'tambahpegawai'])->name('tambahpegawai');
Route::post('/insertdata', [EmployeeController::class, 'insertdata'])->name('insertdata');

Route::get('/tampildata/{id}', [EmployeeController::class, 'tampildata'])->name('tampildata');
Route::post('/updatedata/{id}', [EmployeeController::class, 'updatedata'])->name('updatedata');

Route::get('/delete/{id}', [EmployeeController::class, 'delete'])->name('delete');

//export pdf
Route::get('/exportpdf', [EmployeeController::class, 'exportpdf'])->name('exportpdf');

//export excel
Route::get('/exportexcel', [EmployeeController::class, 'exportexcel'])->name('exportexcel');

//import data
Route::post('/importexcel', [EmployeeController::class, 'importexcel'])->name('importexcel');

//route untuk menampilkan halaman login dan register
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');

//route untuk menyimpan data register ke database 
Route::post('/registeruser', [LoginController::class, 'registeruser'])->name('registeruser');
Route::post('/loginproses', [LoginController::class, 'loginproses'])->name('loginproses');


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


