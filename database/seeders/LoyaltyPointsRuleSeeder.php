<?php

namespace Database\Seeders;

use App\Models\LoyaltyPointsRule;
use Illuminate\Database\Seeder;

class LoyaltyPointsRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rules = [
            1 => [
                'points_rule' => 'Wine +5',
                'accrual_type' => LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT,
                'accrual_value' => 5,
            ],
            [
                'points_rule' => 'Coffee +1%',
                'accrual_type' => LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE,
                'accrual_value' => 1,
            ],
            [
                'points_rule' => 'Dog Food',
                'accrual_type' => LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT,
                'accrual_value' => 10,
            ],
            [
                'points_rule' => 'Vegetables +20%',
                'accrual_type' => LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE,
                'accrual_value' => 20,
            ],
        ];

        foreach ($rules as $key => $rule) {
            LoyaltyPointsRule::firstOrCreate(['id' => $key], $rule);
        }
    }
}
