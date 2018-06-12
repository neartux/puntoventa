<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(StatusTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UnitiesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(AdjustmentReasonTableSeeder::class);
        $this->call(MovementTypeTableSeeder::class);
        $this->call(ReasonWithdrawalCajaTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(PrintingFormatTableSeeder::class);
        $this->call(DeparmentTableSeeder::class);
    }
}
