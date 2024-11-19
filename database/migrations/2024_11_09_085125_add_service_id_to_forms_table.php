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
            // Check if the column already exists
            if (!Schema::hasColumn('forms', 'service_id')) {
                $table->unsignedBigInteger('service_id');
                $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            if (Schema::hasColumn('forms', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }
        });
    }
};
