<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(UserHasGroupsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(StreetTypesTableSeeder::class);
        $this->call(PersonCategoriesTableSeeder::class);
        $this->call(PersonDocumentTypesTableSeeder::class);
        $this->call(PersonEmployeeShiftsTableSeeder::class);
        $this->call(PersonEmployeePaymentsTableSeeder::class);
        $this->call(ObjectAgenciesTableSeeder::class);
        $this->call(ObjectFuelsTableSeeder::class);
        $this->call(ObjectTypesTableSeeder::class);
        $this->call(ObjectTractionsTableSeeder::class);
        $this->call(ObjectManufacturesTableSeeder::class);        
        $this->call(ContractTypesTableSeeder::class);
        $this->call(ContractMeasuresTableSeeder::class);
        $this->call(PersonDocumentFrequenciesTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductMeasuresTableSeeder::class);
        $this->call(ObjectNoteMeasuresTableSeeder::class);
        $this->call(ObjectStopFactorTypesTableSeeder::class);
        $this->call(ObjectStopFactorServicesTableSeeder::class);
    }
}
