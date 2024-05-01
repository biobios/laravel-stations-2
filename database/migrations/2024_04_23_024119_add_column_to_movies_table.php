<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            //公開年、概要、上映中かどうかのカラムを追加
            $table->integer('published_year')->after('image_url')->comment('公開年');
            $table->boolean('is_showing')->after('published_year')->default(false)->comment('上映中かどうか');
            $table->text('description')->after('is_showing')->comment('概要');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            //カラムを削除
            $table->dropColumn('published_year');
            $table->dropColumn('is_showing');
            $table->dropColumn('description');
        });
    }
}
