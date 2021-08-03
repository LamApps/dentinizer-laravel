<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_request_items', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->double('quantity',8,2)->default(1);
            $table->double('rate',8,2);//taux
            $table->double('total',8,2);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('sp_products');
            $table->unsignedBigInteger('request_id');
            $table->foreign('request_id')->references('id')->on('sp_requests');
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
        Schema::dropIfExists('sp_request_items');
    }
}
