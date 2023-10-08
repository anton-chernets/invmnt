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
        Schema::create('currency_currency', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('base_currency_id');
            $table->unsignedBigInteger('rate_currency_id');

            $table->foreign('base_currency_id')
                ->references('id')
                ->on('currencies');

            $table->foreign('rate_currency_id')
                ->references('id')
                ->on('currencies');

            $table->float('rate_value', 128, 12, true)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_currency');
    }
};
