<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicRelatedlinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_relatedlinks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 225);
            $table->text('link_url')->nullable();
            $table->text('img_file')->nullable(); // => If link for bodyLinkSection
            $table->string('link_target', 50)->default('_blank');
            $table->string('section_position', 50)->default('footerLinkSection'); // => footerLinkSection = For footer link || bodyLinkSection = For Body Link with Image
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
        Schema::dropIfExists('public_relatedlinks');
    }
}
