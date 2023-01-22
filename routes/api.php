<?php

use App\Http\Controllers\API\V1\AssignmentsController;
use App\Http\Controllers\API\V1\AssignmentTypesController;
use App\Http\Controllers\API\V1\AttendanceController;
use App\Http\Controllers\API\V1\CoursesController;
use App\Http\Controllers\API\V1\CourseTypesController;
use App\Http\Controllers\API\V1\StudentsController;
use App\Http\Controllers\API\V1\DepartmentsController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], fn () => [

    // Student's routes
    Route::group(['prefix' => 'students', 'as' => 'students.'], fn () =>
        Route::get('results', [StudentsController::class, 'results'])->name('results'),
        Route::post('apply', [StudentsController::class, 'apply'])->name('apply'),
    ),

    Route::apiResource('students', StudentsController::class),
    ////

    // Assignment Routes
    Route::group(['prefix' => 'assignments', 'as' => 'assignments.'], fn () =>
        // Route::get('/{course}/all', [AssignmentsController::class, 'allCourseAssignments'])->name('all-course-assignments'),
        Route::get('/{assignment}', [AssignmentsController::class, 'submissions'])->name('submission'),
        Route::post('/{assignment}/grade', [AssignmentsController::class, 'gradeAssignment'])->name('grade-assignment'),
    ),
    ////

    Route::apiResource('course-types', CourseTypesController::class),

    Route::apiResource('departments', DepartmentsController::class),

    Route::apiResource('assignment-types', AssignmentTypesController::class),

    Route::apiResource('attendances', AttendanceController::class),

    Route::apiResource('courses', CoursesController::class),
]);










Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
