<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->nullable();
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('postal')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
