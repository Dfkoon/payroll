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
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
            $table->string('location_en')->nullable()->after('location');
            $table->json('itinerary_en')->nullable()->after('itinerary');
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->text('description_en')->nullable()->after('description');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en', 'location_en', 'itinerary_en']);
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'description_en']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_en']);
        });
    }
};
