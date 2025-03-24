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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('github_link');
            $table->string('status');
            $table->foreignId('hackathon_id')->constrained('hackathons')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('jury_id')->nullable()->constrained('juries')->onUpdate('cascade')->nullOnDelete();
            $table->foreignId('jury_noted_id')->nullable()->constrained('juries')->onUpdate('cascade')->nullOnDelete();
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
        Schema::dropIfExists('teams');
    }
};
