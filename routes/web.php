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



Route::get('/', function () {
    return redirect()->route('login');
});



Route::get('/banana', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

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
      

    // Cash Movement Routes

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


require __DIR__ . '/auth.php';


        
    // <-- Add this to close the middleware group

// Route::get(
//     '/testing',
//     function () {
        
//         return view('testing');
//     });