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
        Schema::create('property_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_investment_campaign_id')->constrained();
            $table->foreignId('property_id')->constrained();
            $table->integer('shares');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_investments');
    }
};
