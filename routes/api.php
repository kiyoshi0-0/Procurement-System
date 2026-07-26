<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IntegrationController;

Route::get('/supply-chain/suppliers-export', [IntegrationController::class, 'exportSuppliersToSupplyChain']);
Route::get('/warehouse/purchase-orders-export', [IntegrationController::class, 'exportPurchaseOrdersToWarehouse']);
