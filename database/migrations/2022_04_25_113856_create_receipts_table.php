<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ReceiptNumber');
            $table->date('ReceiptDate');
            $table->time('ReceiptTime');
            $table->string('PartyName');
            $table->string('BillNumber');
            $table->bigInteger('BillAmount');
            $table->string('DayRate');
            $table->bigInteger('AmountPaidInFC');
            $table->integer('AmountPaidInDollar');
            $table->bigInteger('TotalAmount');
            $table->string('UserID');
            $table->string('CompanyName');
            $table->string('CmpGuid');
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
        Schema::dropIfExists('receipts');
    }
}
