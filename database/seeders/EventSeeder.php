<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'event_slug'=>'Event A',
                'name' => 'Event A',
                'image' => 'https://example.com/images/event-a.jpg',
                'short_description' => 'Short description for Event A',
            ],
            // [
            //     'name' => 'Event B',
            //     'image' => 'https://example.com/images/event-b.jpg',
            //     'short_description' => 'Short description for Event B',
            // ],
            // [
            //     'name' => 'Event C',
            //     'image' => 'https://example.com/images/event-c.jpg',
            //     'short_description' => 'Short description for Event C',
            // ],
            // Add more data as needed
        ];
        foreach($data as $item){
            Event::firstOrCreate($item);
        }

       
    }
}

