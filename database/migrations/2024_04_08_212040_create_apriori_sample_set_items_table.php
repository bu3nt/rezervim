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
        Schema::create('apriori_sample_set_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apriori_sample_sets_id');
            $table->unsignedBigInteger('apriori_sample_items_id');
            $table->timestamps();

            $table->foreign('apriori_sample_sets_id')
                ->references('id')
                ->on('apriori_sample_sets')
                ->onDelete('cascade');

            $table->foreign('apriori_sample_items_id')
                ->references('id')
                ->on('apriori_sample_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apriori_sample_set_items');
    }
};
