<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\Response;

class JasperController extends Controller
{
    static $reports = ["expense"=>"expense"];
    static function read_files($path){
        $files = [];
        foreach (new \DirectoryIterator($path) as $file) {
            if ($file->isFile()) {
                $files[$file->getFilename()] = $path."\\".$file->getFilename();
            }
        }
        return $files;
    }
    static function UpdateReports(){
        $reports = JasperController::read_files(storage_path('app\report\source\MyReports\src'));
        foreach($reports as $key=>$report){
            JasperController::compile($report);
        }
    }
    static function compile($input){
        $output = storage_path('app\report\compiled');    
        $jasper = new PHPJasper;
        $jasper->compile($input,$output)->execute();
    }
    static function dir_check($path){
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }
    static function pdf($path,$filename){
        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    static function jasper($input,$output,$options,$template){
        $jasper = new PHPJasper;
        $resp = $jasper->process(
            $input,
            $output,
            $options
        )->execute();
        $pdf = $template.'.pdf';
        if($resp == []){
            return JasperController::pdf($output.'\\'.$pdf,$pdf);
        }
    }
    public function report($report){
        // $report = $report;
        $src = storage_path('app\report\source\MyReports\src');
        $reports = JasperController::read_files($src);

        if(!isset($reports[$report.".jrxml"])){
            abort(404, 'Unauthorized action.');
            return false;
        }

        // dd($reports,$template);
        $user = auth()->user();
        $user_id = $user->id;
        $business_id = $user->business_id;

        $input = storage_path('app\report\compiled').'\\'.$report.'.jasper';  
        $output = JasperController::dir_check(storage_path('app\report\output')."\business_".$business_id."\user_".$user_id);  
        $options = [
            "format" => ["pdf"],
        ];
        switch($report){
            case "expense":{
                return JasperController::hello_world($input,$output,$options,$report,$user);
            }break;
            case "hello_world":{
                return JasperController::hello_world($input,$output,$options,$report,$user);
            }break;
        }
        
    }
    //reports -----------------------------------------------------------
    static function hello_world($input,$output,$options,$template,$user){
        // $options["format"] =[ "pdf"];
        return JasperController::jasper($input,$output,$options,$template);
    }
}

