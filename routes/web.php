<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\RecintoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CursoController as AdminCursoController;
use App\Http\Controllers\Admin\RecintoController as AdminRecintoController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Worker\RecintoController as WorkerRecintoController;
use App\Http\Controllers\Worker\CursoController   as WorkerCursoController;
use App\Http\Controllers\Worker\ReservaController as WorkerReservaController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Worker\WorkerController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\MunicipalWorkerMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'worker') {
        return redirect()->route('worker.dashboard');
    }

    return redirect()->route('recintos.index');
})->middleware('auth')->name('home');

// Routes por admin
Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('recintos', AdminRecintoController::class)->names('admin.recintos');
    Route::resource('cursos', AdminCursoController::class)->names('admin.cursos');
    Route::resource('usuarios', AdminUserController::class)->names('admin.usuarios')->parameters(['usuarios' => 'user']);
    Route::get('reservas', [AdminReservaController::class, 'index'])
              ->name('admin.reservas.index');
});

// Routes for workers
Route::prefix('/worker')->middleware(MunicipalWorkerMiddleware::class)->name('worker.')->group(function () {
    Route::get('/dashboard', [WorkerController::class, 'index'])->name('dashboard');

    Route::get('/recintos', [WorkerRecintoController::class, 'index'])->name('recintos.index');
    Route::get('/recintos/{recinto}', [WorkerRecintoController::class, 'show'])->name('recintos.show');
    Route::post('/recintos/{recinto}/reservar', [WorkerRecintoController::class, 'reservar'])->name('recintos.reservar');
    Route::patch('recintos/{recinto}/available',   [WorkerRecintoController::class, 'setAvailable'])->name('recintos.available');
    Route::patch('recintos/{recinto}/unavailable', [WorkerRecintoController::class, 'setUnavailable'])->name('recintos.unavailable');

    Route::get('/cursos', [WorkerCursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/{curso}', [WorkerCursoController::class, 'show'])->name('cursos.show');
    Route::post('/cursos/{curso}/inscribir', [WorkerCursoController::class, 'inscribir'])->name('cursos.inscribir');

    Route::get('/cursos/{curso}/inscribir', [WorkerCursoController::class, 'inscribirForm'])
        ->name('cursos.inscribir.form');

    Route::get('/cursos/{curso}/inscritos', [WorkerCursoController::class, 'showInscritos'])->name('cursos.inscritos');

    Route::post('/cursos/{curso}/cambiar-estado', [WorkerCursoController::class, 'cambiarEstado'])->name('cursos.cambiar_estado');

    Route::post('/cursos/{curso}/cancelar-inscripcion/{usuario}', [WorkerCursoController::class, 'cancelarInscripcion'])->name('cursos.cancelar_inscripcion');

    Route::get('/reservas', [WorkerReservaController::class, 'index'])->name('reservas.index');
    Route::delete('/reservas/{reserva}', [WorkerReservaController::class, 'destroy'])->name('reservas.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/recintos', [RecintoController::class, 'index'])->name('recintos.index');
    Route::get('/recintos/{recinto}', [RecintoController::class, 'show'])->name('recintos.show');

    Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');

    Route::post('/cursos/{curso}/pagar', [CursoController::class, 'pagar'])
        ->name('cursos.pagar');

    Route::get('/cursos/{curso}/pago/exito', [CursoController::class, 'pagoExito'])
        ->name('cursos.pago.exito');
    Route::get('/cursos/{curso}/pago/cancelado', [CursoController::class, 'pagoCancel'])
        ->name('cursos.pago.cancel');

    Route::delete('/cursos/{curso}/cancelar', [CursoController::class, 'cancelar'])
    ->name('cursos.cancelar');


    Route::post('/recintos/{recinto}/pagar',        [RecintoController::class, 'pagar'])
        ->name('recintos.pagar');

    Route::get('/recintos/{recinto}/pago/exito',   [RecintoController::class, 'pagoExito'])
        ->name('recintos.pago.exito');

    Route::get('/recintos/{recinto}/pago/cancel',  [RecintoController::class, 'pagoCancel'])
        ->name('recintos.pago.cancel');

    Route::get('reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::delete('reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');

    Route::get('/perfil', [UserController::class, 'profile'])->name('profile.show');
    Route::get('/perfil/editar', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [UserController::class, 'update'])->name('profile.update');
});
