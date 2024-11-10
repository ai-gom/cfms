<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            // Make the service_id column non-nullable
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
    }
};
