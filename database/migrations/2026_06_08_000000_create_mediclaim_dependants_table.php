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
        Schema::create('mediclaim_dependants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index()->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('relationship', 30);
            $table->string('top_up', 20);
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
        Schema::dropIfExists('mediclaim_dependants');
    }
};
