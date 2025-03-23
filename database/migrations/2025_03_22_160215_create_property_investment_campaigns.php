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
        Schema::create('property_investment_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained();
            $table->string('image_url')->nullable();
            $table->string('name');
            $table->decimal('target_amount', 18, 2);
            $table->decimal('value_per_share', 18, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_investment_campaigns');
    }
};
