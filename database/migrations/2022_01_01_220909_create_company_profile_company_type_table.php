<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfileCompanyTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profile_company_type', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_profile_id')->index();
            $table->foreign('company_profile_id')->references('id')
                ->on('company_profiles')
                ->onDelete('cascade');

            $table->unsignedBigInteger('company_type_id')->index();
            $table->foreign('company_type_id')->references('id')
                ->on('company_types')
                ->onDelete('cascade');
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
        Schema::dropIfExists('company_profile_company_type');
    }
}
