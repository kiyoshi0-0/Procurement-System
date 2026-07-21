<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\DeliveryIssueController;
use App\Exports\GoodsReceiptsExport;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/index', [DashboardController::class, 'index'])->name('index');
    Route::get('/generate', [DashboardController::class, 'generate'])->name('generate');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('index'); 
});


// Supplier Management Routes
Route::prefix('suppliers')->name('suppliers.')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('index');
    Route::get('/create', [SupplierController::class, 'create'])->name('create');
    Route::post('/', [SupplierController::class, 'store'])->name('store');
    Route::get('/history', [App\Http\Controllers\PurchaseController::class, 'index'])->name('history');
    Route::get('/search', [SupplierController::class, 'search'])->name('search');
    
    // Evaluation Routes
    Route::get('/{id}/evaluation', [SupplierController::class, 'evaluation'])->name('evaluation');
    Route::post('/{id}/evaluation', [SupplierController::class, 'storeEvaluation'])->name('storeEvaluation'); 
    
    Route::get('/contracts', [SupplierController::class, 'contracts'])->name('contracts');
    Route::get('/{id}', [SupplierController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
    Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy');
});

Route::prefix('orders')->name('orders.')->group(function () {
    // Standardized routes to match your sidebar calls
    Route::get('/', [PurchaseOrderController::class, 'list'])->name('list');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('create');
    Route::get('/history', [PurchaseOrderController::class, 'history'])->name('history');
    
    Route::get('/orders/{po_number}', [PurchaseOrderController::class, 'show'])->name('orders.details');
    Route::get('/{poNumber}', [PurchaseOrderController::class, 'show'])->name('details');
    Route::get('/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('edit');
    
    Route::get('/{poNumber}/print', [PurchaseOrderController::class, 'print'])->name('print');
    Route::get('/{poNumber}/supplier', [PurchaseOrderController::class, 'supplierPreview'])->name('supplier');

    // Actions
    Route::post('/store', [PurchaseOrderController::class, 'store'])->name('store');
    Route::put('/update/{id}', [PurchaseOrderController::class, 'update'])->name('update');
    Route::post('/cancel/{id}', [PurchaseOrderController::class, 'cancel'])->name('cancel');
    Route::delete('/delete/{id}', [PurchaseOrderController::class, 'destroy'])->name('destroy');
});


    //Requests and Approval Routes
    Route::get('/requests/all', [PurchaseRequestController::class, 'showAllRequests'])->name('requests.main');


    Route::post('/requests/store', [PurchaseRequestController::class, 'store'])->name('requests.store');


    // 3. delete
    Route::delete('/requests/{id}', [PurchaseRequestController::class, 'destroy'])
        ->name('requests.destroy')
        ->whereNumber('id');

    // Siguraduhin na ito ay POST route
    Route::post('/requests/{id}/update-status', [PurchaseRequestController::class, 'updateStatus']);

    Route::get('/requests/approved', [PurchaseRequestController::class, 'showApprovedRequests'])->name('requests.approved');
    Route::get('/requests/rejected', [PurchaseRequestController::class, 'showRejectedRequests'])->name('requests.rejected');
    Route::get('/requests/revision', [PurchaseRequestController::class, 'showRevisionRequests'])->name('requests.revision');
    Route::get('/requests/pending', [PurchaseRequestController::class, 'showPendingRequests'])->name('requests.pending');

Route::prefix('receipts')->name('receipts.')->group(function () {


    Route::get('/',
        [GoodsReceiptController::class, 'index'])
        ->name('index');


    Route::get('/delivery-issues',
        [DeliveryIssueController::class, 'index'])
        ->name('delivery');


    Route::get('/three-way-matching',
        [GoodsReceiptController::class, 'threeWayMatching'])
        ->name('threeway');


    Route::get('/payment-validation',
        [GoodsReceiptController::class, 'paymentValidation'])
        ->name('payment');


    Route::put('/{id}/approve',
        [GoodsReceiptController::class, 'approve'])
        ->name('approve');


    Route::get('/{id}/edit',
        [GoodsReceiptController::class, 'edit'])
        ->name('edit');


    Route::put('/{id}',
        [GoodsReceiptController::class, 'update'])
        ->name('update');


    Route::get('/view/{id}',
        [GoodsReceiptController::class, 'show'])
        ->name('view');

});



Route::get('/export-goods-receipts', function () {
    return Excel::download(new GoodsReceiptsExport, 'goods-receipts.xlsx');
})->name('export.excel');

Route::get('/export-pdf', function () {
    // Add your PDF logic here, or redirect for now
    return "PDF Export functionality coming soon!";
})->name('export.pdf');
    