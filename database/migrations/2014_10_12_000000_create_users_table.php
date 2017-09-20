<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar_path')->default('/img/default.jpg');
            $table->rememberToken();
            $table->timestamps();
        });

        $users = ['ryan', 'junec', 'baobaobiji', 'yoongwai', 'zhenrong', 'yaoyao', 'hema', 'haima'];
        
        foreach($users as $user):
            DB::table('users')->insert([
                'name' => $user,
                'email' => $user . '@email.com',
                'password' => bcrypt('123456'),
            ]);
        endforeach;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
