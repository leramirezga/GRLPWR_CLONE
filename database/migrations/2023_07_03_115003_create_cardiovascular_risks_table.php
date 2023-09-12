<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardiovascular_risks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');//foreign. Is necessary the unsigned to match with the other table
            $table->enum('risk', ['low', 'medium', 'high']);
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
        Schema::dropIfExists('cardiovascular_risks');
    }
};
