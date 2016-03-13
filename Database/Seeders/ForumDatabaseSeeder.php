<?php

namespace Cms\Modules\Forum\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ForumDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        //$this->call(__NAMESPACE__.'\');
    }
}
