<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('category_id')
            ->nullable() /* viene da un db già pieno quindi consentiamo valori nulli per la FK */
            ->constrained()
            ->onDelete('set null');
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
            $table->dropForeign(['category_id']); /* numero di elementi da togliere, nota le [] perché può essere multipla */
            $table->dropColumn('category_id'); /* darebbe problemi senza la precedente perché prima va tolta la relazione, va sganciata */
        });
    }
}
