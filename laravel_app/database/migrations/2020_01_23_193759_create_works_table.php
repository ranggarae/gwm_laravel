<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('slug');
            $table->string('categories_id');
            $table->longText('description');
            $table->text('meta_tags');
            $table->text('meta_description');
            $table->string('start_date')->nullable();
            $table->string('image')->nullable();
            $table->string('gallery')->nullable();
            $table->string('end_date')->nullable();
            $table->text('location')->nullable();
            $table->string('clients')->nullable();
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
        Schema::dropIfExists('works');
    }
}
