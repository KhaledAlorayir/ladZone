<?php

use App\Shared\Enums\InteractionType;
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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum("type", array_column(InteractionType::cases(), 'value'));
            $table->string('content', 5000)->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId("game_list_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
