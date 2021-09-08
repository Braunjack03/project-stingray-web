<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompanyTableAddColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->uuid('uuid')->unique()->after('user_id');
            $table->String('industry_ids')->nullable()->after('mission');
            $table->longText('description')->nullable()->change();
            $table->String('lat')->nullable()->change();
            $table->String('long')->nullable()->change();
            $table->String('profile_title')->nullable()->change();
            #$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
