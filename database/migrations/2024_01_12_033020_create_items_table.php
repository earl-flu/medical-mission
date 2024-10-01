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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('quantity');
            $table->string('lot_no')->nullable();
            $table->boolean('status')->default(1);
            $table->date('expiration_date')->nullable();
            $table->integer('restock_threshold')->default(10);
            $table->foreignId('program_id')->constrained('programs')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
