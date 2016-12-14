<?php

use Illuminate\Database\Migrations\Migration;

class ForumAddCategoryTable extends Migration
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

        Schema::create($prefix.'categories', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('color');
            $table->tinyInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $prefix = $this->prefix;

        Schema::drop($prefix.'categories');
    }
}
