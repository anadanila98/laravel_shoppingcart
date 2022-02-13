<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('user_id'); //fortam utilizatorul sa se logheze pt a cumpara
            $table->text('cart'); //serializam obiectul cart (folosind o functie php) care contine mai multe campuri si il deserializam dupa aceea cand mai avem nevoie de el, in felul asta nu trebuie sa creez o gramada de tabele
            $table->text('address');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
