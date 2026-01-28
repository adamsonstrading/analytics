<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_audiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('user_type'); // New vs Returning
            $table->integer('users')->default(0);
            $table->timestamps();
            
            $table->index(['website_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_audiences');
    }
};
