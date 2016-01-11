<?php

use Illuminate\Database\Migrations\Migration;

class ForumAddPostTable extends Migration
{

    public function __construct()
    {
        // Get the prefix
        $this->prefix = config('cms.forum.config.table-prefix', 'forum_');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = $this->prefix;
        $authModel = config('auth.model');

        Schema::create($prefix.'posts', function ($table) use ($prefix, $authModel) {
            $table->increments('id')->unsigned();
            $table->integer('thread_id')->unsigned()->index();
            $table->integer('author_id')->unsigned()->index();
            $table->text('body');
            $table->timestamps();

            // $table->foreign('thread_id')->references('id')->on($prefix.'threads');
            // $table->foreign('author_id')->references('id')->on(with(new $authModel)->getTable());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = $this->prefix;

        // drop the key first
        // Schema::table($prefix.'threads', function ($table) use ($prefix) {
        //     $table->dropForeign($prefix.'posts_thread_id_foreign');
        //     $table->dropForeign($prefix.'posts_author_id_foreign');
        // });
        // then the table
        Schema::drop($prefix.'posts');
    }
}
