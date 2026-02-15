<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->enum('tipo', ['servicio', 'producto']);
        $table->decimal('precio', 10, 2);
        $table->unsignedInteger('stock')->nullable();
        $table->boolean('activo')->default(true);
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
