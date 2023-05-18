<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_info', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name');
            $table->string('description');
            $table->text('keyword');
            // $table->text('thumb');
            $table->text('login_bg');
            $table->text('login_logo');
            $table->text('frontend_logo');
            $table->text('backend_logo');
            $table->text('backend_logo_icon');
            $table->text('copyright');
            $table->integer('user_updated')->nullable();
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
        Schema::dropIfExists('site_info');
    }
}
