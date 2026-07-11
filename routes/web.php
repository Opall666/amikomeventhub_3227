<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Schedule;


/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses semua orang)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori', [HomeController::class, 'kategori'])->name('kategori');
Route::get('/tentang-kami', [HomeController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/cara-kerja', [HomeController::class, 'caraKerja'])->name('cara-kerja');
Route::get('/syarat-ketentuan', [HomeController::class, 'syaratKetentuan'])->name('syarat-ketentuan');
Route::get('/kebijakan-privasi', [HomeController::class, 'kebijakanPrivasi'])->name('kebijakan-privasi');

// Event Detail - PERBAIKAN: pakai {event} bukan {id}
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Hanya untuk guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // My Tickets
    Route::get('/my-tickets', [EventController::class, 'myTickets'])->name('tickets.index');
    
    // Checkout - PERBAIKAN: pakai CheckoutController
    Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

     // TAMBAHKAN 2 ROUTE INI ↓
    Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::post('/payment/{order_id}/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    
    // Ticket (Menampilkan tiket berdasarkan Order ID)
    Route::get('/my-ticket/{order_id}', [EventController::class, 'ticket'])->name('ticket');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Harus login + role: admin)
|--------------------------------------------------------------------------
*/
// PERBAIKAN: middleware 'admin' bukan 'role:admin'
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('events', EventAdminController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('partners', PartnerController::class);
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/transactions/{transaction}/status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
});

/*
|--------------------------------------------------------------------------
| Midtrans Webhook (Tanpa Auth & CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/webhook', [\App\Http\Controllers\Midtrans\WebhookController::class, 'handleNotification'])
    ->name('midtrans.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Jalankan setiap menit untuk release expired reservations
Schedule::command('reservations:release-expired')->everyMinute();