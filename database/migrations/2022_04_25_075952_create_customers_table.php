<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CUSTOMERNAME')->unique();
            $table->string('CUSTOMERCODE')->unique();
            $table->string('CONTACTPERSONNAME');
            $table->string('MOBILENO');
            $table->string('EMAILID');
            $table->string('ADDRESS');
            $table->string('CITY');
            $table->string('COUNTRY');
            $table->string('CUSTOMERGROUP');
            $table->string('COMPANYNAME');
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
        Schema::dropIfExists('customers');
    }
}
