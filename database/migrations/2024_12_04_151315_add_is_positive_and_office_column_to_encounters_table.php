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
        Schema::table('encounters', function (Blueprint $table) {
            $table->boolean('is_positive')->nullable()->after('oxygen_saturation');
            $table->unsignedBigInteger('office_id')->nullable()->after('is_positive');
            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encounters', function (Blueprint $table) {
            $table->dropForeign('encounters_office_id_foreign');
            $table->dropColumn('office_id');
            $table->dropColumn('is_positive');
        });
    }
};
