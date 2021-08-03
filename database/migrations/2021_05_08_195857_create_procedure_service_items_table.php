<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedureServiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_procedure_service_items', function (Blueprint $table) {
            $table->id();            
            $table->double('quantity',8,2)->default(1);
            $table->double('rate',8,2);//taux
            $table->double('total',8,2);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('teeth_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->enum('type', ['existing', 'planned','completed'])->default('existing');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('service_id')->references('id')->on('services');
            $table->unsignedBigInteger('invoice_id')->nullable();
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
        Schema::dropIfExists('pr_procedure_service_items');
    }
}
