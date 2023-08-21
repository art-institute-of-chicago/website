<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->integer('geotarget')->nullable()->index()->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->dropColumn('geotarget');
        });
    }
};
