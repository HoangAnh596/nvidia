<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('related_pro')->nullable();
            $table->string('tag_ids')->nullable();
            $table->char('code', 20);
            $table->tinyInteger('is_outstand')->default(0)->comment('1: nổi bật, 0: không nổi bật');
            $table->string('price')->nullable();
            $table->float('quantity', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('image_ids')->nullable();
            $table->text('des')->nullable();
            $table->text('content')->nullable();
            $table->string('title_img')->nullable();
            $table->string('alt_img')->nullable();
            $table->string('title_seo')->nullable();
            $table->string('keyword_seo')->nullable();
            $table->string('des_seo')->nullable();
            $table->softdeletes();
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
        Schema::dropIfExists('products');
    }
}
