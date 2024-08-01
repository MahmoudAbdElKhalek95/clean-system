<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

Auth::routes();
Route::get('/exel-link', function () {

        $date1 = mktime(0, 0, 0, date('m'), 19, date("Y"));
        $date2 = mktime(23, 59, 59, date('m'), 19, date("Y"));
        $unix_time = $date1.','.$date2;
            date_default_timezone_set("Asia/Riyadh");
            $body = [
                "k" => config('project.api.secret_key'),
                "ts" => $unix_time
            ];

            $response = Http::asForm()->post(config('project.api.url').'?ts='.$unix_time, $body);
    if ($response->ok()) {
        $data = $response->json();
        return FastExcel::data($data['results'])->download('links.xlsx', function ($item) {
            return [
                'رقم العملية' => $item['paymentId'],
                'اسم المشروع' => $item['projectName'],
                'رقم المشروع' => $item['projectId'],
                'الصنف' => $item['categoryName'],
                'الكمية' => $item['quantity'],
                'السعر' => $item['price'],
                'رقم الجوال' => $item['phoneNumber'] ?? '',
                'الاجمالى' => $item['total'],
                'الكود' => $item['referenceCode'],
                'انشئ فى' => $item['paymentDate']
            ];
        });
    }

});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created';
});
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Cache cleared';
});
Route::get('/install-permissions', function () {
    Artisan::call('install:permissions');
    return 'Permission updated';
});

Auth::routes();

Route::get('scan',[App\Http\Controllers\HomeController::class, 'scan'])->name('scan');
Route::get('doner-details',[App\Http\Controllers\HomeController::class, 'donerDetails'])->name('donerDetails');
Route::get('contact-us',[App\Http\Controllers\HomeController::class, 'contactUs'])->name('contactUs');
Route::get('contact',[App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/checkSerial', [App\Http\Controllers\HomeController::class, 'checkSerial'])->name('checkSerial');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/statistics', [App\Http\Controllers\StatisticsController::class, 'index'])->name('statistics');
Route::get('/target-statistics', [App\Http\Controllers\StatisticsController::class, 'target_statistics'])->name('target_statistics');
Route::get('/total-target-statistics', [App\Http\Controllers\StatisticsController::class, 'new_target_statistics'])->name('new_target_statistics');

Route::get('target/listall', [App\Http\Controllers\Admin\TargetController::class, 'alllist'])->name('alllist') ;
Route::get('/getActivePages', [App\Http\Controllers\StatisticsController::class, 'getActivePages'])->name('getActivePages');
// wirte_image
Route::get('/wirte_image', [App\Http\Controllers\StatisticsController::class, 'wirte_image'])->name('wirte_image');
Route::get('/updateProject', [App\Http\Controllers\Admin\SettingController::class, 'updateProject'])->name('updateProject');
Route::get('/getCountProject', [App\Http\Controllers\Admin\SettingController::class, 'getCountProject'])->name('getCountProject');
Route::get('/updateimagesProject', [App\Http\Controllers\Admin\SettingController::class, 'updateProjectImage'])->name('updateProjectImage');
Route::get('/getProjectStatistics', [App\Http\Controllers\StatisticsController::class, 'getProjectStatistics'])->name('getProjectStatistics');
Route::get('/getProjectCount', [App\Http\Controllers\StatisticsController::class, 'getProjectCount'])->name('getProjectCount');
Route::get('/getTotalAfterMessage', [App\Http\Controllers\StatisticsController::class, 'getTotalAfterMessage'])->name('getTotalAfterMessage');
Route::get('/sendMessage', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'sendMessage'])->name('sendMessage');


