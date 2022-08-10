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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('content', 4000)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('reminder_at')->nullable();
            $table->smallInteger('status');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('todos');
    }
};
