<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->enum('semester', ['1st', '2nd'])->nullable();
            $table->string('academic_year')->nullable();
            $table->string('department')->nullable();
            $table->string('service')->nullable();
              // Add the service_id column first
        $table->unsignedBigInteger('service_id')->nullable(); // Ensure this is added first

        // Now, define the foreign key
        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->integer('age')->nullable();
            $table->enum('sex', ['male', 'female', 'prefer-not-to-say']);
            $table->enum('Municipality', ['Agno', 'Aguilar', 'Alaminos', 'Alcala,', 'Anda', 'Bani', 'Binmaley', 'Bolinao', 'Burgos', 'Dagupan', 'Dasol', 'Infanta', 'Lingayen', 'Mabini', 'Mangaldan', 'Mangatarem', 'Rosales', 'Sta. Barbara', 'Sta. maria', 'Sual', 'Others' ]);
            $table->enum('client_category', ['Student', 'faculty', 'Non-teaching staff', 'Alumni', 'parents', 'supplier', 'Community_member', 'industry_partner', 'Regulatory', 'Others']);
            $table->enum('cc1', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('cc2', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('cc3', ['1', '2', '3', '4'])->nullable();
            $table->enum('expectations_0', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_1', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_2', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_3', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_4', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_5', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_6', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_7', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->enum('expectations_8', ['strongly-disagree', 'disagree', 'neither', 'agree', 'strongly-agree', 'na'])->nullable();
            $table->text('suggestions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
