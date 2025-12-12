<?php

use App\Models\Bill;
use App\Models\Post;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


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


use App\Http\Controllers\BillingController;

Route::get('/dashboard', function () {

    $latestBill = Bill::where('user_id', auth()->id())
        ->latest()
        ->first();
    $posts = Post::latest()->take(10)->get();
    return view('dashboard', compact('latestBill'), ['posts' => $posts]);
})->middleware(['auth']);


Route::get('/settings', function () {
    return view('settings');
})->middleware('auth')->name('settings');

Route::post('/settings/profile-photo', [ProfileController::class, 'updatePhoto'])
    ->middleware('auth')
    ->name('settings.update.photo');

Route::get('/finance', [BillingController::class, 'finance'])
      ->middleware('auth')
      ->name('finance');

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
    $posts = Post::latest()->take(10)->get();
    $ownposts = Post::where('user_id', auth()->id())->get();
    return view('announcements',['posts' => $posts],['ownposts' => $ownposts]);
})->middleware('auth')->name('announcements');

Route::get('/adminlogin', function () {
    return view('adminlogin');
});

Route::post('/adminlogin', [UserController::class,'adminLogin']);

Route::get('/admindash', function () {
    return view('admindash');
})->middleware('auth')->name('admindash');

Route::get('/maintenancedash', function () {
    return view('maintenancedash');
})->middleware('auth');

Route::get('/adminlogout', function () {
    return view('adminlogin');
});

Route::post('/adminlogout', [UserController::class,'adminlogout']);

Route::get('/admincreate', function () {
    return view('admincreate');
})->middleware('auth')->name('admincreate');

Route::post('/admincreate', [UserController::class /*call the UserController file*/,'admincreate'/*Call the function inside*/]);

Route::get('/adminforums', function () {
    $posts = Post::all();
    return view('adminforums',['posts' => $posts]);
})->middleware('auth');

Route::get('/adminresidents', function () {
    $residents = User::where('admin', 0)->where('maintenance', 0)->get();
    return view('adminresidents',['residents' => $residents]);
})->middleware('auth')->name('adminresidents');






// Admin invoice pages
Route::get('/admin/invoice', [BillingController::class, 'create'])->name('admin.invoice.create')->middleware('auth');
Route::post('/admin/invoice', [BillingController::class, 'store'])->name('admin.invoice.store')->middleware('auth');

// API for user dashboard bills (optional direct view)
Route::get('/dashboard/bills', [BillingController::class, 'userBills'])->name('dashboard.bills')->middleware('auth');

// Mark as Paid route in the Finance JS for the function markPaid
Route::post('/bills/{id}/pay', [BillingController::class, 'markPaid'])->name('bills.pay')->middleware('auth');



use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AdminDocumentController;

Route::get('/download/{type}', [AdminDocumentController::class, 'download'])
     ->middleware('auth')
     ->name('download');

// Admin uploads documents
Route::get('/adminunits', [AdminDocumentController::class, 'create'])
     ->middleware('auth')->name('adminunits');
Route::post('/adminunits', [AdminDocumentController::class, 'store'])
     ->middleware('auth');

Route::get('/check-file/{type}', [AdminDocumentController::class, 'checkFile'])
     ->middleware('auth')
     ->name('checkFile');

Route::get('/payment-history', [BillingController::class, 'paymentHistory'])->name('payment.history');

// For paying a bill (already exists)
Route::post('/bills/{id}/pay', [BillingController::class, 'markPaid']);

Route::get('/receipt/{id}', [BillingController::class, 'generateReceipt'])->name('receipt.generate');

Route::get('/payment-history/ajax', [BillingController::class, 'paymentHistoryAjax'])
    ->name('payment.history.ajax')
    ->middleware('auth');



Route::post('/create-post', [PostController::class, 'createPost']);

Route::put('/update-post/{id}', [PostController::class, 'update']);

Route::delete('/delete-post/{id}', [PostController::class, 'destroy']);


use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;

Route::middleware(['auth'])->group(function () {
    // user
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post(
        '/tickets/{ticket}/comment',
        [TicketController::class, 'comment']
    )->name('tickets.comment');
    // admin (protect with gate or is_admin middleware)
    
});

Route::prefix('admin')->middleware(['auth', 'can:viewAny,App\\Models\\Ticket'])->group(function () {
    Route::get('/tickets/all', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('/tickets/{ticket}/claim', [AdminTicketController::class, 'claim'])->name('admin.tickets.claim');
    Route::post('/tickets/{ticket}/status', [AdminTicketController::class, 'status'])->name('admin.tickets.status');
    Route::post('/tickets/{ticket}/comment', [AdminTicketController::class, 'comment'])->name('admin.tickets.comment');
    Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('admin.tickets.destroy');
});

Route::put('/admin/update-user/{id}', [UserController::class, 'update'])->name('admin.update.user');
