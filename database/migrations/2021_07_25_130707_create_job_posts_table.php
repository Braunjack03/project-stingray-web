<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name');
            $table->longText('content');
            $table->string('apply_url', 2048)->nullable();
            $table->enum('experience_level', ['Entry Level','Mid Level', 'Senior Level', 'Not Specified'])->default('Not Specified');
            $table->unsignedInteger('company_profile_id')->nullable();
            $table->enum('remote_type', ['Remote', 'Hybrid', 'In Office', 'Not Specified'])->default('Not Specified');
            $table->boolean('featured')->default(false);
            $table->dateTime('posted_at')->nullable();
            $table->string('url_slug', 512)->nullable();
            $table->uuid('uuid')->unique();
            //$table->technologies;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
}
