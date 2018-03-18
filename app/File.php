<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class File extends Model
{
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['id'];

    /**
     * Creates a spreadsheet
     *
     * @param  array  $csv_array
     * @return obj
     */
    public function createSpreadSheet(array $csv_array)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray(
            $csv_array,
            null,
            'A1'
        );

        $writer = new Xlsx($spreadsheet, 'Xls');

        return $writer;
    }
}
