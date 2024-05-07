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
    public function run(): void
    {
        $violations = [
            [
                'code' => '1A',
                'violation' => 'DRIVING WITHOUT DL, DRIVING WITH INVALID, FAKE, EXPIRED, WITHOUT CONDUCTOR’S LICENSE'
            ],
            [
                'code' => '1D',
                'violation' => 'DRIVING UNDER THE INFLUENCE OF ALCOHOL/DRUGS'
            ],
            [
                'code' => '1E',
                'violation' => 'RECKLESS, UNSAFE LOAD, OPEN DOOR, SWERVING, BEATING THE RED LIGHT, ACCIDENT, UNSAFE MV, BACKING, TAIL GATING, OVER SPEEDING, BACKING AGAINST TRAFFIC, COUNTERFLOW(EXPRESSWAY)'
            ],
            [
                'code' => '1E.1',
                'violation' => 'NON-PRO'
            ],
            [
                'code' => '1E.2',
                'violation' => 'PRO'
            ],
            [
                'code' => '1G.1',
                'violation' => 'NOT WEARING SEATBELT DRIVER/PASSENGER (FOR HIRE/PRIVATE)'
            ],
            [
                'code' => '1G.2',
                'violation' => 'NO SEATBELT SIGNAGE (FOR HIRE)'
            ],
            [
                'code' => '1H',
                'violation' => 'NO HELMET, NO ICC STICKER'
            ],
            [
                'code' => '1I',
                'violation' => 'FAILURE TO CARRY DL, FAILURE TO SURRENDER DL, NO OR CR- W/ PLATE NUMBER'
            ],
            [
                'code' => '1J.1',
                'violation' => 'ILLEGAL PARKING'
            ],[
                'code' => '1J.2',
                'violation' => 'DTS, TRUCK BAN, TRICYCLE BAN, ILLEGAL ENTRY, DTO'
            ],
            [
                'code' => '1J.3',
                'violation' => 'EXCESS PASSENGER'
            ],
            [
                'code' => '1J.4',
                'violation' => 'NO/INSUFFICIENT CANVASS COVER'
            ],
            [
                'code' => '1J.5',
                'violation' => 'HITCHING'
            ],
            [
                'code' => '1J.6',
                'violation' => 'FAILURE TO DIM HEADLIGHTS'
            ],
            [
                'code' => '1J.9',
                'violation' => 'DRIVING AGAINST THE TRAFFIC, COUNTERFLOW (WITHIN MANILA)'
            ],
            [
                'code' => '1J.10',
                'violation' => 'ILLEGAL TURN, ILLEGAL U-TURN'
            ],
            [
                'code' => '1J.11',
                'violation' => 'ILLEGAL OVERTAKING'
            ],
            [
                'code' => '1J.14',
                'violation' => 'FAILURE TO GIVE WAY'
            ],
            [
                'code' => '1J.22',
                'violation' => 'ONOZ/OVERTAKING ON NO OVERTAKING ZONE'
            ],
            [
                'code' => '1J.31',
                'violation' => 'ILLEGAL RIGHT TURN'
            ],
            [
                'code' => '1J.32',
                'violation' => 'ILLEGAL LEFT TURN'
            ],
            [
                'code' => '1J.34',
                'violation' => 'UNSAFE TOWING'
            ],
            [
                'code' => '1J.35',
                'violation' => 'OBSTRUCTION, SLOW MOVING, OVERSTAYING, ILLEGAL LOADING/UNLOADING'
            ],
            [
                'code' => '1J.37 AND 4-2',
                'violation' => 'REFUSED TO CONVEY PASSENGER (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.38 AND 4-3',
                'violation' => 'OVERCHARGING/UNDERCHARGING'
            ],
            [
                'code' => '1J.39 AND 4-5',
                'violation' => 'NO CPC (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.41 AND 4-9',
                'violation' => 'DEFECTIVE LIGHTS (FOR HIRE) (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.42 AND 4-10',
                'violation' => 'FAILURE TO PROVIDE FARE DISCOUNT (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.45 AND 4-18',
                'violation' => 'NO SIGN BOARD (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.46 AND 4-19',
                'violation' => 'ILLEGAL TERMINAL/PICK AND DROP (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.48 AND 4-21',
                'violation' => 'FAILURE TO PROVIDE FIRE EXTINGUISHER AND STOP AND GO SIGNAGE (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.49 AND 4-22',
                'violation' => 'CUTTING TRIP (WITH PLATE NUMBER)'
            ],
            [
                'code' => '1J.50 AND 4-23',
                'violation' => 'NO FARE MATRIX'
            ],
            [
                'code' => '1J.51 AND 4-25',
                'violation' => 'BREACH OF FRANCHISE'
            ],
            [
                'code' => '2A',
                'violation' => 'UNREGISTERED MV'
            ],
            [
                'code' => '2B',
                'violation' => 'CHANGE COLOR/UNAUTHORIZED MODIFICATION/CHANGE ENGINE'
            ],
            [
                'code' => '2D',
                'violation' => 'NO/DEFECTIVE LIGHTS, NO EWD (PRIVATE/FOR HIRE), UNECESSARY LIGHTS, PD-96'
            ],
            [
                'code' => '2E',
                'violation' => 'TAMPERING/NO PLATE/IMPROVISED PLATE (PRIVATE)'
            ],
            [
                'code' => '2H',
                'violation' => 'NO RED FLAG, NO STICKER, NO TRADE NAME, UNREGISTERED TOP LOAD, NO EXTENSION LIGHT, EXTENDED LOAD W/O RED FLAG'
            ],
            [
                'code' => '3C',
                'violation' => 'EXCESS LOAD/CAPACITY'
            ],
            [
                'code' => '4-1',
                'violation' => 'COLORUM/OUT OF LINE'
            ],
            [
                'code' => '4-4',
                'violation' => 'BODY MARKINGS/SECTION 33'
            ],
            [
                'code' => '4-6',
                'violation' => 'SPURIOUS DOCUMENTS, FAKE OR/CR, PLATES, STICKERS AND TAGS (FOR HIRE)'
            ],
            [
                'code' => '4-7',
                'violation' => 'DISCOURTEOUS/ARROGANT DRIVER'
            ],
            [
                'code' => '4-17',
                'violation' => 'NO PANEL ROUTE'
            ],
            [
                'code' => '4-24',
                'violation' => 'NO INTERNATIONAL SYMBOL OF ACCESSIBILITY'
            ],
            [
                'code' => '1.RA 10666',
                'violation' => 'SAFETY OF CHILDREN ABOARD MOTORCYCLES'
            ],
            [
                'code' => '1.DD.A',
                'violation' => 'DISTRACTED DRIVING RA 10913'
            ]
        ];
        
        foreach ($violations as $violation) {
            TrafficViolation::create([
                'code' => $violation['code'],
                'violation' => $violation['violation']
            ]);
        }
    }
}
