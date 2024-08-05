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
    Route::get('categories/select', [App\Http\Controllers\Admin\CategoryController::class, 'select'])->name('categories.select');

    Route::get('projects/select', [App\Http\Controllers\Admin\ProjectController::class, 'select'])->name('projects.select');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('home');

        Route::post('links/list', [App\Http\Controllers\Admin\LinkController::class, 'list'])->name('links.list');
        Route::get('links', [App\Http\Controllers\Admin\LinkController::class, 'index'])->name('links.index');
        Route::get('links/show/{id}', [App\Http\Controllers\Admin\LinkController::class, 'show'])->name('links.show');
        Route::post('links', [App\Http\Controllers\Admin\LinkController::class, 'store'])->name('links.store')->middleware('permission:links.create');
        Route::post('importdd', [App\Http\Controllers\Admin\LinkController::class, 'import'])->name('links.import')->middleware('permission:targets.create');
        Route::get('links/create', [App\Http\Controllers\Admin\LinkController::class, 'create'])->name('links.create')->middleware('permission:links.create');
        Route::post('exportLink', [App\Http\Controllers\Admin\LinkController::class, 'exportLink'])->name('links.exportLink')->middleware('permission:links.view');
        // Route::post('import', [App\Http\Controllers\Admin\LinkController::class, 'import'])->name('links.import')->middleware('permission:links.create');



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




        Route::get('sections/select', [App\Http\Controllers\Admin\SectionController::class, 'select'])->name('sections.select');
        Route::delete('sections/bulk', [App\Http\Controllers\Admin\SectionController::class, 'deleteBulk'])->name('sections.deleteBulk');
        Route::get('sections/list', [App\Http\Controllers\Admin\SectionController::class, 'list'])->name('sections.list')->middleware('permission:sections.view');
        Route::post('sections', [App\Http\Controllers\Admin\SectionController::class, 'store'])->name('sections.store')->middleware('permission:sections.create');
        Route::delete('sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'destroy'])->name('sections.destroy')->middleware('permission:sections.delete');
        Route::get('sections', [App\Http\Controllers\Admin\SectionController::class, 'index'])->name('sections.index')->middleware('permission:sections.view');
        Route::get('sections/create', [App\Http\Controllers\Admin\SectionController::class, 'create'])->name('sections.create')->middleware('permission:sections.create');
        Route::match(['PUT', 'PATCH'], 'sections/{id}', [App\Http\Controllers\Admin\SectionController::class, 'update'])->name('sections.update')->middleware('permission:sections.edit');
        Route::get('sections/{id}/edit', [App\Http\Controllers\Admin\SectionController::class, 'edit'])->name('sections.edit')->middleware('permission:sections.edit');

        Route::get('targets/select', [App\Http\Controllers\Admin\TargetController::class, 'select'])->name('targets.select');
        Route::delete('targets/bulk', [App\Http\Controllers\Admin\TargetController::class, 'deleteBulk'])->name('targets.deleteBulk');
        Route::get('targets/show/{id}', [App\Http\Controllers\Admin\TargetController::class, 'show'])->name('targets.show')->middleware('permissions:targets.view');
        Route::get('targets/list', [App\Http\Controllers\Admin\TargetController::class, 'list'])->name('targets.list')->middleware('permission:targets.view');
        Route::get('targets/alllist', [App\Http\Controllers\Admin\TargetController::class, 'alllist'])->name('targets.alllist')->middleware('permission:targets.view');

        Route::post('targets', [App\Http\Controllers\Admin\TargetController::class, 'store'])->name('targets.store')->middleware('permission:targets.create');
        Route::post('import', [App\Http\Controllers\Admin\TargetController::class, 'import'])->name('targets.import')->middleware('permission:targets.create');
        Route::delete('targets/{id}', [App\Http\Controllers\Admin\TargetController::class, 'destroy'])->name('targets.destroy')->middleware('permission:targets.delete');
        Route::get('targets', [App\Http\Controllers\Admin\TargetController::class, 'index'])->name('targets.index')->middleware('permission:targets.view');
        Route::get('all-targets', [App\Http\Controllers\Admin\TargetController::class, 'targets'])->name('targets.all')->middleware('permission:targets.view');

        Route::get('targets/create', [App\Http\Controllers\Admin\TargetController::class, 'create'])->name('targets.create')->middleware('permission:targets.create');
        Route::match(['PUT', 'PATCH'], 'targets/{id}', [App\Http\Controllers\Admin\TargetController::class, 'update'])->name('targets.update')->middleware('permission:targets.edit');
        Route::get('targets/{id}/edit', [App\Http\Controllers\Admin\TargetController::class, 'edit'])->name('targets.edit')->middleware('permission:targets.edit');

        Route::get('updatePhones', [App\Http\Controllers\Admin\ProjectController::class, 'updatePhones'])->name('projects.updatePhones')->middleware('permission:projects.send');
        Route::get('projects/send', [App\Http\Controllers\Admin\ProjectController::class, 'send'])->name('projects.send')->middleware('permission:projects.send');
        Route::get('projects/sendProjects', [App\Http\Controllers\Admin\ProjectController::class, 'send'])->name('projects.sendProjects')->middleware('permission:projects.send');
        Route::get('projects/select-number', [App\Http\Controllers\Admin\ProjectController::class, 'selectNumber'])->name('projects.selectNumber');
        Route::delete('projects/bulk', [App\Http\Controllers\Admin\ProjectController::class, 'deleteBulk'])->name('projects.deleteBulk');
        Route::get('projects/list', [App\Http\Controllers\Admin\ProjectController::class, 'list'])->name('projects.list')->middleware('permission:projects.view');
        Route::post('projects', [App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('projects.store')->middleware('permission:projects.create');
        Route::post('projects/resendProjects', [App\Http\Controllers\Admin\ProjectController::class, 'resendProjects'])->name('projects.resendProjects')->middleware('permission:projects.create');
        Route::delete('projects/{id}', [App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('projects.destroy')->middleware('permission:projects.delete');
        Route::get('projects', [App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('projects.index')->middleware('permission:projects.view');
        Route::get('projects/create', [App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('projects.create')->middleware('permission:projects.create');
        Route::match(['PUT', 'PATCH'], 'projects/{id}', [App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('projects.update')->middleware('permission:projects.edit');
        Route::get('projects/{id}/edit', [App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('projects.edit')->middleware('permission:projects.edit');
        Route::get('projects/code', [App\Http\Controllers\Admin\ProjectController::class, 'code'])->name('projects.code')->middleware('permission:projects.updatecode');
        Route::post('projects/code', [App\Http\Controllers\Admin\ProjectController::class, 'code'])->name('projects.code')->middleware('permission:projects.updatecode');
        Route::post('projects/updatecode', [App\Http\Controllers\Admin\ProjectController::class, 'updatecode'])->name('projects.updatecode')->middleware('permission:projects.updatecode');
        Route::post('exportProject', [App\Http\Controllers\Admin\ProjectController::class, 'exportProject'])->name('projects.exportProject')->middleware('permission:projects.view');

        Route::delete('categories/bulk', [App\Http\Controllers\Admin\CategoryController::class, 'deleteBulk'])->name('categories.deleteBulk');
        Route::get('categories/list', [App\Http\Controllers\Admin\CategoryController::class, 'list'])->name('categories.list')->middleware('permission:categories.view');
        Route::post('categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store')->middleware('permission:categories.create');
        Route::delete('categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:categories.delete');
        Route::get('categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index')->middleware('permission:categories.view');
        Route::get('categories/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create')->middleware('permission:categories.create');
        Route::match(['PUT', 'PATCH'], 'categories/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update')->middleware('permission:categories.edit');
        Route::get('categories/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:categories.edit');

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

        Route::delete('salary/bulk', [App\Http\Controllers\Admin\SalaryController::class, 'deleteBulk'])->name('salary.deleteBulk');
        Route::get('salary/list', [App\Http\Controllers\Admin\SalaryController::class, 'list'])->name('salary.list')->middleware('permission:salary.view');
        Route::post('salary', [App\Http\Controllers\Admin\SalaryController::class, 'store'])->name('salary.store')->middleware('permission:salary.create');
        Route::delete('salary/{id}', [App\Http\Controllers\Admin\SalaryController::class, 'destroy'])->name('salary.destroy')->middleware('permission:salary.delete');
        Route::get('salary', [App\Http\Controllers\Admin\SalaryController::class, 'index'])->name('salary.index')->middleware('permission:salary.view');
        Route::get('salary/create', [App\Http\Controllers\Admin\SalaryController::class, 'create'])->name('salary.create')->middleware('permission:salary.create');
        Route::match(['PUT', 'PATCH'], 'salary/{id}', [App\Http\Controllers\Admin\SalaryController::class, 'update'])->name('salary.update')->middleware('permission:salary.edit');
        Route::get('salary/{id}/edit', [App\Http\Controllers\Admin\SalaryController::class, 'edit'])->name('salary.edit')->middleware('permission:salary.edit');

        /////////////////////////////////////////////////////////////////////
        Route::delete('compain/bulk', [App\Http\Controllers\Admin\CompainController::class, 'deleteBulk'])->name('compain.deleteBulk');
        Route::get('compain/list', [App\Http\Controllers\Admin\CompainController::class, 'list'])->name('compain.list')->middleware('permission:compain.view');
        Route::post('compain', [App\Http\Controllers\Admin\CompainController::class, 'store'])->name('compain.store')->middleware('permission:compain.create');
        Route::delete('compain/{id}', [App\Http\Controllers\Admin\CompainController::class, 'destroy'])->name('compain.destroy')->middleware('permission:compain.delete');
        Route::get('compain', [App\Http\Controllers\Admin\CompainController::class, 'index'])->name('compain.index')->middleware('permission:compain.view');
        Route::get('compain/create', [App\Http\Controllers\Admin\CompainController::class, 'create'])->name('compain.create')->middleware('permission:compain.create');
        Route::match(['PUT', 'PATCH'], 'compain/{id}', [App\Http\Controllers\Admin\CompainController::class, 'update'])->name('compain.update')->middleware('permission:compain.edit');
        Route::get('compain/{id}/edit', [App\Http\Controllers\Admin\CompainController::class, 'edit'])->name('compain.edit')->middleware('permission:categories.edit');


        Route::get('doner_types/select', [App\Http\Controllers\Admin\DonerTypeController::class, 'select'])->name('doner_types.select');
        Route::delete('doner_types/bulk', [App\Http\Controllers\Admin\DonerTypeController::class, 'deleteBulk'])->name('doner_types.deleteBulk');
        Route::get('doner_types/list', [App\Http\Controllers\Admin\DonerTypeController::class, 'list'])->name('doner_types.list')->middleware('permission:doner_types.view');
        Route::post('doner_types', [App\Http\Controllers\Admin\DonerTypeController::class, 'store'])->name('doner_types.store')->middleware('permission:doner_types.create');
        Route::delete('doner_types/{id}', [App\Http\Controllers\Admin\DonerTypeController::class, 'destroy'])->name('doner_types.destroy')->middleware('permission:doner_types.delete');
        Route::get('doner_types', [App\Http\Controllers\Admin\DonerTypeController::class, 'index'])->name('doner_types.index')->middleware('permission:doner_types.view');
        Route::get('doner_types/create', [App\Http\Controllers\Admin\DonerTypeController::class, 'create'])->name('doner_types.create')->middleware('permission:doner_types.create');
        Route::match(['PUT', 'PATCH'], 'doner_types/{id}', [App\Http\Controllers\Admin\DonerTypeController::class, 'update'])->name('doner_types.update')->middleware('permission:doner_types.edit');
        Route::get('doner_types/{id}/edit', [App\Http\Controllers\Admin\DonerTypeController::class, 'edit'])->name('doner_types.edit')->middleware('permission:doner_types.edit');

        Route::get('client_categories/select', [App\Http\Controllers\Admin\ClientCategoryController::class, 'select'])->name('client_categories.select');
        Route::delete('client_categories/bulk', [App\Http\Controllers\Admin\ClientCategoryController::class, 'deleteBulk'])->name('client_categories.deleteBulk');
        Route::get('client_categories/list', [App\Http\Controllers\Admin\ClientCategoryController::class, 'list'])->name('client_categories.list')->middleware('permission:client_categories.view');
        Route::post('client_categories', [App\Http\Controllers\Admin\ClientCategoryController::class, 'store'])->name('client_categories.store')->middleware('permission:client_categories.create');
        Route::delete('client_categories/{id}', [App\Http\Controllers\Admin\ClientCategoryController::class, 'destroy'])->name('client_categories.destroy')->middleware('permission:client_categories.delete');
        Route::get('client_categories', [App\Http\Controllers\Admin\ClientCategoryController::class, 'index'])->name('client_categories.index')->middleware('permission:client_categories.view');
        Route::get('client_categories/create', [App\Http\Controllers\Admin\ClientCategoryController::class, 'create'])->name('client_categories.create')->middleware('permission:client_categories.create');
        Route::match(['PUT', 'PATCH'], 'client_categories/{id}', [App\Http\Controllers\Admin\ClientCategoryController::class, 'update'])->name('client_categories.update')->middleware('permission:client_categories.edit');
        Route::get('client_categories/{id}/edit', [App\Http\Controllers\Admin\ClientCategoryController::class, 'edit'])->name('client_categories.edit')->middleware('permission:doner_types.edit');

        Route::get('client/select', [App\Http\Controllers\Admin\ClientController::class, 'select'])->name('client.select');
        Route::post('client/import', [App\Http\Controllers\Admin\ClientController::class, 'import'])->name('client.import')  ;//->middleware('permission:client.create');
        Route::delete('client/bulk', [App\Http\Controllers\Admin\ClientController::class, 'deleteBulk'])->name('client.deleteBulk');
        Route::get('client/list', [App\Http\Controllers\Admin\ClientController::class, 'list'])->name('client.list')->middleware('permission:client.view');
        Route::post('client', [App\Http\Controllers\Admin\ClientController::class, 'store'])->name('client.store')->middleware('permission:client.create');
        Route::delete('client/{id}', [App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('client.destroy')->middleware('permission:client.delete');
        Route::get('client', [App\Http\Controllers\Admin\ClientController::class, 'index'])->name('client.index')->middleware('permission:client.view');
        Route::get('client/create', [App\Http\Controllers\Admin\ClientController::class, 'create'])->name('client.create')->middleware('permission:client.create');
        Route::match(['PUT', 'PATCH'], 'client/{id}', [App\Http\Controllers\Admin\ClientController::class, 'update'])->name('client.update')->middleware('permission:client.edit');
        Route::get('client/{id}/edit', [App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('client.edit')->middleware('permission:client.edit');

        Route::get('BlackList/select', [App\Http\Controllers\Admin\BlackListController::class, 'select'])->name('BlackList.select');
        Route::post('BlackList/import', [App\Http\Controllers\Admin\BlackListController::class, 'import'])->name('BlackList.import')  ;//->middleware('permission:BlackList.create');
        Route::delete('BlackList/bulk', [App\Http\Controllers\Admin\BlackListController::class, 'deleteBulk'])->name('BlackList.deleteBulk');
        Route::get('BlackList/list', [App\Http\Controllers\Admin\BlackListController::class, 'list'])->name('BlackList.list')->middleware('permission:BlackList.view');
        Route::post('BlackList', [App\Http\Controllers\Admin\BlackListController::class, 'store'])->name('BlackList.store')->middleware('permission:BlackList.create');
        Route::delete('BlackList/{id}', [App\Http\Controllers\Admin\BlackListController::class, 'destroy'])->name('BlackList.destroy')->middleware('permission:BlackList.delete');
        Route::get('BlackList', [App\Http\Controllers\Admin\BlackListController::class, 'index'])->name('BlackList.index')->middleware('permission:BlackList.view');
        Route::get('BlackList/create', [App\Http\Controllers\Admin\BlackListController::class, 'create'])->name('BlackList.create')->middleware('permission:BlackList.create');
        Route::match(['PUT', 'PATCH'], 'BlackList/{id}', [App\Http\Controllers\Admin\BlackListController::class, 'update'])->name('BlackList.update')->middleware('permission:BlackList.edit');
        Route::get('BlackList/{id}/edit', [App\Http\Controllers\Admin\BlackListController::class, 'edit'])->name('BlackList.edit')->middleware('permission:BlackList.edit');

        Route::get('type/select', [App\Http\Controllers\Admin\TypeController::class, 'select'])->name('type.select');
        Route::delete('type/bulk', [App\Http\Controllers\Admin\TypeController::class, 'deleteBulk'])->name('type.deleteBulk');
        Route::get('type/list', [App\Http\Controllers\Admin\TypeController::class, 'list'])->name('type.list')->middleware('permission:type.view');
        Route::post('type', [App\Http\Controllers\Admin\TypeController::class, 'store'])->name('type.store')->middleware('permission:type.create');
        Route::delete('type/{id}', [App\Http\Controllers\Admin\TypeController::class, 'destroy'])->name('type.destroy')->middleware('permission:type.delete');
        Route::get('type', [App\Http\Controllers\Admin\TypeController::class, 'index'])->name('type.index')->middleware('permission:type.view');
        Route::get('type/create', [App\Http\Controllers\Admin\TypeController::class, 'create'])->name('type.create')->middleware('permission:type.create');
        Route::match(['PUT', 'PATCH'], 'type/{id}', [App\Http\Controllers\Admin\TypeController::class, 'update'])->name('type.update')->middleware('permission:type.edit');
        Route::get('type/{id}/edit', [App\Http\Controllers\Admin\TypeController::class, 'edit'])->name('type.edit')->middleware('permission:doner_types.edit');


        Route::get('download-excel/{id}', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'whatsAppExcel'])->name('whatsAppExcel');

        Route::get('doners/select', [App\Http\Controllers\Admin\DonerController::class, 'select'])->name('doners.select');
        Route::delete('doners/bulk', [App\Http\Controllers\Admin\DonerController::class, 'deleteBulk'])->name('doners.deleteBulk');
        Route::get('doners/list', [App\Http\Controllers\Admin\DonerController::class, 'list'])->name('doners.list')->middleware('permission:doners.view');
        Route::post('doners', [App\Http\Controllers\Admin\DonerController::class, 'store'])->name('doners.store')->middleware('permission:doners.create');
        Route::delete('doners/{id}', [App\Http\Controllers\Admin\DonerController::class, 'destroy'])->name('doners.destroy')->middleware('permission:doners.delete');
        Route::get('doners', [App\Http\Controllers\Admin\DonerController::class, 'index'])->name('doners.index')->middleware('permission:doners.view');
        Route::get('doners/create', [App\Http\Controllers\Admin\DonerController::class, 'create'])->name('doners.create')->middleware('permission:doners.create');
        Route::match(['PUT', 'PATCH'], 'doners/{id}', [App\Http\Controllers\Admin\DonerController::class, 'update'])->name('doners.update')->middleware('permission:doners.edit');
        Route::get('doners/{id}/edit', [App\Http\Controllers\Admin\DonerController::class, 'edit'])->name('doners.edit')->middleware('permission:doners.edit');

        Route::delete('contacts/bulk', [App\Http\Controllers\Admin\ContactController::class, 'deleteBulk'])->name('contacts.deleteBulk');
        Route::get('contacts/list', [App\Http\Controllers\Admin\ContactController::class, 'list'])->name('contacts.list')->middleware('permission:contacts.view');
        Route::get('contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index')->middleware('permission:contacts.view');


        Route::get('whatsapps/select', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'select'])->name('whatsapps.select');
        Route::get('whatsapps/select2', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'select2'])->name('whatsapps.select2');
        Route::delete('whatsapps/bulk', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'deleteBulk'])->name('whatsapps.deleteBulk');
        Route::get('whatsapps/list', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'list'])->name('whatsapps.list')->middleware('permission:whatsapps.view');
        Route::post('whatsapps', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'store'])->name('whatsapps.store')->middleware('permission:whatsapps.create');
        Route::delete('whatsapps/{id}', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'destroy'])->name('whatsapps.destroy')->middleware('permission:whatsapps.delete');
        Route::get('whatsapps', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'index'])->name('whatsapps.index')->middleware('permission:whatsapps.view');
        Route::get('whatsapps/create', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'create'])->name('whatsapps.create')->middleware('permission:whatsapps.create');
        Route::match(['PUT', 'PATCH'], 'whatsapps/{id}', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'update'])->name('whatsapps.update')->middleware('permission:whatsapps.edit');
        Route::get('whatsapps/{id}/edit', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'edit'])->name('whatsapps.edit')->middleware('permission:whatsapps.edit');
        Route::post('whatsapps/getseneded', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'getRemain'])->name('whatsapps.sended');
        Route::post('get-ajax-remain', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'getRemainAjax'])->name('whatsapps.getRemainAjax');

        Route::post('whatsPercent/{id}', [App\Http\Controllers\Admin\WhatsappSettingController::class, 'whatsPercent'])->name('whatsPercent')->middleware('permission:settings.whatsPercent');


        Route::get('reminders/select', [App\Http\Controllers\Admin\ReminderController::class, 'select'])->name('reminders.select');
        Route::delete('reminders/bulk', [App\Http\Controllers\Admin\ReminderController::class, 'deleteBulk'])->name('reminders.deleteBulk');
        Route::get('reminders/list', [App\Http\Controllers\Admin\ReminderController::class, 'list'])->name('reminders.list')->middleware('permission:reminders.view');
        Route::post('reminders', [App\Http\Controllers\Admin\ReminderController::class, 'store'])->name('reminders.store')->middleware('permission:reminders.create');
        Route::delete('reminders/{id}', [App\Http\Controllers\Admin\ReminderController::class, 'destroy'])->name('reminders.destroy')->middleware('permission:reminders.delete');
        Route::get('reminders', [App\Http\Controllers\Admin\ReminderController::class, 'index'])->name('reminders.index')->middleware('permission:reminders.view');
        Route::get('reminders/create', [App\Http\Controllers\Admin\ReminderController::class, 'create'])->name('reminders.create')->middleware('permission:reminders.create');
        Route::match(['PUT', 'PATCH'], 'reminders/{id}', [App\Http\Controllers\Admin\ReminderController::class, 'update'])->name('reminders.update')->middleware('permission:reminders.edit');
        Route::get('reminders/{id}/edit', [App\Http\Controllers\Admin\ReminderController::class, 'edit'])->name('reminders.edit')->middleware('permission:reminders.edit');

        Route::get('whatsapp_phones/select', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'select'])->name('whatsapp_phones.select');
        Route::delete('whatsapp_phones/bulk', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'deleteBulk'])->name('whatsapp_phones.deleteBulk');
        Route::get('whatsapp_phones/list', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'list'])->name('whatsapp_phones.list')->middleware('permission:whatsapp_phones.view');
        Route::post('whatsapp_phones', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'store'])->name('whatsapp_phones.store')->middleware('permission:whatsapp_phones.create');
        Route::delete('whatsapp_phones/{id}', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'destroy'])->name('whatsapp_phones.destroy')->middleware('permission:whatsapp_phones.delete');
        Route::get('whatsapp_phones', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'index'])->name('whatsapp_phones.index')->middleware('permission:whatsapp_phones.view');
        Route::get('whatsapp_phones/create', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'create'])->name('whatsapp_phones.create')->middleware('permission:whatsapp_phones.create');
        Route::match(['PUT', 'PATCH'], 'whatsapp_phones/{id}', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'update'])->name('whatsapp_phones.update')->middleware('permission:whatsapp_phones.edit');
        Route::get('whatsapp_phones/{id}/edit', [App\Http\Controllers\Admin\WhatsappPhoneController::class, 'edit'])->name('whatsapp_phones.edit')->middleware('permission:whatsapp_phones.edit');

        Route::get('qrcode_messages/select', [App\Http\Controllers\Admin\QrcodeController::class, 'select'])->name('qrcode_messages.select');
        Route::delete('qrcode_messages/bulk', [App\Http\Controllers\Admin\QrcodeController::class, 'deleteBulk'])->name('qrcode_messages.deleteBulk');
        Route::get('qrcode_messages/list', [App\Http\Controllers\Admin\QrcodeController::class, 'list'])->name('qrcode_messages.list')->middleware('permission:qrcode_messages.view');
        Route::post('qrcode_messages', [App\Http\Controllers\Admin\QrcodeController::class, 'store'])->name('qrcode_messages.store')->middleware('permission:qrcode_messages.create');
        Route::post('importqrcode', [App\Http\Controllers\Admin\QrcodeController::class, 'import'])->name('qrcode_messages.import')->middleware('permission:qrcode_messages.create');

        Route::delete('qrcode_messages/{id}', [App\Http\Controllers\Admin\QrcodeController::class, 'destroy'])->name('qrcode_messages.destroy')->middleware('permission:qrcode_messages.delete');
        Route::get('qrcode_messages', [App\Http\Controllers\Admin\QrcodeController::class, 'index'])->name('qrcode_messages.index')->middleware('permission:qrcode_messages.view');
        Route::get('qrcode_messages/create', [App\Http\Controllers\Admin\QrcodeController::class, 'create'])->name('qrcode_messages.create')->middleware('permission:qrcode_messages.create');
        Route::match(['PUT', 'PATCH'], 'qrcode_messages/{id}', [App\Http\Controllers\Admin\QrcodeController::class, 'update'])->name('qrcode_messages.update')->middleware('permission:qrcode_messages.edit');
        Route::get('qrcode_messages/{id}/edit', [App\Http\Controllers\Admin\QrcodeController::class, 'edit'])->name('qrcode_messages.edit')->middleware('permission:qrcode_messages.edit');

        Route::get('project_phones/select', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'select'])->name('project_phones.select');
        Route::delete('project_phones/bulk', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'deleteBulk'])->name('project_phones.deleteBulk');
        Route::get('project_phones/list', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'list'])->name('project_phones.list')->middleware('permission:project_phones.view');
        Route::get('category_phones/create', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'category_phones'])->name('category_phones.create')->middleware('permission:category_phones.create');
        Route::post('category_phones/store', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'category_phones_store'])->name('category_phones.store')->middleware('permission:category_phones.create');

        Route::post('project_phones', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'store'])->name('project_phones.store')->middleware('permission:project_phones.create');
        Route::delete('project_phones/{id}', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'destroy'])->name('project_phones.destroy')->middleware('permission:project_phones.delete');
        Route::get('project_phones', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'index'])->name('project_phones.index')->middleware('permission:project_phones.view');
        Route::get('project_phones/create', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'create'])->name('project_phones.create')->middleware('permission:project_phones.create');
        Route::match(['PUT', 'PATCH'], 'project_phones/{id}', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'update'])->name('project_phones.update')->middleware('permission:project_phones.edit');
        Route::get('project_phones/{id}/edit', [App\Http\Controllers\Admin\ProjectPhoneController::class, 'edit'])->name('project_phones.edit')->middleware('permission:project_phones.edit');


        Route::get('share_links/select', [App\Http\Controllers\Admin\ShareLinkController::class, 'select'])->name('share_links.select');
        Route::delete('share_links/bulk', [App\Http\Controllers\Admin\ShareLinkController::class, 'deleteBulk'])->name('share_links.deleteBulk');
        Route::get('share_links/list', [App\Http\Controllers\Admin\ShareLinkController::class, 'list'])->name('share_links.list')->middleware('permission:share_links.view');
        Route::post('share_links', [App\Http\Controllers\Admin\ShareLinkController::class, 'store'])->name('share_links.store')->middleware('permission:share_links.create');
        Route::delete('share_links/{id}', [App\Http\Controllers\Admin\ShareLinkController::class, 'destroy'])->name('share_links.destroy')->middleware('permission:share_links.delete');
        Route::get('share_links', [App\Http\Controllers\Admin\ShareLinkController::class, 'index'])->name('share_links.index')->middleware('permission:share_links.view');
        Route::get('share_links/create', [App\Http\Controllers\Admin\ShareLinkController::class, 'create'])->name('share_links.create')->middleware('permission:share_links.create');
        Route::match(['PUT', 'PATCH'], 'share_links/{id}', [App\Http\Controllers\Admin\ShareLinkController::class, 'update'])->name('share_links.update')->middleware('permission:share_links.edit');
        Route::get('share_links/{id}/edit', [App\Http\Controllers\Admin\ShareLinkController::class, 'edit'])->name('share_links.edit')->middleware('permission:share_links.edit');


        // Route::post('categories/savewhatsapp', [App\Http\Controllers\Admin\CategoryController::class, 'savewhatsapp'])->name('categories.savewhatsapp')->middleware('permission:categories.whatsapp');
        // Route::get('categories/whatsapp/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'whatsapp'])->name('categories.whatsapp')->middleware('permission:categories.whatsapp');
        // Route::post('categories/whatsapp/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'whatsapp'])->name('categories.whatsapp')->middleware('permission:categories.whatsapp');



        Route::get('paths/select', [App\Http\Controllers\Admin\PathController::class, 'select'])->name('paths.select');
        Route::delete('paths/bulk', [App\Http\Controllers\Admin\PathController::class, 'deleteBulk'])->name('paths.deleteBulk');
        Route::get('paths/list', [App\Http\Controllers\Admin\PathController::class, 'list'])->name('paths.list')->middleware('permission:paths.view');
        Route::post('paths', [App\Http\Controllers\Admin\PathController::class, 'store'])->name('paths.store')->middleware('permission:paths.create');
        Route::delete('paths/{id}', [App\Http\Controllers\Admin\PathController::class, 'destroy'])->name('paths.destroy')->middleware('permission:paths.delete');
        Route::get('paths', [App\Http\Controllers\Admin\PathController::class, 'index'])->name('paths.index')->middleware('permission:paths.view');
        Route::get('paths/create', [App\Http\Controllers\Admin\PathController::class, 'create'])->name('paths.create')->middleware('permission:paths.create');
        Route::match(['PUT', 'PATCH'], 'paths/{id}', [App\Http\Controllers\Admin\PathController::class, 'update'])->name('paths.update')->middleware('permission:paths.edit');
        Route::get('paths/{id}/edit', [App\Http\Controllers\Admin\PathController::class, 'edit'])->name('paths.edit')->middleware('permission:paths.edit');

        Route::get('initiatives/select', [App\Http\Controllers\Admin\InitiativeController::class, 'select'])->name('initiatives.select');
        Route::delete('initiatives/bulk', [App\Http\Controllers\Admin\InitiativeController::class, 'deleteBulk'])->name('initiatives.deleteBulk');
        Route::get('initiatives/list', [App\Http\Controllers\Admin\InitiativeController::class, 'list'])->name('initiatives.list')->middleware('permission:initiatives.view');
        Route::post('initiatives', [App\Http\Controllers\Admin\InitiativeController::class, 'store'])->name('initiatives.store')->middleware('permission:initiatives.create');
        Route::delete('initiatives/{id}', [App\Http\Controllers\Admin\InitiativeController::class, 'destroy'])->name('initiatives.destroy')->middleware('permission:initiatives.delete');
        Route::get('initiatives', [App\Http\Controllers\Admin\InitiativeController::class, 'index'])->name('initiatives.index')->middleware('permission:initiatives.view');
        Route::get('initiatives/create', [App\Http\Controllers\Admin\InitiativeController::class, 'create'])->name('initiatives.create')->middleware('permission:initiatives.create');
        Route::match(['PUT', 'PATCH'], 'initiatives/{id}', [App\Http\Controllers\Admin\InitiativeController::class, 'update'])->name('initiatives.update')->middleware('permission:initiatives.edit');
        Route::get('initiatives/{id}/edit', [App\Http\Controllers\Admin\InitiativeController::class, 'edit'])->name('initiatives.edit')->middleware('permission:initiatives.edit');

        Route::get('changeArchive', [App\Http\Controllers\Admin\ArchiveController::class, 'changeArchive'])->name('changeArchive');
        Route::get('archives/select', [App\Http\Controllers\Admin\ArchiveController::class, 'select'])->name('archives.select');
        Route::delete('archives/bulk', [App\Http\Controllers\Admin\ArchiveController::class, 'deleteBulk'])->name('archives.deleteBulk');
        Route::get('archives/list', [App\Http\Controllers\Admin\ArchiveController::class, 'list'])->name('archives.list')->middleware('permission:archives.view');
        Route::post('archives', [App\Http\Controllers\Admin\ArchiveController::class, 'store'])->name('archives.store')->middleware('permission:archives.create');
        Route::delete('archives/{id}', [App\Http\Controllers\Admin\ArchiveController::class, 'destroy'])->name('archives.destroy')->middleware('permission:archives.delete');
        Route::get('archives', [App\Http\Controllers\Admin\ArchiveController::class, 'index'])->name('archives.index')->middleware('permission:archives.view');
        Route::get('archives/create', [App\Http\Controllers\Admin\ArchiveController::class, 'create'])->name('archives.create')->middleware('permission:archives.create');
        Route::match(['PUT', 'PATCH'], 'archives/{id}', [App\Http\Controllers\Admin\ArchiveController::class, 'update'])->name('archives.update')->middleware('permission:archives.edit');
        Route::get('archives/{id}/edit', [App\Http\Controllers\Admin\ArchiveController::class, 'edit'])->name('archives.edit')->middleware('permission:archives.edit');
        Route::post('archives/active', [App\Http\Controllers\Admin\ArchiveController::class, 'active'])->name('archives.active')->middleware('permission:archives.edit');

        Route::get('target_types/select', [App\Http\Controllers\Admin\TargetTypeController::class, 'select'])->name('target_types.select');
        Route::delete('target_types/bulk', [App\Http\Controllers\Admin\TargetTypeController::class, 'deleteBulk'])->name('target_types.deleteBulk');
        Route::get('target_types/list', [App\Http\Controllers\Admin\TargetTypeController::class, 'list'])->name('target_types.list')->middleware('permission:target_types.view');
        Route::post('target_types', [App\Http\Controllers\Admin\TargetTypeController::class, 'store'])->name('target_types.store')->middleware('permission:target_types.create');
        Route::delete('target_types/{id}', [App\Http\Controllers\Admin\TargetTypeController::class, 'destroy'])->name('target_types.destroy')->middleware('permission:target_types.delete');
        Route::get('target_types', [App\Http\Controllers\Admin\TargetTypeController::class, 'index'])->name('target_types.index')->middleware('permission:target_types.view');
        Route::get('target_types/create', [App\Http\Controllers\Admin\TargetTypeController::class, 'create'])->name('target_types.create')->middleware('permission:target_types.create');
        Route::match(['PUT', 'PATCH'], 'target_types/{id}', [App\Http\Controllers\Admin\TargetTypeController::class, 'update'])->name('target_types.update')->middleware('permission:target_types.edit');
        Route::get('target_types/{id}/edit', [App\Http\Controllers\Admin\TargetTypeController::class, 'edit'])->name('target_types.edit')->middleware('permission:target_types.edit');

        Route::get('roles/select', [App\Http\Controllers\Admin\RoleController::class, 'select'])->name('roles.select');
        Route::get('roles/list', [App\Http\Controllers\Admin\RoleController::class, 'list'])->name('roles.list')->middleware('permission:roles.view');
        Route::post('roles', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.create');
        Route::delete('roles/{id}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:roles.delete');
        Route::get('roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index')->middleware('permission:roles.view');
        Route::get('roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->middleware('permission:roles.create');
        Route::match(['PUT', 'PATCH'], 'roles/{id}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.edit');
        Route::get('roles/{id}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:roles.edit');


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




        Route::get('update-users-links', [App\Http\Controllers\Admin\SettingController::class, 'userLinks'])->name('userLinks')->middleware('permission:settings.userLinks');
        Route::get('general-settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings')->middleware('permission:settings.view');
        Route::get('update-projects-links', [App\Http\Controllers\Admin\SettingController::class, 'projectLinks'])->name('projectLinks')->middleware('permission:settings.projectLinks');
        Route::get('update-categories-links', [App\Http\Controllers\Admin\SettingController::class, 'categoryLinks'])->name('categoryLinks')->middleware('permission:settings.categoryLinks');


        Route::get('compleate-project', [App\Http\Controllers\Admin\SettingController::class, 'whatsImageCompleate'])->name('whatsImageCompleate')->middleware('permission:settings.reminder');

        Route::get('reminder', [App\Http\Controllers\Admin\SettingController::class, 'reminders'])->name('reminder')->middleware('permission:settings.reminder');

        Route::get('whatsmessage', [App\Http\Controllers\Admin\SettingController::class, 'whats'])->name('testwhats')->middleware('permission:settings.testwhats');

        Route::get('whatsImage', [App\Http\Controllers\Admin\SettingController::class, 'whatsImage'])->name('whatsImage')->middleware('permission:settings.testwhats');

        Route::get('project-report', [App\Http\Controllers\Admin\ReportProjectController::class, 'index'])->name('project_report')->middleware('permission:project_report.view');

        Route::get('commplete_project_category', [App\Http\Controllers\Admin\ReportProjectController::class, 'commplete_project_category'])->name('commplete_project_category');

        Route::get('listCompleteCategory', [App\Http\Controllers\Admin\ReportProjectController::class, 'listCompleteCategory'])->name('listCompleteCategory');


        ///////////////////////////////////

        Route::get('CompleteCategoryProjectIndex/{id}', [App\Http\Controllers\Admin\ReportProjectController::class, 'CompleteCategoryProjectIndex'])->name('CompleteCategoryProjectIndex');

        Route::get('UnCompleteCategoryProjectIndex/{id}', [App\Http\Controllers\Admin\ReportProjectController::class, 'UnCompleteCategoryProjectIndex'])->name('UnCompleteCategoryProjectIndex');

        //////////////////////////////

        Route::get('uncommplete_project_category', [App\Http\Controllers\Admin\ReportProjectController::class, 'uncommplete_project_category'])->name('uncommplete_project_category');

        Route::get('listUnCompleteCategory', [App\Http\Controllers\Admin\ReportProjectController::class, 'listUnCompleteCategory'])->name('listUnCompleteCategory');

        /////////////////////////


        Route::get('uncommplete_project_button/{id}', [App\Http\Controllers\Admin\ReportProjectController::class, 'uncommplete_project_button'])->name('uncommplete_project_button');


        Route::get('updateProjectMessage', [App\Http\Controllers\Admin\AdminController::class, 'updateProjectMessage'])->name('updateProjectMessage')->middleware('permission:users.report');



        ///////////////    SendingTemplateController /////////////////////////////////
        Route::get('sending_templates/select', [App\Http\Controllers\Admin\SendingTemplateController::class, 'select'])->name('sending_templates.select');
        Route::delete('sending_templates/bulk', [App\Http\Controllers\Admin\SendingTemplateController::class, 'deleteBulk'])->name('sending_templates.deleteBulk');
        Route::get('sending_templates/list', [App\Http\Controllers\Admin\SendingTemplateController::class, 'list'])->name('sending_templates.list')->middleware('permission:sending_templates.view');
        Route::post('sending_templates', [App\Http\Controllers\Admin\SendingTemplateController::class, 'store'])->name('sending_templates.store')->middleware('permission:sending_templates.create');
        Route::delete('sending_templates/{id}', [App\Http\Controllers\Admin\SendingTemplateController::class, 'destroy'])->name('sending_templates.destroy')->middleware('permission:sending_templates.delete');
        Route::get('sending_templates', [App\Http\Controllers\Admin\SendingTemplateController::class, 'index'])->name('sending_templates.index')->middleware('permission:sending_templates.view');
        Route::get('sending_templates/create', [App\Http\Controllers\Admin\SendingTemplateController::class, 'create'])->name('sending_templates.create')->middleware('permission:sending_templates.create');
        Route::match(['PUT', 'PATCH'], 'sending_templates/{id}', [App\Http\Controllers\Admin\SendingTemplateController::class, 'update'])->name('sending_templates.update')->middleware('permission:sending_templates.edit');
        Route::get('sending_templates/{id}/edit', [App\Http\Controllers\Admin\SendingTemplateController::class, 'edit'])->name('sending_templates.edit')->middleware('permission:sending_templates.edit');
        /////////////////////////////////////////////////////////////

    });
});
