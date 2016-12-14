<?php

use Illuminate\Database\Migrations\Migration;

class ForumAddThreadTable extends Migration
{
    public function __construct()
    {
        // Get the prefix
        $this->prefix = config('cms.forum.config.table-prefix', 'forum_');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        $prefix = $this->prefix;
        $authModel = config('cms.auth.config.user_model');

        Schema::create($prefix.'threads', function ($table) use ($prefix, $authModel) {
            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned()->index();
            $table->integer('author_id')->unsigned()->index();
            $table->string('name');
            $table->boolean('locked')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();

            // $table->foreign('category_id')->references('id')->on($prefix.'categories');
            // $table->foreign('author_id')->references('id')->on(with(new $authModel)->getTable());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $prefix = $this->prefix;

        // drop the key first
        // Schema::table($prefix.'threads', function ($table) use ($prefix) {
        //     $table->dropForeign($prefix.'threads_category_id_foreign');
        //     $table->dropForeign($prefix.'threads_author_id_foreign');
        // });
        // then the table
        Schema::drop($prefix.'threads');
    }
}
