<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('national_id');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->string('job')->nullable();
            $table->string('job_place')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('role_id')->default(1);
            $table->tinyInteger('status')->default(1); // قيد العمل -منقطغ -- 0- 1 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('reset_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('mid_name')->nullable();
            $table->string('last_name')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
