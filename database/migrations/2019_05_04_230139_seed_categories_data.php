<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => 'PHP',
                'description' => 'PHP相关文章',
            ],
            [
                'name'        => 'Laravel',
                'description' => 'Laravel 框架相关文章',
            ],
            [
                'name'        => '前端',
                'description' => 'web 前端相关文章',
            ],
            [
                'name'        => '关于本站',
                'description' => '站点公告',
            ],
            [
                'name'        => 'MySQL',
                'description' => 'MySQL 相关文章',
            ],
        ];
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
