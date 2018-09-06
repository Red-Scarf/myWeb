<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //第2参数为回调函数
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100)->default("");
            $table->text('content');
            $table->integer('user_id')->default(0);
            $table->timestamps();//自动加入create_at和update_at字段
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
