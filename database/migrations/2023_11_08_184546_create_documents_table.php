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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->integer('code');
            $table->longText('content');
            $table->unsignedBigInteger('type_document_id');
            $table->unsignedBigInteger('process_id');
            $table->string('doc');
            $table->timestamps();
            $table->foreign('type_document_id')->references('id')->on('type_documents');
            $table->foreign('process_id')->references('id')->on('processes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
