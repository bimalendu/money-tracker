<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            // Create the unsigned integer column in MySQL as usual
            if (config('database.default') != 'sqlite') {
                $table->integer('user_id')->unsigned()->index();
            }
            $table->timestamps();
        });
        // Add the column separately if it's SQLite
        if (config('database.default') == 'sqlite') {
            \DB::statement('ALTER TABLE tags ADD COLUMN user_id INTEGER NOT NULL DEFAULT 0 CHECK(user_id >= 0)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
