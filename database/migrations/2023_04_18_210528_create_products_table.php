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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->enum('type', ['command', 'item']);
            $table->string('command')->nullable();
            $table->string('item')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('price');
            $table->integer('amount')->nullable()->default(1);
            // TODO: Зробити можливість заблокувати товар для продажи після купівлі. Типи: після встановленого часу, після отримання в грі, ніколи.
            //      $table->enum('locked', ['time', 'obtaining', 'forever', 'pick_up'])->nullable;
            //      $table->timestamp('lock_time')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
