<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('type', ['webinaire', 'masterclass', 'conference']); // Type d'événement
            $table->dateTime('event_date');
            $table->string('duration'); // Ex: "90 min", "120 min"
            $table->decimal('price', 10, 2)->nullable(); // Nullable pour événements gratuits
            $table->string('location'); // "En ligne" ou adresse physique
            $table->integer('max_participants')->nullable();
            $table->integer('registered_count')->default(0);
            $table->string('image');
            $table->boolean('is_free')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->text('features')->nullable(); // Accompagnement personnalisé, etc.
            $table->timestamps();
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->unique(['event_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('events');
    }
};
