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
        $table->string('slug')->unique();
        $table->decimal('price', 8, 2);
        $table->integer('quantity')->default(0); // ថ្មី៖ ចំនួនស្តុកទំនិញ
        $table->text('description');
        $table->string('category');
        $table->string('image')->nullable(); // រូបភាពគោល
        $table->string('image_2')->nullable(); // ថ្មី៖ រូបភាពតូចទី ២
        $table->string('image_3')->nullable(); // ថ្មី៖ រូបភាពតូចទី ៣
        $table->boolean('is_featured')->default(false);
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