<?php

use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\AccountWorkerController;
use App\Http\Controllers\BranchController;
use Illuminate\Http\Request;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\NaturalPersonController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientGController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RegisterHardwareController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactRefController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\SoftwareMachineController;
use App\Http\Controllers\TicketController;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Obtener el usuario autenticado
    $user = $request->user();

    // Obtener el primer rol del usuario (si tiene roles)
    $firstRole = $user->getRoleNames()->first(); // Solo el primer rol

    // Convertir el usuario a array y eliminar la clave 'roles'
    $userArray = $user->toArray();
    unset($userArray['roles']);  // Eliminar la propiedad 'roles'

    // Añadir el primer rol al array
    $userArray['role'] = $firstRole;

    // Devolver la respuesta JSON con el primer rol
    return response()->json($userArray);
});


// Añade esta ruta para manejar el logout
// Colócala dentro del grupo de middleware 'auth:sanctum' o al menos con ese middleware aplicado
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete(); // Revoca el token actual del usuario
    return response()->json(['message' => 'Cierre de sesión exitoso'], 200);
});


//routes en ingles
Route::middleware(['auth:sanctum', 'expiration'])->group(function () {
    Route::apiResource('/clientG', ClientGController::class);
    Route::apiResource('/registerHardware', RegisterHardwareController::class);
    Route::apiResource('/plan', PlanController::class);
    Route::apiResource('/software', SoftwareController::class);
    Route::apiResource('/accountRegister', AccountRegisterController::class);
    Route::apiResource('/company', CompanyController::class);
    Route::apiResource('/natural-person', NaturalPersonController::class);
    Route::apiResource('/machine', MachineController::class);
    Route::apiResource('/hardware', HardwareController::class);
    Route::apiResource('/softwareMachine', SoftwareMachineController::class);
    Route::apiResource('/accountWorker', AccountWorkerController::class);
    Route::apiResource('/branches', BranchController::class);
    Route::resource('/areas', AreaController::class);
    Route::resource('/contact_refs', ContactRefController::class);
    Route::apiResource('/tickets', TicketController::class);
});
