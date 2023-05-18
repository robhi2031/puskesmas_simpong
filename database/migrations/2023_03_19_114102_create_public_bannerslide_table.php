<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicBannerslideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_bannerslide', function (Blueprint $table) {
            $table->id();
            $table->text('file_name');
            $table->string('section_position', 50)->default('headSectionSlide');
            $table->string('is_link')->default('N');
            $table->text('link_url')->default('https://');
            $table->string('link_target')->nullable();
            $table->string('is_caption')->default('N');
            $table->string('caption', 225)->nullable();
            $table->string('is_social_media')->default('N');
            $table->string('is_public', 1)->default('Y');
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
        Schema::dropIfExists('public_bannerslide');
    }
}