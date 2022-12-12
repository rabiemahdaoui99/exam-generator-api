<?php

namespace App\Models;

use Illuminate\Support\Arr;

class Rcl
{
    private $quizTitle;
    private $quizGrove;
    private $quizQuestion;
    private $quizImage;
    private $quizMeasurements;
    private $quizRcl;
    private $quizAnswer;
    function __construct()
    {
    }
    function generateRcl($name)
    {
        $min = array(
            "height" => 10,
            "length" => 10,
            "angle" => 10,
            "radius" => 3,
        );
        $max = array(
            "height" => 54,
            "length" => 60,
            "angle" => 71,
            "radius" => 44,
        );
        $measurements = array(
            "height" => 0,
            "length" => 0,
            "angle" => 0,
            "radius" => 0,
        );
        $groves = array("AT 750B", "RT 755", "TM 1150");
        $images = array("at.png", "rt.png", "tm.png");
        $randIndex = rand(0, 2);
        $measurements['height'] = rand($min['height'], $max['height']);
        $measurements['length'] = rand($min['length'], $max['length']);
        $measurements['angle'] = rand($min['angle'], $max['angle']);
        $measurements['radius'] = rand($min['radius'], $max['radius']);
        $this->quizGrove = $groves[$randIndex];
        $this->quizTitle = 'Refer to drawing and the Grove (' . $this->quizGrove . ') load chart and range diagram.';
        $path = asset('/images/rcl/' . $images[$randIndex]);
        $this->quizImage = $path;
        $this->quizMeasurements = $measurements;
        switch ($name) {
            case "total weight":
                $this->quizQuestion = "What is the total weight of the load?";
                $this->quizRcl = $this->generateRclLoadweights($this->quizGrove);
                break;
            case "gross capacity":
                $values = $this->getGross($this->quizGrove);
                $measurements = array(
                    'maxRadius' => $values['maxR'],
                    'minRadius' => $values['minR'],
                );
                isset($values['angle']) ? $measurements['angle'] = $values['angle'] : $measurements['height'] = $values['height'];
                $this->quizQuestion = "What is the Gross Capacity at Minimum Radius?";
                $this->quizAnswer = array(
                    "minCapacity" => $values['minCapacity'],
                    "maxCapacity" => $values['maxCapacity']
                );
                $fakeAnswers = [
                    [
                        "minCapacity" => $this->quizAnswer["minCapacity"] + rand(1, 5),
                        "maxCapacity" => $this->quizAnswer["maxCapacity"] + rand(1, 5)
                    ],
                    [
                        "minCapacity" => $this->quizAnswer["minCapacity"] - rand(1, 10),
                        "maxCapacity" => $this->quizAnswer["maxCapacity"] - rand(1, 10)
                    ],
                    [
                        "minCapacity" => $this->quizAnswer["minCapacity"] + rand(6, 11),
                        "maxCapacity" => $this->quizAnswer["maxCapacity"] + rand(6, 11)
                    ],

                ];
                return array(
                    "id" => 0,
                    "quizTitle" => $this->quizTitle,
                    "quizGrove" => $this->quizGrove,
                    "quizImage" => $this->quizImage,
                    "quizQuestion" => $this->quizQuestion,
                    "quizMeasurements" => $measurements,
                    "quizAnswer" => $this->quizAnswer,
                    "quizFakeAnswers" => $fakeAnswers
                );
                break;
            case "maximum radius":
                $this->quizQuestion = "What is the Maximum Radius can be lifted?";
                break;
            case "boom angle high and low":
                $this->quizQuestion = "What is the High Boom Angle at Minimum Radius?";
                break;
            case "loaded boom angle":
                $this->quizQuestion = "What is the Loaded Boom Angle at Minimum Radius?";
                break;
            case "maximum boom length":
                $this->quizQuestion = "What is the Maximum Boom Length of the lift shown?";
                break;

            default:
                break;
        }
        $fakeAnswers = [
            $this->quizRcl["Total weight"] + rand(1, 5),
            $this->quizRcl["Total weight"] - rand(1, 5),
            $this->quizRcl["Total weight"] + rand(6, 11),

        ];
        return array(
            "id" => 0,
            "quizTitle" => $this->quizTitle,
            "quizGrove" => $this->quizGrove,
            "quizImage" => $this->quizImage,
            "quizQuestion" => $this->quizQuestion,
            "quizMeasurements" => $this->quizMeasurements,
            "quizRcl" => $this->quizRcl,
            "quizFakeAnswers" => $fakeAnswers
        );
    }
    function generateRclLoadweights($grove)
    {

        switch ($grove) {
            case "AT 750B":
                $weights = array(
                    "LOAD WEIGHT" => rand(200, 800),
                    "RIGGING EQUIPMENT WEIGHT" => rand(60, 300),
                    "STOWED SWINGAWY" => 323,
                    "EXTENDED SWINGAWY" => 1958,
                    "POWER PIN FLY EXTENDED" => 0,
                    "POWER PIN FLY STOWED" =>  0,
                    "13.6 MT 1 – SHEAVE" =>  172,
                    "27.2 MT 2 - SHEAVE" =>  382,
                    "36.3 MT 4 - SHEAVE" =>  413,
                    "36.3 MT 4 – SHEAVE (W/CHEEK PLATES)" =>  499,
                    "40.8 MT 3 – SHEAVE" =>  40,
                    "40.8 MT 3- SHEAVE (W/CHEEK PLATES)" => 497,
                    "45.4 MT 4 - SHEAVE" =>  583,
                    "AUXILIARY BOOM NOSE" =>  65,
                    "9.1 MT. HEADACHE BALL" =>  254,
                    "6.8 MT. HEADACHE BALL" =>  153
                );
                $swingwayRand = rand(2, 3);
                $pwrpinRand = rand(4, 5);
                $sheaveRand = rand(6, 12);
                $auxiRand = 13;
                $haballRand = rand(14, 15);
                $keys = array_keys($weights);
                $totalWeight = $weights[$keys[0]] + $weights[$keys[1]] + $weights[$keys[$swingwayRand]] +
                    $weights[$keys[$sheaveRand]] + $weights[$keys[$auxiRand]] + $weights[$keys[$haballRand]];
                $Loadweights = array(
                    "LOAD WEIGHT" => $weights[$keys[0]],
                    "RIGGING EQUIPMENT WEIGHT" => $weights[$keys[1]],
                    "STOWED SWINGAWY" => $swingwayRand == 2 ? "✓" : "",
                    "EXTENDED SWINGAWY" => $swingwayRand == 3 ? "✓" : "",
                    "POWER PIN FLY EXTENDED" => $pwrpinRand == 4 ? "✓" : "",
                    "POWER PIN FLY STOWED" =>  $pwrpinRand == 5 ? "✓" : "",
                    "13.6 MT 1 – SHEAVE" =>  $sheaveRand == 6 ? "✓" : "",
                    "27.2 MT 2 - SHEAVE" =>  $sheaveRand == 7 ? "✓" : "",
                    "36.3 MT 4 - SHEAVE" =>  $sheaveRand == 8 ? "✓" : "",
                    "36.3 MT 4 – SHEAVE (W/CHEEK PLATES)" =>  $sheaveRand == 9 ? "✓" : "",
                    "40.8 MT 3 – SHEAVE" =>  $sheaveRand == 10 ? "✓" : "",
                    "40.8 MT 3- SHEAVE (W/CHEEK PLATES)" => $sheaveRand == 11 ? "✓" : "",
                    "45.4 MT 4 - SHEAVE" =>  $sheaveRand == 12 ? "✓" : "",
                    "AUXILIARY BOOM NOSE" =>  $auxiRand == 13 ? "✓" : "",
                    "9.1 MT. HEADACHE BALL" =>  $haballRand == 14 ? "✓" : "",
                    "6.8 MT. HEADACHE BALL" =>  $haballRand == 15 ? "✓" : "",
                    "Total weight" => $totalWeight
                );
                break;
            case "RT 755":
                $weights = array(
                    "LOAD WEIGHT" => rand(200, 800),
                    "RIGGING EQUIPMENT WEIGHT" => rand(60, 300),
                    "STOWED SWINGAWY" => 234,
                    "EXTENDED SWINGAWY" => 1447,
                    "POWER PIN FLY EXTENDED" => 0,
                    "POWER PIN FLY STOWED" => 0,
                    "55 Ton (50 MT) 4 Sheave" => 569,
                    "15 Ton (13.6 MT) 1 Sheave" => 141,
                    "Auxiliary Boom Head" => 100,
                    "5 Ton (4.5 MT) Headache Ball" => 68,
                    "7-1/2 Ton (6.8 MT) Headache Ball" => 136,
                    "10 Ton (9.1 MT) Headache Ball" => 227,
                );
                $swingwayRand = rand(2, 3);
                $pwrpinRand = rand(4, 5);
                $sheaveRand = rand(6, 7);
                $auxiRand = 8;
                $haballRand = rand(9, 11);
                $keys = array_keys($weights);
                $totalWeight = $weights[$keys[0]] + $weights[$keys[1]] + $weights[$keys[$swingwayRand]] +
                    $weights[$keys[$sheaveRand]] + $weights[$keys[$auxiRand]] + $weights[$keys[$haballRand]];
                $Loadweights = array(
                    "LOAD WEIGHT" => $weights[$keys[0]],
                    "RIGGING EQUIPMENT WEIGHT" => $weights[$keys[1]],
                    "STOWED SWINGAWY" => $swingwayRand == 2 ? "✓" : "",
                    "EXTENDED SWINGAWY" => $swingwayRand == 3 ? "✓" : "",
                    "POWER PIN FLY EXTENDED" => $pwrpinRand == 4 ? "✓" : "",
                    "POWER PIN FLY STOWED" => $pwrpinRand == 5 ? "✓" : "",
                    "55 Ton (50 MT) 4 Sheave" => $sheaveRand == 6 ? "✓" : "",
                    "15 Ton (13.6 MT) 1 Sheave" => $sheaveRand == 7 ? "✓" : "",
                    "Auxiliary Boom Head" => $auxiRand == 8 ? "✓" : "",
                    "5 Ton (4.5 MT) Headache Ball" => $haballRand == 9 ? "✓" : "",
                    "7-1/2 Ton (6.8 MT) Headache Ball" => $haballRand == 10 ? "✓" : "",
                    "10 Ton (9.1 MT) Headache Ball" => $haballRand == 11 ? "✓" : "",
                    "Total weight" => $totalWeight
                );
                break;
            case "TM 1150":
                $weights = array(
                    "LOAD WEIGHT" => rand(200, 800),
                    "RIGGING EQUIPMENT WEIGHT" => rand(60, 300),
                    "STOWED SWINGAWY" => 354,
                    "EXTENDED SWINGAWY" => 1265,
                    "POWER PIN FLY EXTENDED" => 0,
                    "POWER PIN FLY STOWED" => 0,
                    "125Ton6 – SHEAVE" => 1406,
                    "30 Ton1 - SHEAVE" => 464,
                    "AUXILIARY BOOM BALL" => 115,
                    "10Ton HEADACHE BALL" => 227,
                    "15Ton HEADACHE BALL" => 340,

                );
                $keys = array_keys($weights);
                $swingwayRand = rand(2, 3);
                $pwrpinRand = rand(4, 5);
                $sheaveRand = rand(6, 7);
                $auxiRand = 8;
                $haballRand = rand(9, 10);
                $totalWeight = $weights[$keys[0]] + $weights[$keys[1]] + $weights[$keys[$swingwayRand]] +
                    $weights[$keys[$sheaveRand]] + $weights[$keys[$auxiRand]] + $weights[$keys[$haballRand]];
                $Loadweights = array(
                    "LOAD WEIGHT" => $weights[$keys[0]],
                    "RIGGING EQUIPMENT WEIGHT" => $weights[$keys[1]],
                    "STOWED SWINGAWY" => $swingwayRand == 2 ? "✓" : "",
                    "EXTENDED SWINGAWY" => $swingwayRand == 3 ? "✓" : "",
                    "POWER PIN FLY EXTENDED" => $pwrpinRand == 4 ? "✓" : "",
                    "POWER PIN FLY STOWED" => $pwrpinRand == 5 ? "✓" : "",
                    "125Ton6 – SHEAVE" => $sheaveRand == 6 ? "✓" : "",
                    "30 Ton1 - SHEAVE" => $sheaveRand == 7 ? "✓" : "",
                    "AUXILIARY BOOM BALL" => $auxiRand == 8 ? "✓" : "",
                    "10Ton HEADACHE BALL" => $haballRand == 9 ? "✓" : "",
                    "15Ton HEADACHE BALL" => $haballRand == 10 ? "✓" : "",
                    "Total weight" => $totalWeight
                );
                break;

            default:
                break;
        }
        return $Loadweights;
    }
    function getLengthTableVal($height, $radius, $crane)
    {
        $lengthTable = array();
        switch ($crane) {
            case 'AT 750B':
                $lengthTable = array(10.6, 12.2, 15.5, 18.2, 21.3, 24.4, 27.4, 30.5, 33.5);
                break;
            case 'TM 1150':
                $lengthTable = array(13.5, 15.9, 18.3, 20.7, 23.1, 25.6, 28, 30.5, 33, 42.7, 52.4);
                break;
            case 'RT 755':
                $lengthTable = array(10.8, 12.2, 13.7, 16.8, 19.8, 22.9, 25.9, 33.5, 35.7, 43.3);
                break;

            default:
                # code...
                break;
        }
        $length = $this->calcRangeLength($radius, $height, 0);
        for ($i = 0; $i < count($lengthTable); $i++) {
            if ($length < $lengthTable[$i])
                return $lengthTable[$i];
        }
        return -1;
    }
    function getLengthTableValwAngl($angle, $radius, $crane)
    {
        $lengthTable = array();
        switch ($crane) {
            case 'AT 750B':
                $lengthTable = array(10.6, 12.2, 15.5, 18.2, 21.3, 24.4, 27.4, 30.5, 33.5);
                break;
            case 'TM 1150':
                $lengthTable = array(13.5, 15.9, 18.3, 20.7, 23.1, 25.6, 28, 30.5, 33, 42.7, 52.4);
                break;
            case 'RT 755':
                $lengthTable = array(10.8, 12.2, 13.7, 16.8, 19.8, 22.9, 25.9, 33.5, 35.7, 43.3);
                break;

            default:
                # code...
                break;
        }
        $length = $this->calcRangeLength($radius, 0, $angle);
        for ($i = 0; $i < count($lengthTable); $i++) {
            if ($length < $lengthTable[$i])
                return $lengthTable[$i];
        }
        return -1;
    }
    function getLengthIndex($length, $crane)
    {
        $lengthTable = array();
        switch ($crane) {
            case 'AT 750B':
                $lengthTable = array(10.6, 12.2, 15.5, 18.2, 21.3, 24.4, 27.4, 30.5, 33.5);
                break;
            case 'TM 1150':
                $lengthTable = array(13.5, 15.9, 18.3, 20.7, 23.1, 25.6, 28, 30.5, 33, 42.7, 52.4);
                break;
            case 'RT 755':
                $lengthTable = array(10.8, 12.2, 13.7, 16.8, 19.8, 22.9, 25.9, 33.5, 35.7, 43.3);
                break;

            default:
                # code...
                break;
        }
        $index = array_search($length, $lengthTable);
        if ($index === false) return -1;
        return $index;
    }
    function getRadiusIndex($radius, $crane)
    {
        $radiusTable = array();
        switch ($crane) {
            case 'AT 750B':
                $radiusTable = array(2.75, 3, 3.5, 4, 4.5, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30);
                break;
            case 'TM 1150':
                $radiusTable = array(3, 3.5, 4, 4.5, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18, 20, 23, 26, 29, 32, 35, 38, 41, 44, 47, 50);
                break;
            case 'RT 755':
                $radiusTable = array(3, 3.5, 4, 4.5, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40);
                break;

            default:
                # code...
                break;
        }
        $index = array_search($radius, $radiusTable);
        if ($index === false) return -1;
        return $index;
    }
    function calcRangeLength($radius, $height = 0, $angle = 0)
    {
        if ($height) {
            return intval(sqrt($radius * $radius + $height * $height));
        }
        if ($angle) {
            return intval($radius / cos(deg2rad($angle))) + 3; //
        }
        return 0;
    }
    function calcRangeAngle($radius, $height = 0, $length = 0)
    {
        if ($height) {
            return intval(rad2deg(atan($height / $radius)));
        }
        if ($length) {
            return intval(rad2deg(acos($radius / $length))); // R/L >= -1 && <= 1
        }
        return 0;
    }
    function calcRangeHeight($radius, $angle = 0, $length = 0)
    {
        if ($angle) {
            return intval($radius * tan(deg2rad($angle)));
        }
        if ($length) {
            return intval(sqrt(pow($length, 2) - pow($radius, 2))); // 
        }
        return 0;
    }
    function getMeasurementsMax($crane)
    {
        $max = array(
            "height" => 36,
            "angle" => 70,
            "radius" => 30
        );
        switch ($crane) {
            case 'RT 755':
                $max = array(
                    "height" => 30,
                    "angle" => 60,
                    "radius" => 40
                );
                break;
            case 'AT 750B':
                $max = array(
                    "height" => 36,
                    "angle" => 60,
                    "radius" => 30
                );
                break;
            case 'TM 1150':
                $max = array(
                    "height" => 42,
                    "angle" => 60,
                    "radius" => 50
                );
                break;

            default:
                # code...
                break;
        }
        return $max;
    }
    function getMeasurementsMin($crane)
    {
        $min = array(
            "height" => 12,
            "angle" => 10,
            "radius" => 2
        );
        switch ($crane) {
            case 'RT 755':
                $max = array(
                    "height" => 12,
                    "angle" => 10,
                    "radius" => 3
                );
                break;
            case 'AT 750B':
                $max = array(
                    "height" => 12,
                    "angle" => 10,
                    "radius" => 2
                );
                break;
            case 'TM 1150':
                $max = array(
                    "height" => 12,
                    "angle" => 10,
                    "radius" => 3
                );
                break;

            default:
                # code...
                break;
        }
        return $min;
    }
    function getGross($crane)
    {
        $values = array(
            "maxL" => 0,
            "maxR" => 0,
            "minCapacity" => 0,
            "minL" => 0,
            "minR" => 0,
            "maxCapacity" => 0
        );
        $TABLE = array();
        $maximumRadiusOfCrane = 20;
        switch ($crane) {
            case 'AT 750B':
                $TABLE = array(
                    array(40000, 36300, 31875, 28725, 26500, 24525, 20250, 17050, 13950), // 10.6
                    array(31725, 30975, 29400, 27550, 25125, 23050, 19750, 16875, 13950, 12650, 8385), //12.2
                    array(27050, 26475, 25450, 23800, 22025, 20252, 18075, 15850, 13950, 12425, 10875, 8495), //15.5
                    array(0, 0, 20250, 19825, 19250, 17975, 15475, 13550, 12025, 10750, 9690, 7975, 6580, 3650), //18.2
                    array(0, 0, 0, 0, 16150, 15700, 13973, 12350, 10900, 9740, 8765, 7235, 6030, 5085, 4325), //21.3
                    array(0, 0, 0, 0, 14950, 14300, 12825, 11500, 10375, 9380, 8465, 6965, 5845, 4970, 4235, 3630, 2440), //24.4
                    array(0, 0, 0, 0, 0, 0, 11550, 10600, 9650, 8860, 7985, 6545, 5470, 4640, 3975, 3415, 2935, 2525), //27.4
                    array(0, 0, 0, 0, 0, 0, 10550, 9755, 8910, 8070, 7340, 6140, 5115, 4320, 3585, 3165, 2735, 2370, 2045, 1570), //30.5
                    array(0, 0, 0, 0, 0, 0, 0, 8390, 8060, 7265, 6595, 5530, 4720, 4080, 3480, 2980, 2565, 2210, 1910, 1645, 1410) //33.5
                );
                break;
            case 'TM 1150':
                $TABLE = array(
                    array(
                        110000,
                        104325,
                        91170,
                        82100,
                        73030,
                        60190,
                        49440,
                        41550,
                        35560,
                        30795
                    ), // 13.5
                    array(
                        0,
                        71215,
                        71215,
                        71215,
                        71215,
                        60190,
                        49440,
                        41550,
                        35560,
                        30795,
                        24060

                    ), //15.9
                    array(
                        0,
                        68720,
                        66225,
                        62730,
                        59645,
                        54565,
                        49440,
                        41550,
                        35560,
                        30795,
                        24060,
                        18560,
                        14485

                    ), //18.3
                    array(
                        0,
                        61915,
                        59510,
                        55970,
                        52840,
                        47760,
                        43610,
                        40505,
                        35560,
                        30795,
                        24060,
                        18560,
                        14485,
                        11570

                    ), //20.7
                    array(
                        0,
                        58965,
                        56335,
                        52750,
                        49575,
                        44450,
                        40415,
                        36715,
                        33155,
                        30100,
                        24060,
                        18560,
                        14485,
                        11570,
                        9165

                    ), //23.1
                    array(
                        0,
                        0,
                        0,
                        48535,
                        46265,
                        41100,
                        37050,
                        33800,
                        31050,
                        28700,
                        23850,
                        18560,
                        14485,
                        11570,
                        9165,
                        6640

                    ), //25.6
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        37510,
                        34200,
                        30990,
                        28400,
                        26205,
                        22200,
                        18560,
                        14485,
                        11570,
                        9165,
                        6640

                    ), //28
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        35105,
                        31950,
                        28900,
                        26450,
                        24350,
                        21000,
                        17750,
                        14485,
                        11570,
                        9165,
                        6640,
                        4690

                    ), //30.5
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        30300,
                        2750,
                        25050,
                        22700,
                        20560,
                        17000,
                        14300,
                        12150,
                        10450,
                        9070,
                        6640,
                        4690,
                        3335

                    ), //33
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        20410,
                        20250,
                        18050,
                        15900,
                        14100,
                        12250,
                        10750,
                        7975,
                        5890,
                        4470,
                        3340,
                        2460,
                        1735

                    ), //42.7
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        11340,
                        10125,
                        9060,
                        8050,
                        7145,
                        6350,
                        5340,
                        4400,
                        3720,
                        3060,
                        2520,
                        2050,
                        1630,
                        1230,
                        800,
                        405

                    ) //52.4
                );
                $maximumRadiusOfCrane = 24;
                break;
            case 'RT 755':
                $TABLE = array(
                    array(
                        50000,
                        46175,
                        42135,
                        38370,
                        35060,
                        29640,
                        24830,
                        21135

                    ), // 10.8
                    array(
                        40820,
                        40820,
                        39870,
                        38370,
                        35060,
                        29640,
                        24830,
                        21135,
                        18325,
                        15965

                    ), // 12.2
                    array(
                        37190,
                        37190,
                        37190,
                        37190,
                        35060,
                        29640,
                        24830,
                        21135,
                        19325,
                        15965

                    ), // 13.7
                    array(
                        36400,
                        34605,
                        32790,
                        31090,
                        29230,
                        25580,
                        23040,
                        20815,
                        18325,
                        15965,
                        11460,
                        8390

                    ), // 16.8
                    array(
                        0,
                        30390,
                        28960,
                        27010,
                        25310,
                        22475,
                        19795,
                        17530,
                        15785,
                        15965,
                        11460,
                        8390,
                        6585

                    ), // 19.8
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        19500,
                        17345,
                        15510,
                        14240,
                        12900,
                        10680,
                        8390,
                        6585,
                        5360,
                        4335

                    ), // 22.9
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        17845,
                        16100,
                        14310,
                        12790,
                        11540,
                        9615,
                        8095,
                        6585,
                        5360,
                        4335,
                        3375

                    ), // 25.9
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        12290,
                        11860,
                        10770,
                        9865,
                        8435,
                        7300,
                        6325,
                        5510,
                        4830,
                        4150,
                        3495,
                        2935,
                        2405,
                        1505

                    ), // 33.5
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        9070,
                        8890,
                        8390,
                        7960,
                        7230,
                        6530,
                        5870,
                        5260,
                        4645,
                        4005,
                        3300,
                        2680,
                        2150,
                        1705,
                        1340

                    ), // 35.7
                    array(
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        5575,
                        5055,
                        4465,
                        4055,
                        3675,
                        3320,
                        3020,
                        2705,
                        2410,
                        2125,
                        1930,
                        1665,
                        1330,
                        1045,
                        805,
                        595

                    ) // 43.3
                );
                $maximumRadiusOfCrane = 24;
                break;

            default:
                # code...
                break;
        }
        $radius = $length = 0;
        // max 
        $length = rand(0, (count($TABLE) - 1) / 2);
        $maxR = (count($TABLE[$length]) - 1) / 2;
        $radius = rand(0, $maxR);
        while ($TABLE[$length][$radius] === 0) {
            $radius = rand(0, $maxR);
        }
        $values['minL'] = $this->getLengthFromIndex($length, $crane);
        $values['minR'] = $this->getRadiusFromIndex($radius, $crane);
        $values['maxCapacity'] = $TABLE[$length][$radius];

        // min 
        $rand = rand(0, 1);
        if ($rand === 0) {
            $values['angle'] = $this->calcRangeAngle($values['minR'], 0, $values['minL']);
            $radiusIndex = rand($radius + 1, $maximumRadiusOfCrane);
            $values['maxR'] = $this->getRadiusFromIndex($radiusIndex, $crane);
            $length = $this->getLengthTableValwAngl($values['angle'], $values['maxR'], $crane);
            $values['maxL'] = $length;
            $length = $this->getLengthIndex($length, $crane);
            while ($length === -1 || count($TABLE[$length]) < $radiusIndex + 1 || $TABLE[$length][$radiusIndex] === 0) {
                $radiusIndex = rand($radius + 1, $maximumRadiusOfCrane);
                $values['maxR'] = $this->getRadiusFromIndex($radiusIndex, $crane);
                $length = $this->getLengthTableValwAngl($values['angle'], $values['maxR'], $crane);
                $values['maxL'] = $length;
                $length = $this->getLengthIndex($length, $crane);
            }
        } else {
            $values['height'] = $this->calcRangeHeight($values['minR'], 0, $values['minL']);
            $radiusIndex = rand($radius + 1, $maximumRadiusOfCrane);
            $values['maxR'] = $this->getRadiusFromIndex($radiusIndex, $crane);
            $length = $this->getLengthTableVal($values['height'], $values['maxR'], $crane);
            $values['maxL'] = $length;
            $length = $this->getLengthIndex($length, $crane);
            while ($length === -1 || count($TABLE[$length]) < $radiusIndex + 1 || $TABLE[$length][$radiusIndex] === 0) {
                $radiusIndex = rand($radius + 1, $maximumRadiusOfCrane);
                $values['maxR'] = $this->getRadiusFromIndex($radiusIndex, $crane);
                $length = $this->getLengthTableVal($values['height'], $values['maxR'], $crane);
                $values['maxL'] = $length;
                $length = $this->getLengthIndex($length, $crane);
            }
        }

        $values['minCapacity'] = $TABLE[$length][$radiusIndex];
        return $values;
    }
    function getLengthFromIndex($index, $crane)
    {
        $lengthTable = array();
        switch ($crane) {
            case 'AT 750B':
                $lengthTable = array(10.6, 12.2, 15.5, 18.2, 21.3, 24.4, 27.4, 30.5, 33.5);
                break;
            case 'TM 1150':
                $lengthTable = array(13.5, 15.9, 18.3, 20.7, 23.1, 25.6, 28, 30.5, 33, 42.7, 52.4);
                break;
            case 'RT 755':
                $lengthTable = array(10.8, 12.2, 13.7, 16.8, 19.8, 22.9, 25.9, 33.5, 35.7, 43.3);
                break;

            default:
                # code...
                break;
        }
        return $lengthTable[$index];
    }
    function getRadiusFromIndex($index, $crane)
    {
        $radiusTable = array();
        switch ($crane) {
            case 'AT 750B':
                $radiusTable = array(2.75, 3, 3.5, 4, 4.5, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30);
                break;
            case 'TM 1150':
                $radiusTable = array(3, 3.5, 4, 4.5, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18, 20, 23, 26, 29, 32, 35, 38, 41, 44, 47, 50);
                break;
            case 'RT 755':
                $radiusTable = array(3, 3.5, 4, 4.5, 5, 6, 7, 8, 9, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40);
                break;

            default:
                # code...
                break;
        }

        return $radiusTable[$index];
    }
}
