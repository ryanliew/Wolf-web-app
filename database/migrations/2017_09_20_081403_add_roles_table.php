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
                    ['name' => 'Judge', 'type' => 'neutral', 'score' => 1], 
                    ['name' => 'Fortune Teller', 'type' => 'good', 'score' => 2],
                    ['name' => 'Witch', 'type' => 'good', 'score' => 2],
                    ['name' => 'Hunter', 'type' => 'good', 'score' => 2],
                    ['name' => 'Villager', 'type' => 'good', 'score' => 2],
                    ['name' => 'Wolf', 'type' => 'bad', 'score' => 3],
                    ['name' => 'Demon', 'type' => 'bad', 'score' => 3],
                    ['name' => 'Idiot', 'type' => 'good', 'score' => 2],
                    ['name' => 'Guard', 'type' => 'good', 'score' => 2],
                    ['name' => 'Unknown', 'type' => 'default', 'score' => 0],
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
