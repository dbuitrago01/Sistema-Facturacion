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
        Schema::create('stock_movimientos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
        $table->enum('tipo', ['entrada','salida','adicion']);
        $table->integer('cantidad');
        $table->integer('stock_anterior');
        $table->integer('stock_actual');
        $table->string('motivo')->nullable();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movimientos');
    }
};
