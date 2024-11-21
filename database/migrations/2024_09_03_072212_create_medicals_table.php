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
        Schema::table('medicals', function (Blueprint $table) {
    // Check if the foreign key does not already exist before adding it
    if (!Schema::hasColumn('medicals', 'livestock_id')) {
        $table->unsignedBigInteger('livestock_id');
    }

    // Drop the foreign key if it already exists
    $table->dropForeign(['livestock_id']);
    
    // Add the foreign key constraint
    $table->foreign('livestock_id')
          ->references('id')
          ->on('livestocks')
          ->onDelete('cascade');
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};
