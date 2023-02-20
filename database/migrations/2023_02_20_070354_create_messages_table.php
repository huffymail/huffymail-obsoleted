<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique();
            $table->string('from')->index();
            $table->string('to')->index();
            $table->boolean('spam_verdict')->index();
            $table->boolean('virus_verdict')->index();
            $table->text('subject');
            $table->longText('html');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
