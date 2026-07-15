<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_orders', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->text('additional_note')->nullable();
            $table->string('selected_payment_gateway')->nullable();
            $table->string('file')->nullable();
            $table->integer('gig_id',false,true)->nullable();
            $table->integer('user_id',false,true)->nullable();
            $table->integer('selected_plan_index',false,true)->nullable();
            $table->integer('selected_plan_revisions',false,true)->nullable();
            $table->integer('selected_plan_delivery_days',false,true)->nullable();
            $table->decimal('selected_plan_price')->nullable();
            $table->string('selected_plan_title')->nullable();
            $table->string('payment_track')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('order_status')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('seen')->nullable();
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
        Schema::dropIfExists('gig_orders');
    }
}
