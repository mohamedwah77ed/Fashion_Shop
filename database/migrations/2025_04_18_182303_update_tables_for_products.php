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

        // تعديل جدول product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('color')->after('size_id'); // إضافة عمود color
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // التراجع عن تعديل جدول sizes
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });

        // التراجع عن تعديل جدول product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
