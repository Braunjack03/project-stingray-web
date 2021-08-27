<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobseekerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->String('profie_image')->nullable();
            $table->String('current_job_title')->nullable();
            $table->String('short_bio')->nullable();
            $table->String('linkedin')->nullable();
            $table->String('github')->nullable();
            $table->String('twitter')->nullable();
            $table->String('current_resume')->nullable();
            
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('jobseeker_profiles');
    }
}
