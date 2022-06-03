<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('InvoiceNo')->unique();
            $table->string('InvoiceDate');
            $table->string('CustomerName');
            $table->string('CustomerCode');
            $table->string('ItemName');
            $table->integer('ItemPrice');
            $table->integer('ItemQty');
            $table->bigInteger('TotalAmount');
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
        Schema::dropIfExists('invoices');
    }
}
