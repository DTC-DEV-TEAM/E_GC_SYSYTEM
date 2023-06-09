<?php

use App\Http\Controllers\AdminGCListsController;
use App\Http\Controllers\AdminQrCreationsController;
use Illuminate\Support\Facades\Route;
use App\EmailTesting;

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
    return redirect('/admin/login');
});

// Scan QR
Route::get('admin/g_c_lists/scan_qr', [AdminGCListsController::class, 'getScanQR'])->name('scan_qr');
// Upload File
Route::get('admin/qr_creations/edit/{id}', [AdminQrCreationsController::class, 'getEdit'])->name('qr_creations_edit');
Route::get('admin/qr_creations/upload_gc_list', [AdminQrCreationsController::class, 'uploadGCList'])->name('upload_file');
Route::post('admin/qr_creations/upload_gc_list/excel', [AdminQrCreationsController::class, 'uploadGCListPost'])->name('import_file');
// Export File
Route::get('admin/g_c_lists/upload_gc_list/dowload_template', [AdminQrCreationsController::class, 'exportGCListTemplate'])->name('export_file');
// Get Edit
Route::get('admin/g_c_lists/edit/{id}', [AdminGCListsController::class, 'getEdit'])->name('edit_redeem_code');
// Redeeming Code
Route::post('admin/g_c_list/edit/redeem_code', [AdminGCListsController::class, 'redeemCode'])->name('redeem_code');
Route::post('admin/g_c_list/edit/save_invoice_number', [AdminGCListsController::class, 'inputInvoice'])->name('input_invoice');
// Redemption Period Ended
Route::post('admin/g_c_list/edit/close_transaction', [AdminGCListsController::class, 'closeTransaction'])->name('close_transaction');
// Add Campaign
Route::post('admin/qr_creations/add/campaign', [AdminQrCreationsController::class, 'addCampaign'])->name('add_campaign');

// Email
Route::get('admin/g_c_lists/email', function(){
    return view('/redeem_qr.sendemail');
});

Route::get('/get-sales/{receipt}/{company}/{store}/{voucher}', function($receipt, $company, $store, $voucher){
    
    $data['pos_sale'] = DB::connection('mysql_tunnel')
    ->table('pos_sale')
    ->where('fcompanyid',$company)
    ->where('fofficeid',$store)
    ->where('fdocument_no',$receipt)
    ->first();

    $data['pos_sale_discount'] = DB::connection('mysql_tunnel')
            ->table('pos_sale_product_discount')
            ->where('fcompanyid',$company)
            ->where('frecno',$data['pos_sale']->frecno)
            ->first();

    $data['pos_sale_discount_detail'] = DB::connection('mysql_tunnel')
        ->table('mst_discount')
        ->where('fdiscountid',$data['pos_sale_discount']->fdiscountid)
        ->where('fcompanyid',$company)
        ->first();

    return $data;
});
