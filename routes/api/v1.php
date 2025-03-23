<?php

use Illuminate\Support\Facades\Route;

Route::name('api.v1.')->group(function () {
    Route::prefix('properties/{property}')->name('properties.property.')->group(function () {
        Route::get('/campaigns', [App\Http\Controllers\PropertyInvestmentCampaignController::class, 'index'])->name('campaigns');
        Route::post('/campaigns/{propertyInvestmentCampaign}/invest', [App\Http\Controllers\PropertyInvestmentCampaignController::class, 'store'])->name('campaigns.invest');
    });
});
