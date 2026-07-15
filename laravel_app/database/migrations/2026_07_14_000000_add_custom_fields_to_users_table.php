<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_type')->default('perorangan')->nullable();
            $table->string('nik')->nullable();
            $table->string('ktp_image')->nullable();
            $table->string('selfie_image')->nullable();
            $table->string('sim_image')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_npwp')->nullable();
            $table->string('company_nib')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'account_type',
                'nik',
                'ktp_image',
                'selfie_image',
                'sim_image',
                'company_name',
                'company_npwp',
                'company_nib'
            ]);
        });
    }
}
