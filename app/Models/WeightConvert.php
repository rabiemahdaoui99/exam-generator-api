<?php

namespace App\Models;

class WeightConvert
{
    private $minWeight;
    private $maxWeight;
    private $convertFrom;
    private $convertTo;
    private $quizQuestion;
    private $quizFakeAnswers;
    private $quizQuestionNumber;
    private $quizAnswerNumber;
    function __construct($minW = 2500, $maxW = 37500)
    {
        $this->minWeight = $minW;
        $this->maxWeight = $maxW;
    }
    function generateWeigthQuiz()
    {
        $keys = array("KG", "LSB", "TON");
        $this->convertFrom = $keys[array_rand($keys, 1)];
        switch ($this->convertFrom) {
            case "KG":
                if (rand(0, 1)) {
                    $this->convertTo = "LSB";
                    $this->quizQuestionNumber = rand($this->minWeight, $this->maxWeight);
                    $this->quizAnswerNumber = round($this->quizQuestionNumber * 2.2);
                    $this->quizQuestion = 'How many ' . $this->convertTo . ' is (' . $this->quizQuestionNumber . ')' . $this->convertFrom . ' . Do any calculations in this space.';
                    $this->quizFakeAnswers = array(
                        $this->quizQuestionNumber * 2,
                        round($this->quizQuestionNumber * 2.4),
                        round($this->quizQuestionNumber * 2.1)
                    );
                } else {
                    $this->convertTo = "TON";
                    $this->quizQuestionNumber = rand($this->minWeight, $this->maxWeight);
                    $this->quizAnswerNumber = round($this->quizQuestionNumber / 1000, 2);
                    $this->quizQuestion = 'How many ' . $this->convertTo . ' is (' . $this->quizQuestionNumber . ')' . $this->convertFrom . ' . Do any calculations in this space.';
                    $this->quizFakeAnswers = array(
                        round($this->quizQuestionNumber / 100, 2),
                        round($this->quizQuestionNumber / 10000, 2),
                        round($this->quizQuestionNumber / 2200, 2)
                    );
                }
                break;

            case "LSB":
                if (rand(0, 1)) {
                    $this->convertTo = "KG";
                    $this->quizQuestionNumber = rand($this->minWeight * 2.2, $this->maxWeight * 2.2);
                    $this->quizAnswerNumber = round($this->quizQuestionNumber / 2.2, 2);
                    $this->quizQuestion = 'How many ' . $this->convertTo . ' is (' . $this->quizQuestionNumber . ')' . $this->convertFrom . ' . Do any calculations in this space.';
                    $this->quizFakeAnswers = array(
                        round($this->quizQuestionNumber / 2, 2),
                        round($this->quizQuestionNumber / 2.4, 2),
                        round($this->quizQuestionNumber / 2.1, 2)
                    );
                } else {
                    $this->convertTo = "TON";
                    $this->quizQuestionNumber = rand($this->minWeight * 2.2, $this->maxWeight * 2.2);
                    $this->quizAnswerNumber = round($this->quizQuestionNumber / 2200, 2);
                    $this->quizQuestion = 'How many ' . $this->convertTo . ' is (' . $this->quizQuestionNumber . ')' . $this->convertFrom . ' . Do any calculations in this space.';
                    $this->quizFakeAnswers = array(
                        round($this->quizQuestionNumber / 2000, 2),
                        round($this->quizQuestionNumber / 2400, 2),
                        round($this->quizQuestionNumber / 1000, 2)
                    );
                }
                break;

            case "TON":
                if (rand(0, 1)) {
                    $this->convertTo = "LSB";
                    $this->quizQuestionNumber = rand($this->minWeight / 1000, $this->maxWeight / 1000);
                    $this->quizAnswerNumber = round($this->quizQuestionNumber * 2200);
                    $this->quizQuestion = 'How many ' . $this->convertTo . ' is (' . $this->quizQuestionNumber . ')' . $this->convertFrom . ' . Do any calculations in this space.';
                    $this->quizFakeAnswers = array(
                        $this->quizQuestionNumber * 2000,
                        $this->quizQuestionNumber * 2400,
                        $this->quizQuestionNumber * 1000
                    );
                } else {
                    $this->convertTo = "KG";
                    $this->quizQuestionNumber = rand($this->minWeight / 1000, $this->maxWeight / 1000);
                    $this->quizAnswerNumber = round($this->quizQuestionNumber * 1000);
                    $this->quizQuestion = 'How many ' . $this->convertTo . ' is (' . $this->quizQuestionNumber . ')' . $this->convertFrom . ' . Do any calculations in this space.';
                    $this->quizFakeAnswers = array(
                        $this->quizQuestionNumber * 100,
                        $this->quizQuestionNumber * 10000,
                        $this->quizQuestionNumber * 2200
                    );
                }
                break;

            default:
                break;
        }
        return array(
            "id" => 0,
            "convertFrom" => $this->convertFrom,
            "convertTo" => $this->convertTo,
            "quizQuestion" => $this->quizQuestion,
            "quizQuestionNumber" => $this->quizQuestionNumber,
            "quizAnswerNumber" => $this->quizAnswerNumber,
            "quizFakeAnswers" => $this->quizFakeAnswers
        );
    }
}
