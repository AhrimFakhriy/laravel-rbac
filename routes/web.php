<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

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


/*
    USER 1 HAS DIRECT PERMISSION TO "PERMISSION-1".
    USER 1 DOES NOT HAVE PERMISSION TO "PERMISSION-2".
    USER 1 DOES NOT HAVE PERMISSION TO "PERMISSION-THROUGH-ROLE";

    ROLE 1 HAS PERMISSION TO "PERMISSION-THROUGH-ROLE";

    USER 1 BELONGS TO THE ROLE CALLED "ROLE-1".

    THEREFORE USER 1 HAS INDIRECT PERMISSION TO "PERMISSION-THROUGH-ROLE";
*/

Route::get('test-permission', function() {
    Auth::loginUsingId(1);

    return response()->json([
        'allowed for permission-1' => Gate::allows('permission-1'),
        'allowed for permission-2' => Gate::allows('permission-2'), // Gate::allows or gate()->allows() or auth()->user()->can() is the same thing.
        'allowed for permission-role through role owned by user' => auth()->user()->can('permission-through-role'),
    ]);
});

Route::get('test-gate-fails', function() {
    Auth::loginUsingId(1);
    Gate::authorize('permission-2', 404);

    return "SUCCESS";
});

Route::get('test-gate', function() {
    Auth::loginUsingId(1);
    Gate::authorize('permission-1');

    return "SUCCESS";
});

Route::get('test-gate-indirect-permission', function() {
    Auth::loginUsingId(1);
    Gate::authorize('permission-through-role');

    return "SUCCESS";
});

Route::get('test-permission-using-abort-fails', function() {
    Auth::loginUsingId(1);
    abort_unless(Gate::allows('permission-2'), 403); // also exists abort_if and others.

    return "SUCCESS";
});

Route::get('test-permission-using-abort', function() {
    Auth::loginUsingId(1);
    abort_unless(Gate::allows('permission-1'), 403);

    return "SUCCESS";
});
