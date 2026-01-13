<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseMovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserProfileController;

// redirect to login page if not authenticated


Route::get('/', function () {
    return redirect()->route('login');
});




// ======== ADMIN ADD USER ROUTES ========

// Dashboard (protected)
Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('transactions');




Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/items/index', [ItemController::class, 'index'])->name('items.index');
    // Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    // Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');
    // Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    // Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    // Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    //Admin User Registration Routes

    Route::get('/register', [AuthenticatedSessionController::class, 'create'])->name('register');

    Route::get('/cash-movements', [ReportController::class, 'cashMovements'])->name('cash-movements.index');
    Route::get('/cash-movement/create', [ReportController::class, 'createCashMovement'])->name('cash-movement.create');
    Route::post('/cash-movement', [ReportController::class, 'storeCashMovement'])->name('cash-movement.store');

    // Report Routes
    Route::get('/reports/expense', [ReportController::class, 'expenseReport'])->name('expense.report');
    Route::get('/stock/report', [ReportController::class, 'stockReport'])->name('stock.report');
    Route::get('/cash/report', [ReportController::class, 'cashReport'])->name('cash.report');
    Route::get('/reports/purchase', [ReportController::class, 'purchaseReport'])->name('purchase.report');

    //Expense Movement Routes

    Route::get('/expenses', [ExpenseMovementController::class, 'index'])->name('expense.index');
    Route::get('/expenses/create', [ExpenseMovementController::class, 'create'])->name('expense.create');
    Route::post('/expenses/store', [ExpenseMovementController::class, 'store'])->name('expense.store');
    Route::get('/reports/expense', [ReportController::class, 'expenseReport'])->name('expense.report');

    // Purchase Routes
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchases/store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');

    // customer routes 
    Route::get('/customers', [CustomerController::class, 'customersIndex'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'createCustomer'])->name('customers.create');
    Route::post('/customers/store', [CustomerController::class, 'storeCustomer'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'editCustomer'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'updateCustomer'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroyCustomer'])->name('customers.destroy');
    Route::get('/customers/{id}', [CustomerController::class, 'getCustomer']);



    Route::resource('items', ItemController::class);
    Route::resource('transactions', TransactionController::class);
    Route::post('/transactions/{transaction}/pay-debt', [TransactionController::class, 'payDebt'])->name('transactions.payDebt');
    Route::resource('accounts', AccountController::class);
});

// Pay Debt Routes
Route::get('/transactions/{transaction}/pay-debt', [TransactionController::class, 'payDebtForm'])
    ->name('transactions.showPayDebtForm'); // Show the form
Route::post('/transactions/{transaction}/pay-debt', [TransactionController::class, 'payDebt'])
    ->name('transactions.payDebt'); // Submit payment

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Admin dashboard
    Route::get('/user/list', [AdminController::class, 'index'])->name('admin.index');

    // Show create user form
    Route::get('/users/create', [AdminController::class, 'create'])->name('admin.create');

    // Store new user
    Route::post('/users/store', [AdminController::class, 'store'])->name('admin.store');

    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('admin.update');

    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});


//Profile Routes
Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/create', [UserProfileController::class, 'create'])->name('profile.create');
Route::post('/profile/store', [UserProfileController::class, 'store'])->name('profile.store');
Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');

require __DIR__ . '/auth.php';


        
    // <-- Add this to close the middleware group

// Route::get(
//     '/testing',
//     function () {
        
//         return view('testing');
//     });