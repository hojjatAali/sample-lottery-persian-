<?php

    use App\Http\Controllers\ParticipantController;
    use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post ('participant/add',[ParticipantController::class,'store'])->name ('store');
Route::get ('/lottery',[ParticipantController::class,'index'])->name ('lottery');
Route::get ('/lottery/add',[ParticipantController::class,'add']);
Route::post ('/lottery',[ParticipantController::class,'lottery']);

// PHP (Laravel)
    Route::get('/get-names', function () {
        $names = DB::table('participants')->pluck('first_name');

        return view('participant.participant', ['names' => $names]);
    });

