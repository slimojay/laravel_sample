<?php
namespace App\Models;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

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
$path = "App\Http\Controllers";
Route::get('/', function () {
    $all = Children::all();
    $male = Children::where("gender", 1)->count();
    $female = Children::where("gender", 2)->count();
    $offers = Offers::all()->count();
    
    return view('index', ['all' => count($all), 'male' => $male, 'female' => $female, 'offers' => $offers]);
})->name('index');


Route::get("/drinking/{age}", "$path\TestController@toDrive")->middleware("drinkingAge");

Route::get('/home', '\TestController@home')->name('hm');
Route::post('/', "$path\Orphanage@enroll");


