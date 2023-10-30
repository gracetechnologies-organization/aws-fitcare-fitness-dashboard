<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercise_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_cat_id')->nullable()->after('cat_id');
            $table->foreign('sub_cat_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercise_relations', function (Blueprint $table) {
            $table->dropForeign(['sub_cat_id']);
            $table->dropColumn('sub_cat_id');
        });
    }
};
