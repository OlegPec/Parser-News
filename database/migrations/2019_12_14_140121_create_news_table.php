<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('preview_description');
            $table->string('preview_image')->nullable();
            $table->text('detail_description')->nullable();
            $table->json('detail_images')->nullable();
            $table->smallInteger('news_channel_id');
            $table->string('category')->nullable();
            $table->string('news_url'); //адрес новости
            $table->timestamp('public_date');
//            $table->timestamp('expiration_date'); //дата окончания показа
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('news');
    }
}
