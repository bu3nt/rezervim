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
        Schema::create('apriori_sample_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->unsignedBigInteger('apriori_samples_id');
            $table->timestamps();

            $table->foreign('apriori_samples_id')
                ->references('id')
                ->on('apriori_samples')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apriori_sample_items');
    }
};
