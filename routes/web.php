<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\BillingController;
use App\Models\Invoice;


// --------------- Tenant Billing Routes ---------------- //

Route::middleware(['auth'])->group(function () {

    // Tenant bills list
    Route::get('/tenant/bills', function () {
        return view('help');   // tenant/bills/index
    })->name('tenant.bills.index');
});

Route::get('/', function () {
    return view('home');
});

Route::get('/register', [UserController::class, 'showRegisterForm']);
Route::post('/register', [UserController::class /*call the UserController file*/,'register'/*Call the function inside*/]);
Route::post('/logout', [UserController::class,'logout']);
Route::post('/login', [UserController::class,'login']);


use App\Models\Bill;

Route::get('/dashboard', function () {

    $latestBill = Bill::where('user_id', auth()->id())
        ->latest()
        ->first();

    return view('dashboard', compact('latestBill'));
})->middleware(['auth']);


Route::get('/settings', function () {
    return view('settings');
})->middleware('auth')->name('settings');

Route::post('/settings/profile-photo', [ProfileController::class, 'updatePhoto'])
    ->middleware('auth')
    ->name('settings.update.photo');

Route::get('/finance', function () {
    return view('finance');
})->middleware('auth')->name('finance');

Route::get('/documents', function () {
    return view('documents');
})->middleware('auth')->name('documents');

Route::get('/help', function () {
    return view('help');
})->middleware('auth')->name('help');;


Route::get('/maintenance', function () {
    return view('maintenance');
})->middleware('auth')->name('maintenance');

Route::get('/announcements', function () {
    return view('announcements');
})->middleware('auth');

Route::get('/adminlogin', function () {
    return view('adminlogin');
});

Route::post('/adminlogin', [UserController::class,'adminLogin']);

Route::get('/admindash', function () {
    return view('admindash');
})->middleware('auth');

Route::get('/adminlogout', function () {
    return view('adminlogin');
});

Route::post('/adminlogout', [UserController::class,'adminlogout']);

Route::get('/admincreate', function () {
    return view('admincreate');
})->middleware('auth');

Route::get('/adminforums', function () {
    return view('adminforums');
})->middleware('auth');

Route::get('/adminresidents', function () {
    return view('adminresidents');
})->middleware('auth');

Route::get('/adminunits', function () {
    return view('adminunits');
})->middleware('auth');






// Admin invoice pages
Route::get('/admin/invoice', [BillingController::class, 'create'])->name('admin.invoice.create')->middleware('auth');
Route::post('/admin/invoice', [BillingController::class, 'store'])->name('admin.invoice.store')->middleware('auth');

// API for user dashboard bills (optional direct view)
Route::get('/dashboard/bills', [BillingController::class, 'userBills'])->name('dashboard.bills')->middleware('auth');

// Mark paid (optional)
Route::post('/bills/{id}/pay', [BillingController::class, 'markPaid'])->name('bills.pay')->middleware('auth');



use App\Http\Controllers\AdminDocumentController;

Route::get('/download/{type}', [AdminDocumentController::class, 'download'])
     ->middleware('auth')
     ->name('download');

// Admin uploads documents
Route::get('/adminunits', [AdminDocumentController::class, 'create'])
     ->middleware('auth');
Route::post('/adminunits', [AdminDocumentController::class, 'store'])
     ->middleware('auth');

Route::get('/check-file/{type}', [AdminDocumentController::class, 'checkFile'])
     ->middleware('auth')
     ->name('checkFile');

