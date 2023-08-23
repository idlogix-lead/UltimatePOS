<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>
<body>
    <div style="width:100%;line-height: 1;">
        <!-- <div class="" style="text-align:right;">
            <span style="text-align:left;"></span>
            <span ></span>
        </div> -->
        <table style="width:100%;border:0px solid #ddd;">
            <tr>
                <td style="text-align:left;border:0px solid #ddd;"><label for="">Printed By: </label> {{$data["user"]}}</td>
                <td style="text-align:right;border:0px solid #ddd;"><label for="">Date Range: </label> 
                    @if (isset($data["start_date"]) && $data["end_date"])
                        {{date($data["date_format"],strtotime($data["start_date"]))}} - {{date($data["date_format"],strtotime($data["end_date"]))}}
                    @else
                        No Date Range Selected
                    @endif
                </td>
            </tr>
        </table>
        
        <div style="text-align:center;">
            <h2><label for="">Business: </label>{{$data["name"]}}</h2>
            <h4><label for="">Location: </label>{{$data["location"]["name"]}}({{$data["location"]["location_id"]}})</h4>
        </div>
    </div>
