<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Authentication routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    
    // Contact routes
    Route::apiResource('contacts', ContactController::class);
    
    // Additional contact routes
    Route::get('/contacts/favorites', [ContactController::class, 'favorites']);
    Route::patch('/contacts/{contact}/toggle-favorite', [ContactController::class, 'toggleFavorite']);
    
    // Optional: Add a simple health check route
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is working',
            'timestamp' => now()->toISOString(),
        ]);
    });
});

// Optional: Add a root route for API info
Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Laravel Address Book API',
        'version' => '1.0.0',
        'endpoints' => [
            'auth' => [
                'POST /api/auth/register' => 'Register new user',
                'POST /api/auth/login' => 'Login user',
                'POST /api/auth/logout' => 'Logout user (authenticated)',
                'POST /api/auth/logout-all' => 'Logout from all devices (authenticated)',
                'GET /api/auth/profile' => 'Get user profile (authenticated)',
            ],
            'contacts' => [
                'GET /api/contacts' => 'List contacts (authenticated)',
                'POST /api/contacts' => 'Create contact (authenticated)',
                'GET /api/contacts/{id}' => 'Get contact (authenticated)',
                'PUT /api/contacts/{id}' => 'Update contact (authenticated)',
                'DELETE /api/contacts/{id}' => 'Delete contact (authenticated)',
                'GET /api/contacts/favorites' => 'Get favorite contacts (authenticated)',
                'PATCH /api/contacts/{id}/toggle-favorite' => 'Toggle favorite status (authenticated)',
            ],
            'health' => [
                'GET /api/health' => 'Health check (authenticated)',
            ],
        ],
    ]);
});
