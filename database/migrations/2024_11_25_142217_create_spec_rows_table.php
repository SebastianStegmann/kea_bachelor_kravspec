<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('spec_rows', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->integer('row_identifier');
            $table->foreignId('spec_id')->index()->constrained('specs')->onDelete('cascade');
            $table->string('priority')->default('M'); // Changed to string to allow letters
            $table->string('version')->default('1');
            $table->unsignedBigInteger('accepted_at')->default(0);
            $table->softDeletes();
            $table->timestamps();


            $table->index(['spec_id', 'row_identifier']);
        });
    }

    // $table->foreign('spec_id')->references('id')->on('specs')->onDelete('cascade');
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spec_rows');
    }
};
