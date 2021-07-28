<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('author_id')->default(0);
            $table->string('title', 1024);
            $table->string('sub_title', 1024)->nullable();
            $table->string('slug', 512)->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->boolean('is_published')->default(false);
            $table->longText('content');
            $table->text('description')->nullable();
            $table->string('header_image', 512)->nullable();
            $table->string('content_type', 128)->default('news');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
