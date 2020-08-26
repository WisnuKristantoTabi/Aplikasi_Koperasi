<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class DataAnggota implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $rows)
    {
        $data = array();
        //echo ;
        foreach ($rows as $no => $row) {

            //array_push($data,$row);
            //print_r($rows);
            //echo "<br><br>";
            echo $row;
            echo "<br>";
            echo "nomor".$no;
            echo "<br><br>";
            //echo $row[3];
            //echo "<br>";

        }
        //print_r($rows);


        /*foreach ($data as $value) {
            echo $value;
            echo "<br>";
        }*/


    }
}
