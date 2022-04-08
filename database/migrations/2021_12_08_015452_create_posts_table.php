<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->unique();
            $table->text('description');
            $table->text('content');
            $table->text('image')->nullable();
            $table->bigInteger('user_id')
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->bigInteger('category_id')
                ->foreign('category_id')
                ->references('id')
                ->on('categories');
            $table->string('slug', 255)
                ->unique();
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
        Schema::dropIfExists('post');
    }
}
