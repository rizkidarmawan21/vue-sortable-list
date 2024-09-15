<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $users = User::all();
    return Inertia::render('List', [
        'users' => $users
    ]);
});

Route::post('/update-order', function (Request $request) {
    try {
        DB::beginTransaction();
        $validation = $request->validate([
            'data' => 'required|array',
        ]);

        $newData = $validation['data'];


        foreach ($newData as $key => $value) {
            $user = User::find($value['id']);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $user->update([
                'position' => $value['position'],
            ]);
        }

        DB::commit();

        return response()->json(['message' => 'Data updated'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => $e->getMessage()], 500);
    }
})->name('update.order');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
