<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_prizes', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->foreignId('user_id')->nullable()->constrained();
            $table->float("money_amount");
            $table->foreignId('prize_item_id')->nullable()->constrained();
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
        Schema::dropIfExists('users_prizes');
    }
}
