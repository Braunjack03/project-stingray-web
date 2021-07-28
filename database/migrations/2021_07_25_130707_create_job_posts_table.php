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
            $table->integer('explevel')->default(1);
            $table->unsignedInteger('company_profile_id')->nullable();
            //$table->enum('remote_type', ['Remote', 'Hybrid', 'In Office', 'Not Specified'])->default('Not Specified');
            $table->integer('remotetype')->default(1);
            $table->boolean('featured')->default(false);
            $table->string('slug', 512)->nullable();
            $table->dateTime('posted_at')->nullable();
            $table->boolean('is_published')->default(false);
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
