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
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn(['beggining_date', 'end_date']);
        
            $table->timestamp('start_at')->after('recinto_id');
            $table->timestamp('end_at')->after('start_at');
        
            $table->enum('status', ['activa', 'cancelada'])->default('activa')->after('price');
            $table->boolean('paid')->default(false)->after('status');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'end_at', 'status', 'paid']);
    
            $table->date('beggining_date')->after('price');
            $table->date('end_date')->after('beggining_date');
        });
    }
};
