<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TrafficViolation;
class TrafficViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ["code" => "1.j.1", "violation" => "Parking Violations"],
            ["code" => "1.j.3", "violation" => "Allowing passengers on top or cover of a motor vehicle"],
            ["code" => "1.j.5", "violation" => "Permitting passenger to ride on step board or mudguard of MV"],
            ["code" => "1J.50 AND 4-23", "violation" => "NO FARE MATRIX"],
            ["code" => "2.d", "violation" => "MV operating with defective/improper/unauthorized accessories, devices, equipment and parts"],
            ["code" => "1.RA 10666", "violation" => "SAFETY OF CHILDREN ABOARD MOTORCYCLES"],
            ["code" => "1.DD.A", "violation" => "Distracted Driving (RA 10913)"],
            ["code" => "1.j.7", "violation" => "Driving in a place not intended for traffic or false parking"],
            ["code" => "4.1.a", "violation" => "Private MV operating as a PUV without authority from the LTFRB"],
            ["code" => "4.5", "violation" => "NO FRANCHISE/CERTIFICATE OF PUBLIC CONVENIENCE OR EVIDENCE OF FRANCHISE PRESENTED DURING APPREHENSION OR CARRIED INSIDE THE MOTOR VEHICLE"],
            ["code" => "1.j.8", "violation" => "Hitching or permitting a person or to hitch to a motor vehicle"],
            ["code" => "4.1.e", "violation" => "PUV with expired CPC and without a pending application (1)"],
            ["code" => "4.1.c", "violation" => "PUV operating differently from its authorized denomination"],
            ["code" => "1.e", "violation" => "Reckless Driving"],
            ["code" => "4.6", "violation" => "FRAUD AND FALSITIES SUCH AS PRESENTATION OF FAKE AND SPURIOUS CPC, OR/CR, PLATES, STICKERS AND TAGS"],
            ["code" => "1.j.46", "violation" => "Pick and Drop of Passengers outside the terminal"],
            ["code" => "1.j.51", "violation" => "Breach of franchise conditions"],
            ["code" => "4.19", "violation" => "PICK AND DROP OF PASSENGERS OUTSIDE THE TERMINAL (PUJ, PUB, UV)"],
            ["code" => "4.25", "violation" => "BREACH OF FRANCHISE CONDITIONS UNDER 2011 REVISED TERMS AND CONDITIONS OF CPC NOT OTHERWISE HEREIN PROVIDED."],
            ["code" => "1.j.41", "violation" => "Operating the unit/s with defective parts"],
            ["code" => "4.9", "violation" => "OPERATING THE UNIT/S WITH DEFECTIVE PARTS AND ACCESSORIES"],
            ["code" => "1.j.37", "violation" => "Refusal to render service to the public"],
            ["code" => "4.2", "violation" => "REFUSAL TO RENDER SERVICE TO THE PUBLIC OR CONVEY PASSENGER TO DESTINATION"],
            ["code" => "1.j.38", "violation" => "Overcharging/Undercharging of fare"],
            ["code" => "4.3", "violation" => "OVERCHARGING/UNDERCHARGING OF FARE"],
            ["code" => "1.j.39", "violation" => "No evidence of franchise presented during apprehension"],
            ["code" => "2.a", "violation" => "Driving an unregistered Motor Vehicle"],
            ["code" => "1.g.1", "violation" => "Failure to wear the prescribed seatbelt device and/or failure to require the front seat passenger to wear seatbelt"],
            ["code" => "1.j.35", "violation" => "Obstructing the free passage of other vehicles"],
            ["code" => "1.j.45", "violation" => "No sign board"],
            ["code" => "4.18", "violation" => "NO SIGN BOARD (PUJ, PUB, UV)"],
            ["code" => "1.j.49", "violation" => "Trip cutting"],
            ["code" => "4.22", "violation" => "TRIP CUTTING (PUJ, PUB, UV)"],
            ["code" => "1.h", "violation" => "Failure to wear the standard protective MC helmet or failure to require the back rider to wear standard protective MC helmet (R.A 10054)"],
            ["code" => "1.i", "violation" => "FAILURE TO CARRY DRIVER'S LICENSE, CERTIFICATE OF REGISTRATION OR OFFICIAL RECEIPT WHILE DRIVING A MOTOR VEHICLE"],
            ["code" => "1.j.2", "violation" => "Disregarding Traffic Signs"],
            ["code" => "4.1.b", "violation" => "PUV operating outside of its approved route or area"],
            ["code" => "4.17", "violation" => "NO PANEL ROUTE (PUJ, PUB, UV)"],
            ["code" => "2.f", "violation" => "Smoke Belching (Section 46, R.A. 8749)"],
            ["code" => "2.e", "violation" => "Failure to attach or improper attachment/tampering of MV license plates and/or third plate sticker."],
            ["code" => "1.a", "violation" => "Includes inappropriate or invalid driver's license"],
            ["code" => "4.7", "violation" => "EMPLOYING RECKLESS, INSOLENT, DISCOURTEOUS OR ARROGANT DRIVERS"],
            ["code" => "2.b", "violation" => "Change in color and other unauthorized modifications"],
            ["code" => "WS", "violation" => "Wearing Slipper"],
        ];

        foreach ($data as $item) {
            TrafficViolation::create([
                'code' => $item['code'],
                'violation' => $item['violation'],
            ]);
        }
    }
}
