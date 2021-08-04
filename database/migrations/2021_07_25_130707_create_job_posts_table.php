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
            $table->unsignedInteger('company_profile_id')->nullable();

            // Link where job seeker goes to apply
            $table->string('apply_url', 2048)->nullable();

            // Experience level defined in the model
            $table->integer('explevel_id')->default(1);

            // remotetype defined in the model
            $table->integer('remotetype_id')->default(1);
            $table->string('slug', 512)->nullable();
            $table->dateTime('posted_at')->nullable();
            $table->boolean('featured')->default(false);
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
