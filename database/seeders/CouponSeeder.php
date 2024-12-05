<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Coupon::create([
            'code' => 'Summer2024',
            'discount_type' => 'percentage',
            'discount_amount' => '50',
            'expires_at' => '2024-12-15 00:00:00',
            'min_cart_amount' => '200',
        ]);
        Coupon::create([
            'code' => 'Summer2025',
            'discount_type' => 'fixed',
            'discount_amount' => '100',
            'expires_at' => '2024-12-15 00:00:00',
            'min_cart_amount' => '200',
        ]);
        Coupon::create([
            'code' => 'abc',
            'discount_type' => 'fixed',
            'discount_amount' => '100',
            'expires_at' => '2024-11-15 00:00:00',
            'min_cart_amount' => '200',
        ]);
    }
}
