<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
                ->cascadeOnDelete('cascade');
            $table->enum('status', ['In_Preparation', 'Has_Been_Sent', 'Received'])->default('In_Preparation');
            $table->enum('payment_status', ['paid', 'not_paid'])->default('not_paid');
            $table->double('order_price');
            $table->timestamps();
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
