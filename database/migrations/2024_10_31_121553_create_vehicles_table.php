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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('model');
            $table->foreignId('location_id')->constrained();
            $table->boolean('is_company_owned')->default(true);
            $table->enum('status', ['available', 'in-use', 'maintenance', 'assigned'])->default('available');
            $table->enum('type', ['passenger', 'cargo']);
            $table->decimal('fuel_consumption', 8, 2)->nullable();
            $table->date('next_service_date')->nullable();
            $table->integer('odometer')->default(0);
            $table->integer('service_interval')->default(5000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
