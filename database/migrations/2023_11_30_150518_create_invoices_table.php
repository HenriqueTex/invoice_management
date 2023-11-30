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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('unique_document_identifier', 9)->unique();
            $table->decimal('value', 10, 2)->unsigned();
            $table->date('issue_date');
            $table->string('sender_cnpj', 14)->nullable();
            $table->string('sender_name', 100);
            $table->string('carrier_cnpj', 14)->nullable();
            $table->string('carrier_name', 100);
            $table->foreignId("user_id");
            $table->foreign('user_id')->references("id")->on('users')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
