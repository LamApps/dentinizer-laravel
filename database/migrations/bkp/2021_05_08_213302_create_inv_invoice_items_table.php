<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_invoice_items', function (Blueprint $table) {
            $table->id();
            //quantity
            $table->double('quantity',8,2)->default(1);	
            //rate
            $table->double('rate',8,2);//taux
            //total	
            $table->double('total',8,2);
            //sort
            $table->integer('sort');
            //procedure_service_item_id
            $table->unsignedBigInteger('procedure_service_item_id')->nullable();;	
            //invoice_id
            $table->unsignedBigInteger('invoice_id');

            $table->foreign('invoice_id')->references('id')->on('inv_invoices');
            $table->foreign('procedure_service_item_id')->references('id')->on('pr_procedure_service_items');
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
        Schema::dropIfExists('inv_invoice_items');
    }
}
