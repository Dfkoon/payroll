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
            $table->string('location')->nullable()->after('title');
            $table->boolean('is_featured')->default(false)->after('price');
            $table->json('itinerary')->nullable()->after('description'); // Storing days/timeline as JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['location', 'is_featured', 'itinerary']);
        });
    }
};
