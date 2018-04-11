<?php

namespace DurianSoftware\Seeder\BackOffice\Inquiry;

use Illuminate\Database\Seeder;
use \DurianSoftware\Models\Inquiry;
use \DurianSoftware\Models\Type;

class InquiryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inquiry::truncate();
        Type::truncate();
        
        factory(Inquiry::class, 200)->create();

        Type::create([
            'type'=>'Used'
        ]);

        Type::create([
            'type'=>'New'
        ]);

        Type::create([
            'type'=>'Repeat'
        ]);
    }
}
