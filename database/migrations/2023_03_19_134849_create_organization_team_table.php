<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_team', function (Blueprint $table) {
            $table->id();
            $table->string('name', 225);
            $table->string('gender', 255);
            $table->string('rank_grade', 255)->nullable();
            $table->string('position', 255);
            $table->string('employment_status')->default('ASN'); //ASN || P3K || PPNPN
            $table->text('awards')->nullable(); //Penghargaan
            $table->text('thumb')->nullable(); //thumbnail team
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
        Schema::dropIfExists('organization_team');
    }
}
