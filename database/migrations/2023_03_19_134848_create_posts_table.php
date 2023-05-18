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
            $table->text('title');
            $table->text('thumb')->nullable();
            $table->string('is_embed', 1)->default('N'); //IS VIDEO || AUDIO
            $table->text('link_embed')->nullable(); //Link or Embed VIDEO || AUDIO
            $table->text('content')->nullable();
            $table->text('keyword')->nullable();
            $table->text('slug')->nullable();
            $table->string('post_format')->default('DEFAULT'); //DEFAULT || VIDEO || GALLERY || AUDIO
            $table->integer('fid_category')->nullable();
            $table->integer('views')->default(0);
            $table->string('is_public', 1)->default('Y');
            $table->string('is_trash', 1)->default('N');
            $table->integer('user_add');
            $table->integer('user_updated')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('NULL on update CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
