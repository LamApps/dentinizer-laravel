<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToothsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_tooths', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->integer('sort')->default(1);
            $table->text('image')->nullable();
            $table->enum('type', ['adult', 'child'])->default('adult');
            $table->integer('row_number')->default(1);
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
        Schema::dropIfExists('pr_tooths');
    }
}
