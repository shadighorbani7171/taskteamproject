<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnerIdToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->after('id')->nullable();

            
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            
            $table->dropColumn('owner_id');
        });
    }
}
