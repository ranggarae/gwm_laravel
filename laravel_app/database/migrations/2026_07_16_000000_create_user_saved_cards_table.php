<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSavedCardsTable extends Migration
{
    public function up()
    {
        Schema::create('user_saved_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('card_token');
            $table->string('masked_card');
            $table->string('card_type')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_saved_cards');
    }
}
