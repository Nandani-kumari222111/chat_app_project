<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/form', [TestController::class, 'index']);
Route::post('/submit', [TestController::class, 'submit']);

Route::get('testing/{id}',function($id){
    $users = User::where('id', $id)->first();
    if(!$users){
        abort(404);
    }
    return ($users);
   // return ($users = User::whereKey(auth()->id())->first());
});

Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
   

Route::get('/upload', function () {
    return view('upload');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [ChatController::class, 'users']);
    Route::get('/chat/{id}', [ChatController::class, 'chat']);
    Route::post('/send-message', [ChatController::class, 'sendMessage']);

    Route::post('/user/online', [ChatController::class, 'setOnline']);
    Route::post('/user/offline', [ChatController::class, 'setOffline']);
    Route::post('/user/typing', [ChatController::class, 'typing']);

    Route::get('/chat-app', [ChatController::class, 'index'])->name('chat.app');
    Route::get('/chat-test',function(){
        return view('chat');
    })
    ->name('chat.test');

});

require __DIR__.'/auth.php';