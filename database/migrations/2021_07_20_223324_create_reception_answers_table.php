<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reception_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reception_id')->nullable(false);
            $table->unsignedInteger('patient_id')->nullable(false);
            $table->tinyInteger('answer')->unsigned()->default(0);
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
        Schema::dropIfExists('reception_answers');
    }
}
