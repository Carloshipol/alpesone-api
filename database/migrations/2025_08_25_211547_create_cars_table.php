<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->unique(); // id da API
            $table->string('type')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('version')->nullable();
            $table->string('year_model')->nullable();
            $table->string('year_build')->nullable();
            $table->json('optionals')->nullable();
            $table->string('doors')->nullable();
            $table->string('board')->nullable();
            $table->string('chassi')->nullable();
            $table->string('transmission')->nullable();
            $table->string('km')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('created_api')->nullable();
            $table->timestamp('updated_api')->nullable();
            $table->boolean('sold')->default(false);
            $table->string('category')->nullable();
            $table->string('url_car')->nullable();
            $table->decimal('old_price', 12, 2)->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('fuel')->nullable();
            $table->json('fotos')->nullable(); 
            $table->timestamps(); // <- adiciona created_at e updated_at automáticos

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};