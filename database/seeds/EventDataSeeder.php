<?php

use Illuminate\Database\Seeder;
use App\EventData;
use App\EventDate;

/**
 * Class EventDataSeeder
 */
class EventDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_date = json_decode('[
            {
                "title": "A Cheese Festival Sydney 2020",
                "description": "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus condimentum erat et gravida mollis. Sed eleifend sollicitudin nibh, sit amet consectetur tellus tempor sed. Proin viverra sem at mollis consequat. Pellentesque nec viverra orci, eu pulvinar neque. Donec dapibus massa vel lectus tempus, sit amet pharetra neque sollicitudin. Phasellus id sagittis nibh. Aliquam eget rhoncus ante.</p><p>Sed vel leo commodo lacus tristique hendrerit id in mauris. Sed urna sapien, mollis eget dignissim sit amet, rhoncus id ex. Donec pellentesque orci sit amet nibh hendrerit, rhoncus finibus purus sagittis. Vivamus convallis arcu non nisl ullamcorper rutrum. Duis vel euismod lorem. Morbi pellentesque sollicitudin dapibus. Pellentesque at sollicitudin dolor. Maecenas nec lorem sapien. Integer et sollicitudin eros, eu aliquet neque. Maecenas vulputate erat vitae molestie eleifend. Pellentesque elementum accumsan dolor quis vehicula.</p>",
                "image": "https://i.picsum.photos/id/572/700/400.jpg",
                "date": "2008-11-11",
                "types": ["charity & causes", "paid"],
                "booking_times": ["9:00am", "11:00am", "2:00pm"]
            },
            {
                "title": "The Critical Reflection Conference Sydney",
                "description": "<p>Critical reflection is a key feature of the National Quality Framework, as it strongly influences quality in education and care settings, and contributes to ongoing quality improvement.  Educators who understand how to critically reflect on practice are able to identify areas for practice improvement and contribute to improved learning and development outcomes for children. Both the EYLF and MTOP refer to ongoing learning and reflective practice as one of the principles that support effective education and care.</p>",
                "image": "https://i.picsum.photos/id/212/700/400.jpg",
                "date": "2008-10-29",
                "types": ["charity & causes", "paid"],
                "booking_times": ["3:25am", "2:30pm"]
            },
            {
                "title": "Introduction to Bush Kinder",
                "description": "<p>This full day course is designed for educators who are interested in setting up their own bush kinder or for those who already delivering and may want to boost their practice. Learn new nature games, how to make the most out of risk and play, the art of educating with nature, storytelling and eco-art.</p><p>Our trainers are subject matter experts in nature education and outdoor learning. They have received nationally and internationally recognised training in Forest Schools, Environmental and Outdoor Education, Science Communication and Training and Assessment.</p>",
                "image": "https://i.picsum.photos/id/188/700/400.jpg",
                "date": "2018-6-29",
                "types": ["food & drink", "paid"],
                "booking_times": ["11:25am", "1:00pm", "4:30pm"]
            },
            {
                "title": "MLA Virtual Classroom",
                "description": "<p>Meat and Livestock Australia’s virtual classroom Cattle and Sheep Farming today gives your students an exciting and engaging opportunity to talk to a working Aussie farmer.</p><p>Each participating classroom will receive a free activity pack including 2 posters and a cattle eartag activity so you can continue your learning in the classroom</p>",
                "image": "https://i.picsum.photos/id/531/700/400.jpg",
                "date": "2008-06-29",
                "types": ["virtual classroom", "free"],
                "booking_times": ["8:45am", "5:00pm", "9:30pm"]
            },
            {
                "title": "Australian Eggs Virtual Classroom",
                "description": "<p>Bring the farm to your school and watch chicks hatch and grow in your classroom. Use the additional educational material such as interactive whiteboard lessons to provide your students with a unique learning experience. Don’t miss out on this ‘eggcellent’ opportunity and book now!</p>",
                "image": "https://i.picsum.photos/id/177/700/400.jpg",
                "date": "2008-06-29",
                "types": ["virtual classroom", "paid"],
                "booking_times": ["9:25am", "1:40pm", "3:30pm"]
            },
            {
                "title": "Olympic Park Virtual Classroom",
                "description": "<p>Children aged up to 5 years and their parents/carers can meet the Park Ranger at a new free activity on Tuesday mornings during term time, Term 1 will commence on 4 February 2020. Meet the Park Ranger and enjoy stories, songs, rhymes and simple crafts, as you explore the natural world.  The program will include a short walk through the parklands and adjacent wetlands.</p><p>With a different theme, story and discovery activity each week, this will be an engaging and fun activity for children and their parents /carers alike. </p>",
                "image": "https://i.picsum.photos/id/611/700/400.jpg",
                "date": "2008-06-29",
                "types": ["virtual classroom", "free"],
                "booking_times": ["10:25am", "3:15pm", "6:30pm"]
            }
        ]');
        $event = [] ;
        $dates = [] ;
        foreach ($event_date as $key => $value) {
            array_push($event, [
                'title' => $value->title,
                'description' => $value->description,
                'image' => $value->image,
                'type' => $value->types[0],
                'paid' => ($value->types[1]=='paid'),
            ]);
            foreach ($value->booking_times as $time) {
                array_push($dates, [
                    'event_data_id'=> $key+1,
                    'date_time' => $value->date.' '.$time
                    ]
                );
            }
        }
        EventDate::insert($dates);
        EventData::insert($event);
    }
}
