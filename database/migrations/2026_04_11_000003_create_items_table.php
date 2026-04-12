<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->integer('quantity')->default(1);
            $table->date('acquisition_date')->nullable();
            $table->string('acquisition_source')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
