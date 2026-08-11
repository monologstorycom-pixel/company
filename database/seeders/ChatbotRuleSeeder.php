<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotRule;

class ChatbotRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'keyword' => 'herbal',
                'response' => 'Our herbal products are made from 100% natural ingredients and BPOM certified.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
            [
                'keyword' => 'price',
                'response' => 'Please check our product page for the latest price list.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
            [
                'keyword' => 'contact',
                'response' => 'You can contact us at (+62) 821-9698-146 or visit our contact page.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
            [
                'keyword' => 'certification',
                'response' => 'All our products are Halal MUI certified and BPOM approved.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
            [
                'keyword' => 'natural',
                'response' => 'Yes, our products are made from 100% natural ingredients.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
            [
                'keyword' => 'location',
                'response' => 'We are located at Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak, Bangsa, Kec. Kebasen, Kabupaten Banyumas, Jawa Tengah 53282.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
            [
                'keyword' => 'hours',
                'response' => 'Our working hours are from 07:00 to 16:00 WIB, Monday to Saturday.',
                'type' => 'text',
                'priority' => 1,
                'status' => 'active',
            ],
        ];

        foreach ($rules as $rule) {
            ChatbotRule::firstOrCreate(
                ['keyword' => $rule['keyword']],
                $rule
            );
        }
    }
}