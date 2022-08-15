<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataSpreadsheet {

    protected $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    protected $spreadsheet;
     
     public function __construct( $xslx ){
        $this->spreadsheet = $xslx;
     }

    // $data : array, $cell : string
     public function add_new_data_spreadsheet( $data, $cell ){
        
        $sheet = $this->spreadsheet->getActiveSheet();
        $count = 0;
        
        try{

            foreach ($data as $key => $val) {
                
                $sheet->setCellValue( $this->cols[ $count ] . ( $cell + 1 ), $val );
                $count++;
            }

            // Write a new .xlsx file
            $writer = new Xlsx($this->spreadsheet);
            // Save the new .xlsx file
            $writer->save('clientes.xlsx');
        }
        catch(\Exception $e){
            return 0;
        }

        return 1;

    }

    // return last row
    public function get_last_row(){
        return $this->spreadsheet->getActiveSheet()->getHighestRow();
    }
}