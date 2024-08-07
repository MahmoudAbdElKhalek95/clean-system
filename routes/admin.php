<?php

use Illuminate\Support\Facades\Route;

      ////////////////////   rate ////////////////////////////////
      Route::get('rate/select', [App\Http\Controllers\Admin\RateController::class, 'select'])->name('rate.select');
      Route::delete('rate/bulk', [App\Http\Controllers\Admin\RateController::class, 'deleteBulk'])->name('rate.deleteBulk');
      Route::get('rate/list', [App\Http\Controllers\Admin\RateController::class, 'list'])->name('rate.list');
      Route::post('rate', [App\Http\Controllers\Admin\RateController::class, 'store'])->name('rate.store');
      Route::delete('rate/{id}', [App\Http\Controllers\Admin\RateController::class, 'destroy'])->name('rate.destroy');
      Route::get('rate', [App\Http\Controllers\Admin\RateController::class, 'index'])->name('rate.index');
      Route::get('rate/create', [App\Http\Controllers\Admin\RateController::class, 'create'])->name('rate.create');
      Route::match(['PUT', 'PATCH'], 'rate/{id}', [App\Http\Controllers\Admin\RateController::class, 'update'])->name('rate.update');
      Route::get('rate/{id}/edit', [App\Http\Controllers\Admin\RateController::class, 'edit'])->name('rate.edit');

    Route::middleware('throttle:60,1')->group(function () {
    Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'adminlogin'])->name('admin.login');
    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'postLogin'])->name('admin.postLogin');
    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('home');

    
        Route::get('users/select', [App\Http\Controllers\Admin\UserController::class, 'select'])->name('users.select');
        Route::get('users/selectclient', [App\Http\Controllers\Admin\UserController::class, 'selectClient'])->name('users.selectClient');
        Route::delete('users/bulk', [App\Http\Controllers\Admin\UserController::class, 'deleteBulk'])->name('users.deleteBulk');
        Route::get('users/list', [App\Http\Controllers\Admin\UserController::class, 'list'])->name('users.list')->middleware('permission:users.view');
        Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
        Route::delete('users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index')->middleware('permission:users.view');
        Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
        Route::match(['PUT', 'PATCH'], 'users/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update')->middleware('permission:users.edit');
        Route::get('users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');

        ////////////////////////// school 
        Route::get('school/select', [App\Http\Controllers\Admin\SchoolController::class, 'select'])->name('school.select');
        Route::delete('school/bulk', [App\Http\Controllers\Admin\SchoolController::class, 'deleteBulk'])->name('school.deleteBulk');
        Route::get('school/list', [App\Http\Controllers\Admin\SchoolController::class, 'list'])->name('school.list')->middleware('permission:school.view');
        Route::post('school', [App\Http\Controllers\Admin\SchoolController::class, 'store'])->name('school.store')->middleware('permission:school.create');
        Route::delete('school/{id}', [App\Http\Controllers\Admin\SchoolController::class, 'destroy'])->name('school.destroy')->middleware('permission:school.delete');
        Route::get('school', [App\Http\Controllers\Admin\SchoolController::class, 'index'])->name('school.index')->middleware('permission:school.view');
        Route::get('school/create', [App\Http\Controllers\Admin\SchoolController::class, 'create'])->name('school.create')->middleware('permission:school.create');
        Route::match(['PUT', 'PATCH'], 'school/{id}', [App\Http\Controllers\Admin\SchoolController::class, 'update'])->name('school.update')->middleware('permission:school.edit');
        Route::get('school/{id}/edit', [App\Http\Controllers\Admin\SchoolController::class, 'edit'])->name('school.edit')->middleware('permission:school.edit');

        ////////////////  contract ////////////////////////
        Route::get('contract/select', [App\Http\Controllers\Admin\ContractController::class, 'select'])->name('contract.select');
        Route::delete('contract/bulk', [App\Http\Controllers\Admin\ContractController::class, 'deleteBulk'])->name('contract.deleteBulk');
        Route::get('contract/list', [App\Http\Controllers\Admin\ContractController::class, 'list'])->name('contract.list')->middleware('permission:contract.view');
        Route::post('contract', [App\Http\Controllers\Admin\ContractController::class, 'store'])->name('contract.store')->middleware('permission:contract.create');
        Route::delete('contract/{id}', [App\Http\Controllers\Admin\ContractController::class, 'destroy'])->name('contract.destroy')->middleware('permission:contract.delete');
        Route::get('contract', [App\Http\Controllers\Admin\ContractController::class, 'index'])->name('contract.index')->middleware('permission:contract.view');
        Route::get('contract/create', [App\Http\Controllers\Admin\ContractController::class, 'create'])->name('contract.create')->middleware('permission:contract.create');
        Route::match(['PUT', 'PATCH'], 'contract/{id}', [App\Http\Controllers\Admin\ContractController::class, 'update'])->name('contract.update')->middleware('permission:contract.edit');
        Route::get('contract/{id}/edit', [App\Http\Controllers\Admin\ContractController::class, 'edit'])->name('contract.edit')->middleware('permission:contract.edit');

        ////////////////    ServiceController //////////////////////////////////////////////////////
        Route::get('service/select', [App\Http\Controllers\Admin\ServiceController::class, 'select'])->name('service.select');
        Route::delete('service/bulk', [App\Http\Controllers\Admin\ServiceController::class, 'deleteBulk'])->name('service.deleteBulk');
        Route::get('service/list', [App\Http\Controllers\Admin\ServiceController::class, 'list'])->name('service.list')->middleware('permission:service.view');
        Route::post('service', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('service.store')->middleware('permission:service.create');
        Route::delete('service/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('service.destroy')->middleware('permission:service.delete');
        Route::get('service', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('service.index')->middleware('permission:service.view');
        Route::get('service/create', [App\Http\Controllers\Admin\ServiceController::class, 'create'])->name('service.create')->middleware('permission:service.create');
        Route::match(['PUT', 'PATCH'], 'service/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'update'])->name('service.update')->middleware('permission:service.edit');
        Route::get('service/{id}/edit', [App\Http\Controllers\Admin\ServiceController::class, 'edit'])->name('service.edit')->middleware('permission:service.edit');

        ////////////////////  SubjectController ///////////////////////////////
        Route::get('subject/select', [App\Http\Controllers\Admin\SubjectController::class, 'select'])->name('subject.select');
        Route::delete('subject/bulk', [App\Http\Controllers\Admin\SubjectController::class, 'deleteBulk'])->name('subject.deleteBulk');
        Route::get('subject/list', [App\Http\Controllers\Admin\SubjectController::class, 'list'])->name('subject.list')->middleware('permission:subject.view');
        Route::post('subject', [App\Http\Controllers\Admin\SubjectController::class, 'store'])->name('subject.store')->middleware('permission:subject.create');
        Route::delete('subject/{id}', [App\Http\Controllers\Admin\SubjectController::class, 'destroy'])->name('subject.destroy')->middleware('permission:subject.delete');
        Route::get('subject', [App\Http\Controllers\Admin\SubjectController::class, 'index'])->name('subject.index')->middleware('permission:subject.view');
        Route::get('subject/create', [App\Http\Controllers\Admin\SubjectController::class, 'create'])->name('subject.create')->middleware('permission:subject.create');
        Route::match(['PUT', 'PATCH'], 'subject/{id}', [App\Http\Controllers\Admin\SubjectController::class, 'update'])->name('subject.update')->middleware('permission:subject.edit');
        Route::get('subject/{id}/edit', [App\Http\Controllers\Admin\SubjectController::class, 'edit'])->name('subject.edit')->middleware('permission:subject.edit');

        ////////////////////   visit ////////////////////////////////
        
        Route::get('supervisor_report', [App\Http\Controllers\Admin\VisitController::class, 'supervisor_visit_report'])->name('visit.report');
        Route::get('visit/select', [App\Http\Controllers\Admin\VisitController::class, 'select'])->name('visit.select');
        Route::delete('visit/bulk', [App\Http\Controllers\Admin\VisitController::class, 'deleteBulk'])->name('visit.deleteBulk');
        Route::get('visit/list', [App\Http\Controllers\Admin\VisitController::class, 'list'])->name('visit.list')->middleware('permission:visit.view');
        Route::post('visit', [App\Http\Controllers\Admin\VisitController::class, 'store'])->name('visit.store')->middleware('permission:visit.create');
        Route::delete('visit/{id}', [App\Http\Controllers\Admin\VisitController::class, 'destroy'])->name('visit.destroy')->middleware('permission:visit.delete');
        Route::get('visit', [App\Http\Controllers\Admin\VisitController::class, 'index'])->name('visit.index')->middleware('permission:visit.view');
        Route::get('visit/create', [App\Http\Controllers\Admin\VisitController::class, 'create'])->name('visit.create')->middleware('permission:visit.create');
        Route::match(['PUT', 'PATCH'], 'visit/{id}', [App\Http\Controllers\Admin\VisitController::class, 'update'])->name('visit.update')->middleware('permission:visit.edit');
        Route::get('visit/{id}/edit', [App\Http\Controllers\Admin\VisitController::class, 'edit'])->name('visit.edit')->middleware('permission:visit.edit');
       
        /////////////////////  visit_details /////////////////////////////////

        Route::delete('visit_details/bulk', [App\Http\Controllers\Admin\VisitDetailsController::class, 'deleteBulk'])->name('visit_details.deleteBulk');
        Route::get('visit_details/list/{visit_id?}', [App\Http\Controllers\Admin\VisitDetailsController::class, 'list'])->name('visit_details.list')->middleware('permission:visit_details.view');
        Route::post('visit_details', [App\Http\Controllers\Admin\VisitDetailsController::class, 'store'])->name('visit_details.store')->middleware('permission:visit_details.create');
        Route::delete('visit_details/{id}', [App\Http\Controllers\Admin\VisitDetailsController::class, 'destroy'])->name('visit_details.destroy')->middleware('permission:visit_details.delete');
        Route::get('visit_details/{id?}', [App\Http\Controllers\Admin\VisitDetailsController::class, 'index'])->name('visit_details.index')->middleware('permission:visit_details.view');
        Route::get('visit_details/create/{visit_id?}', [App\Http\Controllers\Admin\VisitDetailsController::class, 'create'])->name('visit_details.create')->middleware('permission:visit_details.create');
        Route::match(['PUT', 'PATCH'], 'visit_details/{id}', [App\Http\Controllers\Admin\VisitDetailsController::class, 'update'])->name('visit_details.update')->middleware('permission:visit_details.edit');
        Route::get('visit_details/{id}/edit', [App\Http\Controllers\Admin\VisitDetailsController::class, 'edit'])->name('visit_details.edit')->middleware('permission:visit_details.edit');
       
        /////////////////////////////////////// workers   ////////////////////////////
        Route::get('workers/select', [App\Http\Controllers\Admin\WorkerController::class, 'select'])->name('workers.select');
        Route::delete('workers/bulk', [App\Http\Controllers\Admin\WorkerController::class, 'deleteBulk'])->name('workers.deleteBulk');
        Route::get('workers/list', [App\Http\Controllers\Admin\WorkerController::class, 'list'])->name('workers.list')->middleware('permission:workers.view');
        Route::post('workers', [App\Http\Controllers\Admin\WorkerController::class, 'store'])->name('workers.store')->middleware('permission:workers.create');
        Route::delete('workers/{id}', [App\Http\Controllers\Admin\WorkerController::class, 'destroy'])->name('workers.destroy')->middleware('permission:workers.delete');
        Route::get('workers', [App\Http\Controllers\Admin\WorkerController::class, 'index'])->name('workers.index')->middleware('permission:workers.view');
        Route::get('worker/create', [App\Http\Controllers\Admin\WorkerController::class, 'create'])->name('worker.create')->middleware('permission:workers.create');
        Route::match(['PUT', 'PATCH'], 'workers/{id}', [App\Http\Controllers\Admin\WorkerController::class, 'update'])->name('workers.update')->middleware('permission:workers.edit');
        Route::get('workers/{id}/edit', [App\Http\Controllers\Admin\WorkerController::class, 'edit'])->name('workers.edit')->middleware('permission:workers.edit');

        ////////////////  salary //////////////////////////////////////
        Route::get('salary/{id}/print', [App\Http\Controllers\Admin\SalaryController::class, 'print'])->name('salary.print')->middleware('permission:salary.view');
        Route::delete('salary/bulk', [App\Http\Controllers\Admin\SalaryController::class, 'deleteBulk'])->name('salary.deleteBulk');
        Route::get('salary/list', [App\Http\Controllers\Admin\SalaryController::class, 'list'])->name('salary.list')->middleware('permission:salary.view');
        Route::post('salary', [App\Http\Controllers\Admin\SalaryController::class, 'store'])->name('salary.store')->middleware('permission:salary.create');
        Route::delete('salary/{id}', [App\Http\Controllers\Admin\SalaryController::class, 'destroy'])->name('salary.destroy')->middleware('permission:salary.delete');
        Route::get('salary', [App\Http\Controllers\Admin\SalaryController::class, 'index'])->name('salary.index')->middleware('permission:salary.view');
        Route::get('salary/create', [App\Http\Controllers\Admin\SalaryController::class, 'create'])->name('salary.create')->middleware('permission:salary.create');
        Route::match(['PUT', 'PATCH'], 'salary/{id}', [App\Http\Controllers\Admin\SalaryController::class, 'update'])->name('salary.update')->middleware('permission:salary.edit');
        Route::get('salary/{id}/edit', [App\Http\Controllers\Admin\SalaryController::class, 'edit'])->name('salary.edit')->middleware('permission:salary.edit');
        //////////////  backage  ///////////////////////////////////////////////////////
        Route::get('backage/select', [App\Http\Controllers\Admin\BackageController::class, 'select'])->name('backage.select');
        Route::get('backage/{id}/print', [App\Http\Controllers\Admin\BackageController::class, 'print'])->name('backage.print')->middleware('permission:backage.view');
        Route::delete('backage/bulk', [App\Http\Controllers\Admin\BackageController::class, 'deleteBulk'])->name('backage.deleteBulk');
        Route::get('backage/list', [App\Http\Controllers\Admin\BackageController::class, 'list'])->name('backage.list')->middleware('permission:backage.view');
        Route::post('backage', [App\Http\Controllers\Admin\BackageController::class, 'store'])->name('backage.store')->middleware('permission:backage.create');
        Route::delete('backage/{id}', [App\Http\Controllers\Admin\BackageController::class, 'destroy'])->name('backage.destroy')->middleware('permission:backage.delete');
        Route::get('backage', [App\Http\Controllers\Admin\BackageController::class, 'index'])->name('backage.index')->middleware('permission:backage.view');
        Route::get('backage/create', [App\Http\Controllers\Admin\BackageController::class, 'create'])->name('backage.create')->middleware('permission:backage.create');
        Route::match(['PUT', 'PATCH'], 'backage/{id}', [App\Http\Controllers\Admin\BackageController::class, 'update'])->name('backage.update')->middleware('permission:backage.edit');
        Route::get('backage/{id}/edit', [App\Http\Controllers\Admin\BackageController::class, 'edit'])->name('backage.edit')->middleware('permission:backage.edit');
       ////////////////  backage_details  ///////////////////////////
       Route::get('backage_details/select', [App\Http\Controllers\Admin\BackageDetailController::class, 'select'])->name('backage_details.select');
       Route::get('backage_details/{id}/print', [App\Http\Controllers\Admin\BackageDetailController::class, 'print'])->name('backage_details.print')->middleware('permission:backage_details.view');
       Route::delete('backage_details/bulk', [App\Http\Controllers\Admin\BackageDetailController::class, 'deleteBulk'])->name('backage_details.deleteBulk');
       Route::get('backage_details/list', [App\Http\Controllers\Admin\BackageDetailController::class, 'list'])->name('backage_details.list')->middleware('permission:backage_details.view');
       Route::post('backage_details', [App\Http\Controllers\Admin\BackageDetailController::class, 'store'])->name('backage_details.store')->middleware('permission:backage_details.create');
       Route::delete('backage_details/{id}', [App\Http\Controllers\Admin\BackageDetailController::class, 'destroy'])->name('backage_details.destroy')->middleware('permission:backage_details.delete');
       Route::get('backage_details', [App\Http\Controllers\Admin\BackageDetailController::class, 'index'])->name('backage_details.index')->middleware('permission:backage_details.view');
       Route::get('backage_details/create', [App\Http\Controllers\Admin\BackageDetailController::class, 'create'])->name('backage_details.create')->middleware('permission:backage_details.create');
       Route::match(['PUT', 'PATCH'], 'backage_details/{id}', [App\Http\Controllers\Admin\BackageDetailController::class, 'update'])->name('backage_details.update')->middleware('permission:backage_details.edit');
       Route::get('backage_details/{id}/edit', [App\Http\Controllers\Admin\BackageDetailController::class, 'edit'])->name('backage_details.edit')->middleware('permission:backage_details.edit');
       /////////////////////////////////////////////////////////
    


  













        Route::get('roles/select', [App\Http\Controllers\Admin\RoleController::class, 'select'])->name('roles.select');
        Route::get('roles/list', [App\Http\Controllers\Admin\RoleController::class, 'list'])->name('roles.list')->middleware('permission:roles.view');
        Route::post('roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.create');
        Route::delete('roles/{id}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:roles.delete');
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->middleware('permission:roles.view');
        Route::get('roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->middleware('permission:roles.create');
        Route::match(['PUT', 'PATCH'], 'roles/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.edit');
        Route::get('roles/{id}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:roles.edit');



        ////////////////// report ///////////////////

        Route::get('saller/report', [App\Http\Controllers\Admin\AdminController::class, 'sallerReport'])->name('saller.report')->middleware('permission:users.report');
        Route::get('get-paths', [App\Http\Controllers\Admin\AdminController::class, 'getPaths'])->name('getPaths');
        Route::get('daily-target', [App\Http\Controllers\Admin\AdminController::class, 'dailyreport'])->name('daily.target')->middleware('permission:targets.dailyreport');
        Route::get('saller-group', [App\Http\Controllers\Admin\AdminController::class, 'sallerGroup'])->name('saller.group')->middleware('permission:saller.group');
        Route::get('saller-group/export-excel', [App\Http\Controllers\Admin\AdminController::class, 'export'])->name('group.export_excel')->middleware('permission:saller.group');
        Route::post('saller-group', [App\Http\Controllers\Admin\AdminController::class, 'sallerGroup'])->name('saller.group')->middleware('permission:saller.group');
        Route::get('whatsapp-report', [App\Http\Controllers\Admin\AdminController::class, 'whatsappReport'])->name('whatsapps.report')->middleware('permission:whatsapps.report');
        Route::post('whatsapp-report', [App\Http\Controllers\Admin\AdminController::class, 'whatsappReport'])->name('whatsapps.report')->middleware('permission:whatsapps.report');
        Route::post('saller/report', [App\Http\Controllers\Admin\AdminController::class, 'sallerReport'])->name('saller.report')->middleware('permission:users.report');


        Route::get('links-report', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('links.report');
        Route::get('links-report/list', [App\Http\Controllers\Admin\ReportController::class, 'list'])->name('links-report.list');
        Route::get('doner/report', [App\Http\Controllers\Admin\ReportController::class, 'donersReport'])->name('doners.report');
        Route::get('projectDonor/report', [App\Http\Controllers\Admin\ReportController::class, 'project_donors_report'])->name('projectDonor.report')->middleware('permission:users.report');





    });
});
