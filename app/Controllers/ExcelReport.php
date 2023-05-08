<?php

namespace App\Controllers;

use App\Models\OfficeModel;
use App\Models\ReportAllModel;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\EventHistoryModel;
use App\Models\EventActivityModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

use Config\Services;

class ExcelReport extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->officeModel = new OfficeModel($this->request);
        $this->userModel = new UserModel($this->request);
        $this->reportAllModel = new ReportAllModel($this->request);
        $this->eventModel = new EventModel($this->request);
        $this->eventHistoryModel = new EventHistoryModel($this->request);
        $this->eventActivityModel = new EventActivityModel($this->request);

        $this->session = session();
        $this->data_session = array(
            "title" => $this->session->get('name') . " -  " . $this->session->get('rolename'),
            "id" => $this->session->get('id'),
            "name" => $this->session->get('name'),
            "rolecode"=> $this->session->get('rolecode'),
        );
    }
    public function lpj_activity($officeid,$statusEvent,$category,$tahun,$bulan)
    {

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '100000M');
        $data = $this->eventModel->excelReport($officeid,$statusEvent,$category,$tahun,$bulan);

        $spreadsheet = new Spreadsheet();

        /**
         * $1 : office id
         * $2 : status event
         * $3 : category event
         * $4 : tahun event
         * $5 : bulan event 
         */

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "Rekap Laporan Pertanggung Jawaban Activity Pameran 5055");
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:N1')->getFont()->setBold( true );

        $sheet->setCellValue('A2', "Dealer");
        $sheet->mergeCells('A2:C2');
        $sheet->getStyle('A2:C2')->getFont()->setBold( true );

        $sheet->setCellValue('D2', ": All Dealer");
        $sheet->mergeCells('D2:F2');
        $sheet->getStyle('D2:F2')->getFont()->setBold( true );

        $sheet->setCellValue('A3', "Area");
        $sheet->mergeCells('A3:C3');
        $sheet->getStyle('A3:C3')->getFont()->setBold( true );

        $sheet->setCellValue('D3', ": All Area");
        $sheet->mergeCells('D3:F3');
        $sheet->getStyle('D3:F3')->getFont()->setBold( true );


        $sheet->setCellValue('A4', "Bulan");
        $sheet->mergeCells('A4:C4');
        $sheet->getStyle('A4:C4')->getFont()->setBold( true );

        $sheet->setCellValue('D4', ": ".date('F:Y'));
        $sheet->mergeCells('D4:F4');
        $sheet->getStyle('D4:F4')->getFont()->setBold( true );


        // tulis header/nama kolom 
        $sheetNo =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', 'No');
        $sheetNo->mergeCells('A5:A7');
        $sheetNo->getStyle('A5:A7')->getAlignment()->setHorizontal('center');
        $sheetNo->getStyle('A5:A7')->getAlignment()->setVertical('center');
        $sheetNo->getStyle('A5:A7')->getFont()->setBold( true );
        
        $sheetPeriode = $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', 'Periode');
        $sheetPeriode->mergeCells('B5:C6');
        $sheetPeriode->getStyle('B5:C6')->getAlignment()->setHorizontal('center');
        $sheetPeriode->getStyle('B5:C6')->getAlignment()->setVertical('center');
        $sheetPeriode->getStyle('B5:C6')->getFont()->setBold( true );

        $sheetStart= $spreadsheet->setActiveSheetIndex(0)->setCellValue('B7', 'Mulai');
        $sheetStart->getStyle('B7')->getAlignment()->setHorizontal('center');
        $sheetStart->getStyle('B7')->getAlignment()->setVertical('center');
        $sheetStart->getStyle('B7')->getFont()->setBold( true );

        $sheetEnd= $spreadsheet->setActiveSheetIndex(0)->setCellValue('C7', 'Berakhir');
        $sheetEnd->getStyle('C7')->getAlignment()->setHorizontal('center');
        $sheetEnd->getStyle('C7')->getAlignment()->setVertical('center');
        $sheetEnd->getStyle('C7')->getFont()->setBold( true );


        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('D5', 'Durasi (hari)');
        $sheetDuration->mergeCells('D5:D7');
        $sheetDuration->getStyle('D5:D7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('D5:D7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('D5:D7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', 'Kategori');
        $sheetDuration->mergeCells('E5:E7');
        $sheetDuration->getStyle('E5:E7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('E5:E7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('E5:E7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('F5', 'Event Name');
        $sheetDuration->mergeCells('F5:F7');
        $sheetDuration->getStyle('F5:F7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('F5:F7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('F5:F7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('G5', 'Kode Dealer');
        $sheetDuration->mergeCells('G5:G7');
        $sheetDuration->getStyle('G5:G7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('G5:G7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('G5:G7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('H5', 'Nama Dealer');
        $sheetDuration->mergeCells('H5:H7');
        $sheetDuration->getStyle('H5:H7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('H5:H7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('H5:H7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('I5', 'Lokasi');
        $sheetDuration->mergeCells('I5:I7');
        $sheetDuration->getStyle('I5:I7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('I5:I7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('I5:I7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('J5', 'Status Event');
        $sheetDuration->mergeCells('J5:J7');
        $sheetDuration->getStyle('J5:J7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('J5:J7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('J5:J7')->getFont()->setBold( true );


        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('K5', 'Jumlah Pengunjung');
        $sheetDuration->mergeCells('K5:L5');
        $sheetDuration->getStyle('K5:L5')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('K5:L5')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('K5:L5')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('K6', 'Target');
        $sheetDuration->mergeCells('K6');
        $sheetDuration->getStyle('K6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('K6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('K6')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('L6', 'Aktual*');
        $sheetDuration->mergeCells('L6');
        $sheetDuration->getStyle('L6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('L6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('L6')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('M5', 'Penjualan');
        $sheetDuration->mergeCells('M5:N5');
        $sheetDuration->getStyle('M5:N5')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('M5:N5')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('M5:N5')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('M6', 'Target');
        $sheetDuration->mergeCells('M6');
        $sheetDuration->getStyle('M6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('M6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('M6')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('N6', 'Aktual*');
        $sheetDuration->mergeCells('N6');
        $sheetDuration->getStyle('N6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('N6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('N6')->getFont()->setBold( true );


        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('O5', 'Jumlah Hot Prospect');
        $sheetDuration->mergeCells('O5');
        $sheetDuration->getStyle('O5')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('O5')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('O5')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('O6', 'Aktual');
        $sheetDuration->mergeCells('O6');
        $sheetDuration->getStyle('O6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('O6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('O6')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('P5', 'Jumlah Closing (Deal) dari Hot Prospect');
        $sheetDuration->mergeCells('P5');
        $sheetDuration->getStyle('P5')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('P5')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('P5')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('P6', 'Aktual');
        $sheetDuration->mergeCells('P6');
        $sheetDuration->getStyle('P6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('P6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('P6')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('Q5', '% Deal dari Jumlah Prospek');
        $sheetDuration->mergeCells('Q5');
        $sheetDuration->getStyle('Q5')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('Q5')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('Q5')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('Q6', 'Aktual');
        $sheetDuration->mergeCells('Q6');
        $sheetDuration->getStyle('Q6')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('Q6')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('Q6')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('R5', 'Biaya Pameran');
        $sheetDuration->mergeCells('R5:R7');
        $sheetDuration->getStyle('R5:R7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('R5:R7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('R5:R7')->getFont()->setBold( true );

        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('K7', 'Selama Pameran');
        $sheetDuration->mergeCells('K7:Q7');
        $sheetDuration->getStyle('K7:Q7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('K7:Q7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('K7:Q7')->getFont()->setBold( true );


        $sheetDuration =  $spreadsheet->setActiveSheetIndex(0)->setCellValue('S5', 'Images');
        $sheetDuration->mergeCells('S5:W7');
        $sheetDuration->getStyle('S5:W7')->getAlignment()->setHorizontal('center');
        $sheetDuration->getStyle('S5:W7')->getAlignment()->setVertical('center');
        $sheetDuration->getStyle('S5:W7')->getFont()->setBold( true );

        $column = 8;
        $no=0;
        foreach($data as $val) {
        
            $imagesEvent = array();
            $images = $this->eventActivityModel->getActivityEventByID($val['eventid']);

            $start = strtotime(date_format(date_create($val['date_start']),"Y-m-d"));
            $end = strtotime(date_format(date_create($val['date_end']),"Y-m-d"));
            $datediff = $end - $start;
            $days_between = round($datediff / (60 * 60 * 24)) + 1;
            
            $no++;
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $column, $no)
                        ->setCellValue('B' . $column, date_format(date_create($val['date_start']),"d.m.Y"))
                        ->setCellValue('C' . $column, date_format(date_create($val['date_end']),"d.m.Y"))
                        ->setCellValue('D' . $column, $days_between." Hari")
                        ->setCellValue('E' . $column, $val['category_name'])
                        ->setCellValue('F' . $column, $val['name'])
                        ->setCellValue('G' . $column, $val['office_code'])
                        ->setCellValue('H' . $column, $val['office_name'])
                        ->setCellValue('I' . $column, $val['location'])
                        ->setCellValue('J' . $column, dataEventStatus($val['status']))
                        ->setCellValue('K' . $column, $val['target_visitor'])
                        ->setCellValue('L' . $column, $val['actual_visitor'])
                        ->setCellValue('M' . $column, $val['target_sell'])
                        ->setCellValue('N' . $column, $val['actual_sell'])
                        ->setCellValue('O' . $column, $val['target_prospect'])
                        ->setCellValue('P' . $column, $val['target_actual_prospect'])
                        ->setCellValue('Q' . $column, get_percentage((int)$val['target_prospect'],(int)$val['target_actual_prospect'])."%")
                        ->setCellValue('R' . $column, 'Rp.'.number_format($val['butget']));
                        if(count($images) <=0 ){
                            $spreadsheet->getActiveSheet()->getStyle('A'. $column.':U'. $column)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                            $spreadsheet->getActiveSheet()->getStyle('A'. $column.':U'. $column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                        }
                        foreach ($images as $key => $value) {
                           
                           
                            $IMG =  base_url().'/uploads/berkas/'.$value->images;
                            $imageType = "png";

                            if (strpos($IMG, ".png") === false) {
                                $imageType = "jpg";
                            }

                            $drawing = new MemoryDrawing();
                            $sheet->getRowDimension($column)->setRowHeight(200);

                            $gdImage = ($imageType == 'png') ? imagecreatefrompng($IMG) : imagecreatefromjpeg($IMG);
                            $drawing->setName('Company Logo');
                            $drawing->setDescription('Company Logo image');
                            $drawing->setResizeProportional(true);
                            $drawing->setImageResource($gdImage);
                            $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
                            $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
                            $drawing->setWidth(211);
                            $drawing->setHeight(200);
                            $drawing->setOffsetX(5);
                            $drawing->setOffsetY(30);
                            $drawing->setCoordinates($value->abjad.$column);
                            $drawing->setWorksheet($spreadsheet->getActiveSheet());
                            $spreadsheet->getActiveSheet()->getColumnDimension($value->abjad)->setWidth(25);
                            
                        }


            $column++;
        }
        $writer = new Xlsx($spreadsheet);
        $fileName = 'LPJ Activity Pameran';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
    function CompressImg(){

        $data = $this->eventActivityModel->getActivityAllImages();
        foreach ($data as $key => $value) {
            $old = preg_replace('/\s/', '',  Pwd()."/uploads/berkas/".$value->images);
            $new = preg_replace('/\s/', '',  Pwd()."/uploads/new/".$value->images);
            $image = \Config\Services::image()
            ->withFile($old)
            ->resize(400, 200, true, 'height')
            ->save($new);
            print_r($image);
            echo "<br/>";
            // print_r($old);
            // echo "<br/>";

        }
    }
}
