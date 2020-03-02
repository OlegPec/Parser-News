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
            /*$table->uuid('id')->primary();
            $table->string('title')->comment('Заголвок');
            $table->text('preview_description')->comment('Текст превью новости'); //временное решение
            $table->string('preview_image')->nullable();
            $table->string('generated_image');
            $table->text('detail_description')->nullable();
            $table->text('detail_description_full')->nullable();
            $table->json('detail_images')->nullable();
            $table->smallInteger('news_channel_id');
            $table->string('category')->nullable();
            $table->string('news_url'); //адрес новости
            $table->timestamp('public_date');
//            $table->timestamp('expiration_date'); //дата окончания показа
            $table->boolean('active')->default(1);
            $table->timestamps();*/


            $table->uuid('id')->primary();
            $table->string('title')->comment('Заголвок');
//            $table->string('preview_description')->comment('Текст превью новости'); //временное решение
            $table->string('title_image')->nullable()->comment('Главное изображение');
            $table->string('generated_image')->comment('Сгенерированное изображение');
            $table->text('description')->nullable()->comment('Текст новости(не полный)');
            $table->text('detail_description')->nullable()->comment('Полный текст новости');
            $table->json('detail_images')->nullable()->comment('Список картинок при просмотре новости');
            $table->smallInteger('news_channel_id')->comment('Ключ канала новостей');
            $table->string('category')->nullable()->comment('Категория новости'); //todo: Переделать на ключ
            $table->string('news_url')->comment('Сылка на новость'); //адрес новости
            $table->timestamp('public_date')->comment('Дата публикации');
//            $table->timestamp('expiration_date'); //дата окончания показа
            $table->boolean('active')->default(1)->comment('Активность новости');
            $table->timestamps();

            $table->foreign('news_channel_id')->references('id')->on('news_channels')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
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
