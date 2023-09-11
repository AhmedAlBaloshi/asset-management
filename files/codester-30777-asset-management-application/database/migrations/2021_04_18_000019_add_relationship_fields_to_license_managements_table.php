<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLicenseManagementsTable extends Migration
{
    public function up()
    {
        Schema::table('license_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id', 'team_fk_3690686')->references('id')->on('teams');
        });
    }
}
