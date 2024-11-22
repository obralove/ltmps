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
        //
        Schema::table('vaccinations', function(Blueprint $table) {
            if(!Schema::hasColumn('vaccinations', 'veterinarian')){
                $table->string('veterinarian');
            }
         });

        Schema::table('medicals', function(Blueprint $table) {
            if(!Schema::hasColumn('medicals', 'veterinarian')){
                $table->string('veterinarian');
            }
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
