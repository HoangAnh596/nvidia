<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_news', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('related_pro')->nullable();
            $table->bigInteger('parent_id');
            $table->string('image')->nullable();
            $table->text('content')->nullable();
            $table->string('title_img')->nullable();
            $table->string('alt_img')->nullable();
            $table->string('title_seo')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->string('des_seo')->nullable();
            $table->tinyInteger('is_serve')->default(1)->comment('1: hiển thị serve, 0: không');
            $table->tinyInteger('is_parent')->default(1)->comment('1: hiển thị cha, 0: không');
            $table->tinyInteger('is_menu')->default(1)->comment('1: hiển thị menu, 0: không menu');
            $table->tinyInteger('is_outstand')->default(1)->comment('1: nổi bật, 0: không nổi bật');
            $table->tinyInteger('is_public')->default(1)->comment('1: hiển thị, 0: không hiển thị');
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
        Schema::dropIfExists('category_news');
    }
}
