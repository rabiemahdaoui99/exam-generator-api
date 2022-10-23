<?php

namespace App\Models;

class HandSignal
{
    private $quizFakeAnswers;
    private $quizAnswer;
    private $quizImage;
    public static $handSignalsText = array(
        "Use main hoist",
        "Use auxiliary hoist",
        "Raise boom",
        "Lower boom",
        "Raise hoist",
        "Raise hoist slowly",
        "Lower hoist",
        "Lower hoist slowly",
        "Extend boom",
        "Retract boom",
        "Extend boom one hand",
        "Retract boom one hand",
        "Lower boom & raise hoist",
        "Raise boom & lower hoist",
        "Stop",
        "Swing",
        "Dog everything"
    );
    function __construct()
    {
    }
    function generateHandSignal()
    {
        $answerIndex = rand(0, count(self::$handSignalsText) - 1);
        $this->quizAnswer = self::$handSignalsText[$answerIndex];
        array_splice(self::$handSignalsText, $answerIndex, 1);
        $this->quizFakeAnswers = array();
        $fakeSignals = array(
            "Use main hoist",
            "Use auxiliary hoist",
            "Raise boom",
            "Lower boom",
            "Raise hoist",
            "Raise hoist slowly",
            "Lower hoist",
            "Lower hoist slowly",
            "Extend boom",
            "Retract boom",
            "Extend boom one hand",
            "Retract boom one hand",
            "Lower boom & raise hoist",
            "Raise boom & lower hoist",
            "Stop",
            "Swing",
            "Dog everything"
        );
        $index = array_search($this->quizAnswer, $fakeSignals);
        $path = asset('/images/handSignals/' . $index . '.png');
        $this->quizImage = $path;
        array_splice($fakeSignals, $index, 1);
        for ($i = 0; $i < 3; $i++) {
            $answerIndex = rand(0, count($fakeSignals) - 1);
            $fakeAnswer = $fakeSignals[$answerIndex];
            array_push($this->quizFakeAnswers, $fakeAnswer);
            array_splice($fakeSignals, $answerIndex, 1);
        }

        return array(
            "id" => 0,
            "quizQuestion" => 'What does this sign mean?.',
            "quizImage" => $this->quizImage,
            "quizAnswer" => $this->quizAnswer,
            "quizFakeAnswers" => $this->quizFakeAnswers
        );
    }
}
