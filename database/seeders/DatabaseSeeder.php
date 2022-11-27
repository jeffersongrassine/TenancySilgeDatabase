<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\Tenant::factory(10)
        //     ->hasStores(1)
        //     ->create();

        // ignored o scope add
        foreach (\App\Models\Store::withoutGlobalScope(\App\Scopes\TenantScope::class)->get() as $store) {

            $tenantAndStoreIds = ['store_id' => $store->id, 'tenant_id' => $store->tenant_id];

            \App\Models\Product::factory(20, $tenantAndStoreIds)
                ->create();

            // dd(\App\Models\Product::factory(20, $tenantAndStoreIds)
            // ->make());    
        }
    }
}
