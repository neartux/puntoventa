<?php

use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $status = [
            ['id' => StatusKeys::STATUS_ACTIVE, 'name' => 'Active'],
            ['id' => StatusKeys::STATUS_INACTIVE, 'name' => 'Inactive'],
            ['id' => StatusKeys::STATUS_CANCELLED, 'name' => 'Cancelled'],
            ['id' => StatusKeys::STATUS_OPEN, 'name' => 'Open'],
            ['id' => StatusKeys::STATUS_CLOSED, 'name' => 'Closed'],
        ];

        DB::table('status')->insert($status);
    }
}
