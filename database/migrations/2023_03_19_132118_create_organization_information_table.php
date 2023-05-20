<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_information', function (Blueprint $table) {
            $table->id();
            $table->string('name', 225);
            $table->string('short_description', 225);
            $table->text('logo')->nullable();
            $table->text('profile')->nullable();
            $table->text('vision_mission')->nullable();
            $table->string('text_header_welcome', 225)->nullable();
            $table->text('text_welcome')->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('email')->nullable();
            $table->string('office_address')->nullable();
            $table->text('office_address_coordinate')->nullable();
            $table->text('organization_structure')->nullable();
            $table->text('facebook_account')->nullable();
            $table->text('instagram_account')->nullable();
            $table->text('twitter_account')->nullable();
            $table->text('youtube_channel')->nullable();
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
        Schema::dropIfExists('organization_information');
    }
}
