<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // Primary key (id INT UNSIGNED AUTO_INCREMENT)
            $table->string('name');                     // Nombre del curso
            $table->string('description')->nullable();  // Descripción
            $table->string('location')->nullable();     // Ubicación
            // Fechas de inicio y fin (tipo Date, según tu diagrama)
            $table->date('begining_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('price', 8, 2)->default(0);   // Precio (float con 2 decimales)
            // Aquí usamos enum para "state":
            $table->enum('state', ['Disponible', 'No disponible', 'Cancelado'])
                  ->default('Disponible');
            $table->integer('capacity')->default(0);    // Número de plazas
            $table->timestamps();                       // created_at y updated_at
            // Campo para la ruta/nombre de la imagen (opcional)
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
