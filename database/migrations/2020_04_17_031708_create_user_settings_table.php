<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
       

        Schema::create('user_settings', function (Blueprint $table) {
            
            $table->id();
            $table->text('descripcion_ml');
            $table->text('envio_tipo');
            $table->text('envio_descripcion');
            $table->integer('envio_valor')->default()->nullable();
            $table->text('publicacion_tipo');
            $table->boolean('marcas_vetadas_activar');
            $table->boolean('stock_activar');
            $table->integer('stock_dias');
            $table->text('imagenes');
            $table->text('marcas_vetadas_lista');
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
}
