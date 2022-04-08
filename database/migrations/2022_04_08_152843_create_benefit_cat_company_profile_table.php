<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitCatCompanyProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefit_cat_company_profile', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('company_profile_id')->index();

            $table->foreign('company_profile_id')->references('id')
                ->on('company_profiles')
                ->onDelete('cascade');

            $table->unsignedBigInteger('benefit_cat_id')->index();

            $table->foreign('benefit_cat_id')->references('id')
                ->on('benefit_cats')
                ->onDelete('cascade');    

            $table->timestamps();
        });

        //
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