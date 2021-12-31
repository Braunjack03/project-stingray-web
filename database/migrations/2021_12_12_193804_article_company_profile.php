<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArticleCompanyProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_company_profile', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('article_id')->index();
            $table->foreign('article_id')->references('id')
                ->on('articles')
                ->onDelete('cascade');

            $table->unsignedBigInteger('company_profile_id')->index();
            $table->foreign('company_profile_id')->references('id')
                ->on('company_profiles')
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
