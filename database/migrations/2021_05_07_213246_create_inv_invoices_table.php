<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_invoices', function (Blueprint $table) {
            $table->id();
            //number
            $table->string('number',45);
            //doctor_id
            $table->unsignedBigInteger('doctor_id');
            //patient_id
            $table->unsignedBigInteger('patient_id');
            //bill_date
            $table->date('bill_date');
            //due_date
            $table->date('due_date');
            //note
            $table->text('note')->nullable();
            //tax_percentage
            $table->double('tax_percentage', 8, 2)->nullable();
            //discount_amount
            $table->double('discount_amount',8,2)->nullable();
            //discount_amount_type
            $table->enum('discount_amount_type', ['percentage', 'fixed_amount'])->nullable();
            //discount_type
            $table->enum('discount_type', ['before_tax', 'after_tax'])->default('before_tax');
            //status
            $table->enum('status', ['draft', 'not_paid','partial_paid','paid','cancelled'])->default('draft');//enum('draft', 'not_paid','partial_paid', 'paid','cancelled')
            //cancelled_at
            $table->timestamp('cancelled_at')->nullable();
            //cancelled_by
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients');
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
        Schema::dropIfExists('inv_invoices');
    }
}
