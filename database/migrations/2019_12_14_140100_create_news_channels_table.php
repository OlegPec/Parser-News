<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Название ностного канала');
            $table->string('url')->comment('Url адрес'); //адрес на rss
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
        Schema::dropIfExists('news_channels');
    }
}
