<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_overviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->integer('active_users')->default(0);
            $table->integer('sessions')->default(0);
            $table->integer('page_views')->default(0);
            $table->float('engagement_rate')->default(0);
            $table->integer('conversions')->default(0);
            $table->timestamps();
            
            $table->unique(['website_id', 'date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_overviews');
    }
};
