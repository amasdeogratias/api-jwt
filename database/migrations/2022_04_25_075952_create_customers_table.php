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
            $table->string('CustomerName');
            $table->string('CustomerCode');
            $table->string('ContactPersonName');
            $table->string('MobileNo');
            $table->string('EmailId');
            $table->string('Address');
            $table->string('City');
            $table->string('Country');
            $table->string('CustomerGroup');
            $table->string('CompanyName');
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
