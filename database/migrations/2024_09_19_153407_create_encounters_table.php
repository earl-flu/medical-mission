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
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_opto')->default(0);
            $table->foreignId('diagnosis_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('patient_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('age');
            $table->boolean('is_pregnant')->default(0);
            $table->dateTime('encounter_date');
            $table->foreignId('event_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('encoded_by');
            $table->foreign('encoded_by')->references('id')->on('users');

            //Vital signs
            $table->smallInteger('bp_systolic')->nullable();
            $table->smallInteger('bp_diastolic')->nullable();
            $table->float('temperature', 5, 2)->nullable();
            $table->tinyInteger('pulse_rate')->nullable();
            $table->tinyInteger('respiratory_rate')->nullable();
            $table->tinyInteger('oxygen_saturation')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
