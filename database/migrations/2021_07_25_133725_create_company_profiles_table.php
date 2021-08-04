<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profiles', function (Blueprint $table) {

            // Basic info
            $table->id();
            $table->timestamps();
            $table->longText('description');
            $table->string('profile_title');
            $table->string('name', 256);
            $table->string('header_image_url')->nullable();
            $table->string('logo_image_url')->nullable();
            $table->integer('local_employees')->nullable();
            $table->integer('global_employees')->nullable();
            $table->integer('year_founded')->nullable();
            $table->string('website_url', 1024)->nullable();
            $table->text('mission')->nullable();
            $table->string('slug', 256)->nullable();

            // Link to social
            $table->string('twitter_user', 256)->nullable();
            $table->string('linkedin_user', 256)->nullable();
            $table->string('facebook_user', 256)->nullable();
            $table->string('instagram_user', 256)->nullable();

            // Location info
            $table->unsignedBigInteger('location_id')->default(1);
            $table->foreign('location_id')->references('id')->on('locations');

            $table->string('street_addr_1', 1024)->nullable();
            $table->string('street_addr_2', 1024)->nullable();
            $table->string('city', 64)->nullable();
            $table->string('state_abbr', 16)->nullable();
            $table->string('postcode', 16)->nullable();
            $table->string('email_contact', 128)->nullable();
            $table->string('phone_contact', 128)->nullable();

            // Platform
            $table->boolean('featured')->default(false);
            $table->boolean('unclaimed')->default(true);
            $table->string('lat');
            $table->string('long');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_profiles');
    }
}
