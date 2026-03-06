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
        Schema::table('tours', function (Blueprint $table) {
            $table->foreignId('destination_id')->nullable()->constrained()->onDelete('set null')->after('category_id');
            $table->decimal('rating_avg', 3, 2)->default(0)->after('price');
            $table->integer('review_count')->default(0)->after('rating_avg');
            $table->decimal('map_lat', 10, 8)->nullable()->after('location');
            $table->decimal('map_lng', 11, 8)->nullable()->after('map_lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
            $table->dropColumn(['destination_id', 'rating_avg', 'review_count', 'map_lat', 'map_lng']);
        });
    }
};
