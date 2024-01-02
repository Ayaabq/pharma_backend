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
            $table->foreignId('category_id')->constrained('categories')
            ->cascadeOnDelete('cascade');
          //  $table->enum()
            $table->string('scientific_name');
            $table->string('commercial_name');
            $table->string('company');
            $table->integer('quantity_available');
            $table->date('createdat');
            $table->double('cost');
$table->softDeletes();
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
