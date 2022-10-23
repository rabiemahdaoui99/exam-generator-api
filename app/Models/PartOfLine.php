<?php

namespace App\Models;

class PartOfLine
{
    private $quizQuestionweight;
    private $quizQuestion;
    private $quizFakeAnswers;
    private $quizQuestionGrove;
    private $quizAnswerNumber;
    function __construct()
    {
    }
    function generatePoL()
    {
        $groves = ["AT 750B", "RT 755", "TM 1150"];
        $this->quizQuestionGrove = $groves[array_rand($groves, 1)];
        $this->quizQuestionweight = rand(10, 100); // in TON
        $this->quizFakeAnswers = array();
        $unit = "";
        switch ($this->quizQuestionGrove) {
            case "AT 750B":
                $rand = rand(0, 2);
                if ($rand == 0) {
                    $unit = "TON";
                    $this->quizAnswerNumber = intval($this->quizQuestionweight / 5.86);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 6.85),
                        intval($this->quizQuestionweight / 9.166),
                        intval($this->quizQuestionweight / 6.25)
                    );
                } elseif ($rand == 1) {
                    $unit = "KG";
                    $this->quizAnswerNumber = intval($this->quizQuestionweight / 5.86);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 6.85),
                        intval($this->quizQuestionweight / 9.166),
                        intval($this->quizQuestionweight / 6.25)
                    );
                    $this->quizQuestionweight *= 1000;
                } else {
                    $unit = "LSB";
                    $this->quizAnswerNumber = intval($this->quizQuestionweight / 5.86);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 6.85),
                        intval($this->quizQuestionweight / 9.166),
                        intval($this->quizQuestionweight / 6.25)
                    );
                    $this->quizQuestionweight *= 2200;
                }
                break;
            case "RT 755":
                $rand = rand(0, 2);
                if ($rand == 0) {
                    $unit = "TON";
                    $this->quizAnswerNumber = ceil($this->quizQuestionweight / 6.25);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 5.86),
                        intval($this->quizQuestionweight / 9.166),
                        intval($this->quizQuestionweight / 5.26)
                    );
                } elseif ($rand == 1) {
                    $unit = "KG";
                    $this->quizAnswerNumber = ceil($this->quizQuestionweight / 6.25);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 5.86),
                        intval($this->quizQuestionweight / 9.166),
                        intval($this->quizQuestionweight / 5.26)
                    );
                    $this->quizQuestionweight *= 1000;
                } else {
                    $unit = "LSB";
                    $this->quizAnswerNumber = ceil($this->quizQuestionweight / 6.25);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 5.86),
                        intval($this->quizQuestionweight / 9.166),
                        intval($this->quizQuestionweight / 5.26)
                    );
                    $this->quizQuestionweight *= 2200;
                }
                break;
            case "TM 1150":
                $rand = rand(0, 2);
                if ($rand == 0) {
                    $unit = "TON";
                    $this->quizAnswerNumber = intval($this->quizQuestionweight / 9.166);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 5.85),
                        intval($this->quizQuestionweight / 6.199),
                        intval($this->quizQuestionweight / 6.25)
                    );
                } elseif ($rand == 1) {
                    $unit = "KG";
                    $this->quizAnswerNumber = intval($this->quizQuestionweight / 9.166);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 5.85),
                        intval($this->quizQuestionweight / 6.199),
                        intval($this->quizQuestionweight / 6.25)
                    );
                    $this->quizQuestionweight *= 1000;
                } else {
                    $unit = "LSB";
                    $this->quizAnswerNumber = intval($this->quizQuestionweight / 9.166);
                    array_push(
                        $this->quizFakeAnswers,
                        intval($this->quizQuestionweight / 5.85),
                        intval($this->quizQuestionweight / 6.199),
                        intval($this->quizQuestionweight / 6.25)
                    );
                    $this->quizQuestionweight *= 2200;
                }
                break;

            default:
                # code...
                break;
        }
        $this->quizQuestion = "Using the grove (" . $this->quizQuestionGrove . ")load chart . how many parts of line are needed to lift (" . $this->quizQuestionweight . " " . $unit . ") .";
        $this->quizFakeAnswers = $this->getDistinctAnswers(
            $this->quizAnswerNumber,
            $this->quizFakeAnswers
        );
        return array(
            "id" => 0,
            "quizQuestion" => $this->quizQuestion,
            "quizQuestionGrove" => $this->quizQuestionGrove,
            "quizQuestionweight" => $this->quizQuestionweight,
            "quizQuestionweightUnit" => $unit,
            "quizAnswerNumber" => $this->quizAnswerNumber,
            "quizFakeAnswers" => $this->quizFakeAnswers
        );
    }
    private function getDistinctAnswers($answer, $fakeAnswers)
    {
        $allAnswers = $fakeAnswers;
        array_push($allAnswers, $answer);

        while (count(array_unique($allAnswers)) != 4) {
            $isAnswerDuplicated = array_search($answer, $fakeAnswers);
            if ($isAnswerDuplicated === false) {
                $fakeAnswers = array_unique($fakeAnswers);
                $avg = array_sum($fakeAnswers) / 2;
                if (count($fakeAnswers) > 1)
                    $fakeAnswers[2] = rand($avg, $avg + 5);
                if (count($fakeAnswers) == 1) {
                    $fakeAnswers[1] = rand($avg, $avg + 5);
                    $fakeAnswers[2] = rand($avg, $avg + 5);
                }
            } else {
                $fakeAnswers[$isAnswerDuplicated] = $fakeAnswers[$isAnswerDuplicated] < 5 ?
                    rand($fakeAnswers[$isAnswerDuplicated] + 1, $fakeAnswers[$isAnswerDuplicated] + 6) :
                    rand($fakeAnswers[$isAnswerDuplicated] - 2, $fakeAnswers[$isAnswerDuplicated] + 6);
            }
            $allAnswers = $fakeAnswers;
            array_push($allAnswers, $answer);
        }
        return $fakeAnswers;
    }
}
