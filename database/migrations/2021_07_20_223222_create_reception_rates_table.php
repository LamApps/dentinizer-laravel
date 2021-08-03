<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reception_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reception_id')->nullable(false);
            $table->unsignedInteger('count_monthly')->nullable(false);
            $table->float('rate',8,2)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reception_rates');
    }
}
