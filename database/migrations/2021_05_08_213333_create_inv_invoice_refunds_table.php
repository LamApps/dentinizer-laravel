<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvoiceRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_invoice_refunds', function (Blueprint $table) {
            $table->id();
            //refund_code
            $table->string('refund_code',45);
            //amount
            $table->double('amount',8,2);		
            //reason
            $table->text('reason')->nullable();
            //refund_date
            $table->date('refund_date')->nullable();			
            //invoice_id
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('inv_invoices');
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
        Schema::dropIfExists('inv_invoice_refunds');
    }
}
