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
        Schema::create('hackathon_rule', function (Blueprint $table) {
            $table->id();
            $table->string('hackathon_id')->nullable()->constrained('hackathons')->onDelete('cascade')->onUpdate('cascade');
            $table->string('rule_id')->nullable()->constrained('rules')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('table_hackathons_rules');
    }
};
