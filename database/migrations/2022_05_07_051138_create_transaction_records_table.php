<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_records', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();

            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->onDelete('cascade');
            $table->foreignId('ledger_id')->nullable()->constrained('ledgers')->onDelete('cascade');
            $table->nullableMorphs('model');

            $table->boolean('direction')->default(0);
            $table->decimal('amount', 25, 5)->default(0);
            $table->string('remarks')->nullable();

            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_records');
    }
};
