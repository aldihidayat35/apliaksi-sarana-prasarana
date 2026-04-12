<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('condition_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->enum('condition_before', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang']);
            $table->enum('condition_after', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang']);
            $table->text('description');
            $table->string('photo')->nullable();
            $table->date('report_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condition_reports');
    }
};
