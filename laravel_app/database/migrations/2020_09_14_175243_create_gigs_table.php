<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigs', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug')->nullable();
            $table->string('lang')->nullable();
            $table->string('status')->nullable();
            $table->string('image')->nullable();
            $table->string('gallery')->nullable();
            $table->longText('description')->nullable();
            $table->longText('faqs_title')->nullable();
            $table->longText('faqs_description')->nullable();
            $table->longText('plan_title')->nullable();
            $table->longText('plan_price')->nullable();
            $table->longText('plan_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('category_id',false,true)->nullable();
            $table->longText('delivery_time')->nullable();
            $table->longText('revisions')->nullable();
            $table->longText('features')->nullable();
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
        Schema::dropIfExists('gigs');
    }
}
