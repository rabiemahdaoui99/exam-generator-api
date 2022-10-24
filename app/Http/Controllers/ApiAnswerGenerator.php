<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightConvert;
use App\Models\Range;
use App\Models\PartOfLine;
use App\Models\HandSignal;
use App\Models\Rcl;
use Illuminate\Support\Facades\Response;

class ApiAnswerGenerator extends Controller
{
    public function getWeights($numberOfQuestions = 20)
    {
        $w = new WeightConvert;
        $quizWeights = array();
        for ($i = 0; $i < $numberOfQuestions; $i++) {
            $weight = $w->generateWeigthQuiz();
            $weight["id"] = $i + 1;
            array_push($quizWeights, $weight);
        }
        return $quizWeights;
    }
    public function getRanges($numberOfQuestions = 20)
    {
        $R = new Range;
        $quizRanges = array();
        for ($i = 0; $i < $numberOfQuestions; $i++) {
            $range = $R->generateRnge();
            $range["id"] = $i + 1;
            array_push($quizRanges, $range);
        }
        return $quizRanges;
    }
    public function getPartOfLines($numberOfQuestions = 20)
    {
        $PoL = new PartOfLine;
        $quizPols = array();
        for ($i = 0; $i < $numberOfQuestions; $i++) {
            $partOfLine = $PoL->generatePoL();
            $partOfLine["id"] = $i + 1;
            array_push($quizPols, $partOfLine);
        }
        return $quizPols;
    }
    public function getHandSignals($numberOfQuestions = 17)
    {
        if ($numberOfQuestions > 17) $numberOfQuestions = 17;
        $HS = new HandSignal;
        $quizSignals = array();
        for ($i = 0; $i < $numberOfQuestions; $i++) {
            $Signal = $HS->generateHandSignal();
            $Signal["id"] = $i + 1;
            array_push($quizSignals, $Signal);
        }
        return $quizSignals;
    }
    public function getRcls($quizKey = "total-weight", $numberOfQuestions = 20)
    {
        $rcl = new Rcl;
        $quizKey = str_replace("-", " ", $quizKey);
        $quizRcls = array();
        for ($i = 0; $i < $numberOfQuestions; $i++) {
            $quiz = $rcl->generateRcl($quizKey);
            $quiz["id"] = $i + 1;
            array_push($quizRcls, $quiz);
        }
        return $quizRcls;
    }
    public function signalImage($fileName)
    {
        $path = asset('/images/handSignals/' . $fileName);
        return $path;
    }
    public function rclImage($fileName)
    {
        $path = asset('/images/rcl/' . $fileName);
        return '<img src="' . $path . '" />';
    }
}
