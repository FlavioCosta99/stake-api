<?php

use App\Enums\DistributionStatus;
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
        Schema::create('dividend_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_investment_id')->constrained();
            $table->string('status')->default(DistributionStatus::PENDING);
            $table->decimal('amount', 18, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividend_distributions');
    }
};
