<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfileGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profile_gallery', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_profile_id')->index();
            $table->foreign('company_profile_id')->references('id')
                ->on('company_profiles')
                ->onDelete('cascade');
            $table->string('image')->nullable();    
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
        Schema::dropIfExists('company_profile_gallery');
    }
}
