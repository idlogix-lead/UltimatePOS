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
    static function UpdateReports($file = ""){
        if($file != ""){
            $path = storage_path('app\report\source\MyReports\src');
            $file .= ".jrxml";
            $file = $path."\\".$file;
            if (file_exists($file)) {
                JasperController::compile($file);
                return "Build Successfully!";
            }else{
                return "Sorry! no Report file Found in ". $path;
            }
        }else{
            $reports = JasperController::read_files($path);
            foreach($reports as $key=>$report){
                JasperController::compile($report);
            }
            return "All Reports Build Successfully!";
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
    static function html($path,$filename){
        $content = file_get_contents($path);
        return view("report.jasper.preview")->with('preview',$content);
    }
    static function jasper($input,$output,$options,$template,$ext){
        $jasper = new PHPJasper;
        $resp = $jasper->process(
            $input,
            $output,
            $options
        )->execute();
        $filename = $template.'.'.$ext;
        if($resp == []){
            switch ($ext){
                case "pdf":
                    return JasperController::pdf($output.'\\'.$filename,$filename);
                    break;
                case "html":
                    return JasperController::html($output.'\\'.$filename,$filename);
                    break;

            }
        }
    }
    public static function report($report,$ext = "pdf"){
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
            'locale' => 'en',
            'db_connection' => [
                'driver' => env('DB_CONNECTION'),
                'username' => env('DB_USERNAME'),
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'port' => env('DB_PORT')
            ]
        ];
        if(env('DB_PASSWORD') != null ||  env('DB_PASSWORD') != ""){
            $options["db_connection"]["password"] = env('DB_PASSWORD');
        }
        // dd($options);
        switch($report){
            case "expense":{
                return JasperController::expense($input,$output,$options,$report,$ext,$user);
            }break;
            case "hello_world":{
                return JasperController::hello_world($input,$output,$options,$report,$ext,$user);
            }break;
        }
        
    }
    //reports -----------------------------------------------------------
    static function hello_world($input,$output,$options,$template,$ext,$user){
        // $options["format"] =[ "pdf"];
        // $ext = "pdf";
        return JasperController::jasper($input,$output,$options,$template,$ext);
    }
    static function expense($input,$output,$options,$template,$ext,$user){
        $start_date = isset($_GET["start_date"])?$_GET["start_date"]:date('Y-m-d');
        $end_date = isset($_GET["end_date"])?$_GET["end_date"]:date("Y-m-d");
        // $ext = "html";
        $options["params"] =[ 
            "business_id" => $user->business_id,
            "start_date" => $start_date,
            "end_date" => $end_date,
        ];
        $options["format"] = [$ext];
        // dd($options);
        return JasperController::jasper($input,$output,$options,$template,$ext);
    }
    //for report testing console
    static function console(){
        $in = "E:\\xampp8.2\htdocs\UltimatePOS\storage\app\\report\compiled\\expense.jasper";
        $out = "E:\\xampp8.2\htdocs\UltimatePOS\storage\app\\report\output\business_1\user_1";
        $op = [
            "format" => ["pdf"],
            'locale' => 'en',
            'params' => ["business_id" => 1],
            'db_connection' => [
                'driver' => env('DB_CONNECTION'),
                'username' => env('DB_USERNAME'),
                'host' => env('DB_HOST'),
                'database' => env('DB_DATABASE'),
                'port' => env('DB_PORT')
            ]
        ];
        $tp = "expense";
        $jasper = new PHPJasper;
        return Response::json($jasper->process(
            $in,
            $out,
            $op
        )->execute());
    }
}

