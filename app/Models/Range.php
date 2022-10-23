<?php

namespace App\Models;

class Range
{
    private $quizTitle;
    private $quizQuestion;
    private $quizFakeAnswers;
    private $quizQuestionGrove;
    private $quizAnswerNumber;
    private $quizQuestionKeys;
    function __construct()
    {
    }
    function generateRnge()
    {
        $groves = array("AT 750B", "RT 755", "TM 1150");
        $this->quizQuestionGrove = $groves[array_rand($groves, 1)];
        $keys = array(
            "length",
            "top height",
            "angle",
            "radius",
            "hook elevation"
        );
        $this->quizQuestion = $keys[array_rand($keys, 1)];
        $this->quizTitle = "Using the grove (" . $this->quizQuestionGrove . ") Range Diagram.";
        switch ($this->quizQuestion) {
            case "length":
                $dataNum1 = rand(8, 44);
                $data1 = "radius";
                if (rand(0, 1)) {
                    $data2 = "top height";
                    $dataNum2 = rand(10, 50);
                    $this->quizAnswerNumber = $this->calcRangeLength($dataNum1, $dataNum2, 0);
                } else {
                    $data2 = "angle";
                    $dataNum2 = rand(10, 71);
                    $this->quizAnswerNumber = $this->calcRangeLength($dataNum1, 0, $dataNum2);
                }
                $this->quizQuestionKeys = array($data1 => $dataNum1, $data2 => $dataNum2);
                break;
            case "top height":
                $dataNum1 = rand(8, 20);
                $data1 = "radius";
                if (rand(0, 1)) {
                    $data2 = "length";
                    $dataNum2 = rand(21, 44);
                    $this->quizAnswerNumber = $this->calcRangeHeight($dataNum1, 0, $dataNum2);
                } else {
                    $data2 = "angle";
                    $dataNum2 = rand(10, 71);
                    $this->quizAnswerNumber = $this->calcRangeHeight($dataNum1, $dataNum2, 0);
                }
                $this->quizQuestionKeys = array($data1 => $dataNum1, $data2 => $dataNum2);
                break;
            case "angle":
                $dataNum1 = rand(8, 20);
                $data1 = "radius";
                if (rand(0, 1)) {
                    $data2 = "top height";
                    $dataNum2 = rand(21, 50);
                    $this->quizAnswerNumber = $this->calcRangeAngle($dataNum1, $dataNum2, 0);
                } else {
                    $data2 = "length";
                    $dataNum2 = rand(11, 40);
                    $this->quizAnswerNumber = $this->calcRangeAngle($dataNum1, 0, $dataNum2);
                }
                $this->quizQuestionKeys = array($data1 => $dataNum1, $data2 => $dataNum2);
                break;
            case "radius":
                $dataNum1 = rand(10, 71);
                $data1 = "angle";
                if (rand(0, 1)) {
                    $data2 = "top height";
                    $dataNum2 = rand(10, 50);
                    $this->quizAnswerNumber = $this->calcRangeRadius($dataNum1, $dataNum2, 0);
                } else {
                    $data2 = "length";
                    $dataNum2 = rand(11, 40);
                    $this->quizAnswerNumber = $this->calcRangeRadius($dataNum1, 0, $dataNum2);
                }
                $this->quizQuestionKeys = array($data1 => $dataNum1, $data2 => $dataNum2);
                break;
            case "hook elevation":
                $dataNum1 = rand(8, 44);
                $data1 = "Radius";
                if (rand(0, 1)) {
                    $data2 = "length";
                    $dataNum2 = rand(11, 40);
                    $this->quizAnswerNumber = rand(10, 40);
                } else {
                    $data2 = "angle";
                    $dataNum2 = rand(10, 71);
                    $this->quizAnswerNumber = rand(10, 40);
                }
                // if (rand(0, 1)) {
                //     $data2 = "length";
                //     $dataNum2 = rand(21, 44);
                //     $this->quizAnswerNumber = $this->calcRangeHeight($dataNum1, 0, $dataNum2) - 6;
                // } else {
                //     $data2 = "angle";
                //     $dataNum2 = rand(10, 71);
                //     $this->quizAnswerNumber = $this->calcRangeHeight($dataNum1, $dataNum2, 0) - 6;
                // }
                $this->quizQuestionKeys = array($data1 => $dataNum1, $data2 => $dataNum2);
                break;
            default:

                break;
        }
        $this->quizFakeAnswers = array();
        if ($this->quizAnswerNumber > 15) {
            $minNum = $this->quizAnswerNumber - 5;
            $maxNum = $this->quizAnswerNumber + 5;
        } else {
            $minNum = $this->quizAnswerNumber;
            $maxNum = $this->quizAnswerNumber + 10;
        }

        while (count($this->quizFakeAnswers) < 3) {
            $rand = rand(intval($minNum), intval($maxNum));
            if (array_search($rand, $this->quizFakeAnswers) === false && $rand != $this->quizAnswerNumber)
                array_push($this->quizFakeAnswers, $rand);
        }

        $this->quizQuestion = "What is the " . $this->quizQuestion . " ?";
        return array(
            "id" => 0,
            "quizTitle" => $this->quizTitle,
            "quizQuestionGrove" => $this->quizQuestionGrove,
            "quizQuestionKeys" => $this->quizQuestionKeys,
            "quizQuestion" => $this->quizQuestion,
            "quizAnswerNumber" => $this->quizAnswerNumber,
            "quizFakeAnswers" => $this->quizFakeAnswers
        );
    }
    function calcRangeAngle($radius, $height = 0, $length = 0)
    {
        if ($height) {
            return intval(rad2deg(atan($height / $radius)));
        }
        if ($length) {
            return intval(rad2deg(acos($radius / $length)));
        }
        return 0;
    }
    function calcRangeHeight($radius, $angle = 0, $length = 0)
    {
        if ($angle) {
            return intval($radius * tan(deg2rad($angle)));
        }
        if ($length) {
            return intval(sqrt(pow($length, 2) - pow($radius, 2)));
        }
        return 0;
    }
    function calcRangeLength($radius, $height = 0, $angle = 0)
    {
        if ($height) {
            return intval(sqrt($radius * $radius + $height * $height));
        }
        if ($angle) {
            return intval($radius / cos(deg2rad($angle)));
        }
        return 0;
    }
    function calcRangeRadius($angle, $height = 0, $length = 0)
    {
        if ($height) {
            return intval($height / tan(deg2rad($angle)));
        }
        if ($length) {
            return intval(cos(deg2rad($angle)) * $length);
        }
        return 0;
    }
}
