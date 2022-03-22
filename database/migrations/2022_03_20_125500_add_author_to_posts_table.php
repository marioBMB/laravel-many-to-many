<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('user_id')
            ->constrained()  //prende automaticamente l'id  (vai SEMPRE DI migrate:refresh)
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']); /* nota le [] perché può essere multipla */
            $table->dropColumn('user_id'); /* darebbe problemi senza la precedente perché prima va tolta la relazione, va sganciata */
        });
    }
}
