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
        Schema::table('recintos', function (Blueprint $table) {
            $table->dropColumn('state');

            $table->enum('state', ['Disponible', 'No disponible', 'Bloqueado'])
                ->default('Disponible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recintos', function (Blueprint $table) {
            $table->dropColumn(['state']);
            $table->boolean('state')->default(true);
        });
    }
};
