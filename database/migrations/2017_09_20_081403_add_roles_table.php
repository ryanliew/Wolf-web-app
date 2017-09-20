<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('default_score');
            $table->string('type');
            $table->timestamps();
        });

        $roles = [
                    ['name' => 'Judge', 'type' => 'neutral', 'score' => 5], 
                    ['name' => 'Fortune Teller', 'type' => 'good', 'score' => 1],
                    ['name' => 'Witch', 'type' => 'good', 'score' => 1],
                    ['name' => 'Hunter', 'type' => 'good', 'score' => 1],
                    ['name' => 'Villager', 'type' => 'good', 'score' => 1],
                    ['name' => 'Wolf', 'type' => 'bad', 'score' => 2],
                    ['name' => 'Demon', 'type' => 'bad', 'score' => 2],
                    ['name' => 'Idiot', 'type' => 'good', 'score' => 1],
                    ['name' => 'Guard', 'type' => 'good', 'score' => 1]
                ];
        
        foreach($roles as $role):
            DB::table('roles')->insert([
                'name' => $role['name'],
                'slug' => str_slug($role['name']),
                'type' => $role['type'],
                'default_score' => $role['score'],
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
        Schema::dropIfExists('roles');
    }
}
