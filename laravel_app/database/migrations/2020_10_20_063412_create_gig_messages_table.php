<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_messages', function (Blueprint $table) {
            $table->id();
            $table->string('notify_mail')->nullable();
            $table->integer('user_id',false,true)->nullable();
            $table->integer('gig_order_id',false,true)->nullable();
            $table->string('user_type')->nullable();
            $table->longText('message')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('gig_messages');
    }
}
