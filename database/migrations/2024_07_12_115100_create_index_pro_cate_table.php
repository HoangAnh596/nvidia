<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexProCateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('categories', function (Blueprint $table) {
        //     $table->index('slug');
        // });

        // Schema::table('products', function (Blueprint $table) {
        //     $table->index('name');
        //     $table->index('slug');
        //     $table->index('code');
        // });

        // Schema::table('product_categories', function (Blueprint $table) {
        //     $table->index('product_id');
        //     $table->index('category_id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
