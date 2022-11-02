<?php

use App\Http\Controllers\ApitargetController;
use App\Http\Controllers\ApitokenController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\BoxLogController;
use App\Http\Controllers\LogActionController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ZoneLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Artisan Endpoints
 */
Route::get('/artisan/config/cache', [ArtisanController::class, 'config_cache']);
Route::get('/artisan/config/clear', [ArtisanController::class, 'config_clear']);
Route::get('/artisan/view/cache', [ArtisanController::class, 'view_cache']);
Route::get('/artisan/view/clear', [ArtisanController::class, 'view_clear']);
Route::get('/artisan/route/cache', [ArtisanController::class, 'route_cache']);
Route::get('/artisan/route/clear', [ArtisanController::class, 'route_clear']);
Route::get('/artisan/migrate', [ArtisanController::class, 'migrate']);

/*
 * Authentication Endpoints
 */
Route::post('/authenticate/app', [UserController::class, 'authenticate_app']);
Route::post('/authenticate/panel', [UserController::class, 'authenticate_panel']);
Route::post('/authenticate/zone', [ZoneController::class, 'authenticate']);

/*
 * Mail Views
 */
Route::get('/zones/{id}/notify/{type?}/{temperature?}/{humidity?}/{message?}', [ZoneController::class, 'notify_view']);

/*
 * The Protected Endpoints
 */
Route::group(['middleware' => 'api_token'], function() {
    /*
     * Log Actions
     */
    Route::get('/logActions', [LogActionController::class, 'index']);
    Route::get('/logActions/deleted', [LogActionController::class, 'deleted']);
    Route::post('/logActions', [LogActionController::class, 'store']);
    Route::put('/logActions/{id}', [LogActionController::class, 'update']);
    Route::get('/logActions/{id}', [LogActionController::class, 'show']);
    Route::delete('/logActions/{id}', [LogActionController::class, 'destroy']);
    Route::delete('/logActions/{id}/force', [LogActionController::class, 'delete_force']);
    Route::put('/logActions/{id}/restore', [LogActionController::class, 'restore']);

    /*
     * API Target Endpoints
     */
    Route::get('/targets', [ApitargetController::class, 'index']);
    Route::get('/targets/deleted', [ApitargetController::class, 'deleted']);
    Route::post('/targets', [ApitargetController::class, 'store']);
    Route::put('/targets/{id}', [ApitargetController::class, 'update']);
    Route::get('/targets/{id}', [ApitargetController::class, 'show']);
    Route::delete('/targets/{id}', [ApitargetController::class, 'destroy']);
    Route::delete('/targets/{id}/force', [ApitargetController::class, 'delete_force']);
    Route::put('/targets/{id}/restore', [ApitargetController::class, 'restore']);

    /*
     * Permissions
     */
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::get('/permissions/{id}', [PermissionController::class, 'show']);

    /*
     * Roles
     */
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/deleted', [RoleController::class, 'deleted']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::put('/roles/{id}/permissions', [RoleController::class, 'permissions']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    Route::delete('/roles/{id}/force', [RoleController::class, 'delete_force']);
    Route::put('/roles/{id}/restore', [RoleController::class, 'restore']);

    /*
     * API Token Endpoints
     */
    Route::get('/tokens', [ApitokenController::class, 'index']);
    Route::get('/tokens/deleted', [ApitokenController::class, 'deleted']);
    Route::post('/tokens', [ApitokenController::class, 'store']);
    Route::put('/tokens/{id}', [ApitokenController::class, 'update']);
    Route::get('/tokens/{id}', [ApitokenController::class, 'show']);
    Route::delete('/tokens/{id}', [ApitokenController::class, 'destroy']);
    Route::delete('/tokens/{id}/force', [ApitokenController::class, 'delete_force']);
    Route::put('/tokens/{id}/restore', [ApitokenController::class, 'restore']);

    /*
     * Users
     */
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/deleted', [UserController::class, 'deleted']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::delete('/users/{id}/force', [UserController::class, 'delete_force']);
    Route::put('/users/{id}/restore', [UserController::class, 'restore']);

    /*
     * User Logs
     */
    Route::get('/logs', [LogController::class, 'index']);
    Route::get('/logs/deleted', [LogController::class, 'deleted']);
    Route::post('/logs', [LogController::class, 'store']);
    Route::put('/logs/{id}', [LogController::class, 'update']);
    Route::get('/logs/{id}', [LogController::class, 'show']);
    Route::delete('/logs/{id}', [LogController::class, 'destroy']);
    Route::delete('/logs/{id}/force', [LogController::class, 'delete_force']);
    Route::put('/logs/{id}/restore', [LogController::class, 'restore']);

    /*
     * Types
     */
    Route::get('/types', [TypeController::class, 'index']);
    Route::get('/types/deleted', [TypeController::class, 'deleted']);
    Route::post('/types', [TypeController::class, 'store']);
    Route::put('/types/{id}', [TypeController::class, 'update']);
    Route::get('/types/{id}', [TypeController::class, 'show']);
    Route::delete('/types/{id}', [TypeController::class, 'destroy']);
    Route::delete('/types/{id}/force', [TypeController::class, 'delete_force']);
    Route::put('/types/{id}/restore', [TypeController::class, 'restore']);

    /*
     * Zones
     */
    Route::get('/zones', [ZoneController::class, 'index']);
    Route::get('/zones/deleted', [ZoneController::class, 'deleted']);
    Route::post('/zones', [ZoneController::class, 'store']);
    Route::put('/zones/{id}', [ZoneController::class, 'update']);
    Route::get('/zones/{id}', [ZoneController::class, 'show']);
    Route::post('/zones/{id}/notify', [ZoneController::class, 'notify']);
    Route::delete('/zones/{id}', [ZoneController::class, 'destroy']);
    Route::delete('/zones/{id}/force', [ZoneController::class, 'delete_force']);
    Route::put('/zones/{id}/restore', [ZoneController::class, 'restore']);

    /*
     * Zone Logs
     */
    Route::get('/zoneLogs', [ZoneLogController::class, 'index']);
    Route::get('/zoneLogs/deleted', [ZoneLogController::class, 'deleted']);
    Route::post('/zoneLogs', [ZoneLogController::class, 'store']);
    Route::get('/zoneLogs/zone/{id}', [ZoneLogController::class, 'zone']);
    Route::put('/zoneLogs/{id}', [ZoneLogController::class, 'update']);
    Route::get('/zoneLogs/{id}', [ZoneLogController::class, 'show']);
    Route::delete('/zoneLogs/{id}', [ZoneLogController::class, 'destroy']);
    Route::delete('/zoneLogs/{id}/force', [ZoneLogController::class, 'delete_force']);
    Route::put('/zoneLogs/{id}/restore', [ZoneLogController::class, 'restore']);

    /*
     * Positions
     */
    Route::get('/positions', [PositionController::class, 'index']);
    Route::get('/positions/deleted', [PositionController::class, 'deleted']);
    Route::post('/positions', [PositionController::class, 'store']);
    Route::put('/positions/{id}', [PositionController::class, 'update']);
    Route::get('/positions/{id}', [PositionController::class, 'show']);
    Route::delete('/positions/{id}', [PositionController::class, 'destroy']);
    Route::delete('/positions/{id}/force', [PositionController::class, 'delete_force']);
    Route::put('/positions/{id}/restore', [PositionController::class, 'restore']);

    /*
     * Boxes
     */
    Route::get('/boxes', [BoxController::class, 'index']);
    Route::get('/boxes/deleted', [BoxController::class, 'deleted']);
    Route::post('/boxes', [BoxController::class, 'store']);
    Route::put('/boxes/{id}', [BoxController::class, 'update']);
    Route::get('/boxes/{id}', [BoxController::class, 'show']);
    Route::get('/boxes/{id}/logs', [BoxController::class, 'logs']);
    Route::delete('/boxes/{id}', [BoxController::class, 'destroy']);
    Route::delete('/boxes/{id}/force', [BoxController::class, 'delete_force']);
    Route::put('/boxes/{id}/restore', [BoxController::class, 'restore']);

    /*
     * Box Logs
     */
    Route::get('/boxLogs', [BoxLogController::class, 'index']);
    Route::get('/boxLogs/deleted', [BoxLogController::class, 'deleted']);
    Route::post('/boxLogs', [BoxLogController::class, 'store']);
    Route::put('/boxLogs/{id}', [BoxLogController::class, 'update']);
    Route::get('/boxLogs/{id}', [BoxLogController::class, 'show']);
    Route::delete('/boxLogs/{id}', [BoxLogController::class, 'destroy']);
    Route::delete('/boxLogs/{id}/force', [BoxLogController::class, 'delete_force']);
    Route::put('/boxLogs/{id}/restore', [BoxLogController::class, 'restore']);

});
