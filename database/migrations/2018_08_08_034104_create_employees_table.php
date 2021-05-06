<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('department_id')->unsigned();
            $table->string('employee_id',11);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('middle_name',50);
            $table->string('address',100); 
            $table->string('city',20);
            $table->string('state',20);
            $table->string('zip_code',20);
            $table->string('gender',10);
            $table->string('birthday');
            $table->string('email_address',100)->unique();
            $table->string('mobile',20);
            $table->string('telephone',20);
            $table->string('marital_status',20);
            $table->string('designation',20);
            $table->integer('campus_id')->unsigned();
            $table->string('employment_type',20);
            $table->double('salary',8,2);
            $table->string('date_joining');
            $table->string('resume',100);
            $table->string('status',55);
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('campus_id')->references('id')->on('campuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
