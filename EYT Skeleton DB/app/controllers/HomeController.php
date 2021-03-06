<?php

use \Chumper\Zipper\Zipper;

class HomeController extends BaseController
{
    public function homePage()
    {
        $tests     = App::make('perms');
        $testNames = array();

        foreach ($tests as $test) {
            if (!isset($testNames[$test->test_name])) {
                $testNames[str_replace("+", "%20", urlencode($test->test_name))] = $test;
            }
        }

        return View::make("home", array(
            "tests" => $testNames
        ));
    }

    public function makeCSV($test_name = '', $start = '', $end = '')
    {
        $zip_file  = date("U") . ".zip";
        $zip_path  = public_path() . "/tmp/";
        $zipper    = new Zipper();
        $csv_files = array();
        $games     = array(
            new CardSortController(),
            new FishSharkController(),
            new MrAntController(),
            new NotThisController(),
            new VocabController()
        );

        $zipper->make($zip_path . $zip_file)->folder("GameData");

        foreach ($games as $game) {
            $csv_files[] = $game->makeCSV($test_name, $start, $end, true);
        }

        foreach ($csv_files as $filename) {
            $zipper->add(public_path() . "/tmp/" . $filename);
        }

        $zipper->close();

        return View::make("download", array(
            "url" => "/tmp/" . $zip_file
        ));
    }

    public function supportPage()
    {
        return View::make("support");
    }
}