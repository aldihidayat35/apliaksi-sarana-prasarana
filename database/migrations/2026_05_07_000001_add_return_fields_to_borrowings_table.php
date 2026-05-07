<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->enum('return_condition', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->nullable()->after('actual_return_date');
            $table->text('return_notes')->nullable()->after('return_condition');
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn(['return_condition', 'return_notes']);
        });
    }
};
