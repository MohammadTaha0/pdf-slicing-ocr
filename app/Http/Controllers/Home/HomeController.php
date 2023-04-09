<?php

namespace App\Http\Controllers\Home;

ini_set('max_execution_time', 300);

// putenv("PATH=" . getenv('PATH') . ";C:\Program Files\Tesseract-OCR\"");
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\ImageManagerStatic as Image;
use Smalot\PdfParser\Parser;

class HomeController extends Controller
{
    public function index()
    {
        // $i = 1;
        // $filter = [];
        // $pdfPath = public_path('/sample.pdf');
        // $command = 'pdfinfo ' . $pdfPath;
        // exec($command, $output);
        // $totalPages = str_replace('Pages: ', '', $output[7]);
        // for ($j = 3; $j <= 30; $j++) {
        //     $sliceX = 500; // starting x position of slice
        //     $sliceY = 150; // starting y position of slice
        //     $sliceWidth = 670; // width of slice
        //     $sliceHeight = 1600; // height of slice
        //     $command = 'pdftoppm -png ' . $pdfPath . ' image -f ' . $j . ' -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth. ' -H ' . $sliceHeight;
        //     exec($command);
        //     // $images = glob('image*.png');
        //     // $img = Image::make(public_path('image.png'));
        //     // $img->contrast(0);
        //     // $img->save(public_path('image.png'));
        //     $images = glob('image*.png');
        //     foreach ($images as $image) {

        //         $command = 'tesseract ' . $image . ' stdout';
        //         $output = [];
        //         exec($command, $output);
        //         $numericValues =  preg_replace('/[^\d-]+/', ' ', $output);
        //     }
        //     foreach ($numericValues as $key => $value) {
        //         if (strlen($value) > 12 && strpos($value, '-')) {
        //             $filter[] = $value;
        //         }
        //     }

        //     $command = 'rm image*.png';
        //     exec($command);
        // }

        // echo "<pre>";
        // print_r(array_filter($filter));
        // $_SESSION['']

        $i = 1;
        $filter = [];
        $pdfPath = public_path('/sample.pdf');
        $command = 'pdfinfo ' . $pdfPath;
        exec($command, $output);
        $totalPages = str_replace('Pages: ', '', $output[7]);
        $height = 0;
        for ($cols = 1; $cols <= 18; $cols++) {
            $sliceX = 491; // starting x position of slice
            $sliceY = 163 + $height; // starting y position of slice
            $sliceWidth = 159; // width of slice
            $sliceHeight = 60; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' cnic -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('cnic*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    if (strlen($value) === 15) {
                        $filter[$value]['cnic'] = $value;
                        $cnic = $value;
                    } else {
                        $cnic = "";
                    }
                }
            }
            $sliceX = 1100; // starting x position of slice
            $sliceY = 163 + $height; // starting y position of slice
            $sliceWidth = 53; // width of slice
            $sliceHeight = 60; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' gty1 -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('gty1*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    $filter[$cnic]['silsila'] = $value;
                    $silsila = $value;
                    $value = "";
                }
            }
            $sliceX = 1020; // starting x position of slice
            $sliceY = 163 + $height; // starting y position of slice
            $sliceWidth = 60; // width of slice
            $sliceHeight = 60; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' gtys -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('gtys*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    $filter[$cnic]['ghrana'] = $value;
                    $gharana = $value;
                    $value = "";
                }
            }
            $sliceX = 930; // starting x position of slice
            $sliceY = 155 + $height; // starting y position of slice
            $sliceWidth = 84; // width of slice
            $sliceHeight = 35; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' fname_' . $silsila . '_' . $gharana . ' -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('fname_' . $silsila . '_' . $gharana . '*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    $filter[$cnic]['fname'] = $image;
                }
            }
            $sliceX = 745; // starting x position of slice
            $sliceY = 155 + $height; // starting y position of slice
            $sliceWidth = 104; // width of slice
            $sliceHeight = 35; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' fathername_' . $silsila . '_' . $gharana . ' -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('fathername_' . $silsila . '_' . $gharana . '*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    $filter[$cnic]['fathername'] = $image;
                }
            }
            $sliceX = 443; // starting x position of slice
            $sliceY = 163 + $height; // starting y position of slice
            $sliceWidth = 45; // width of slice
            $sliceHeight = 57; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' age_' . $silsila . '_' . $gharana . ' -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('age_' . $silsila . '_' . $gharana . '*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    $filter[$cnic]['age'] = $image;
                }
            }
            $sliceX = 45; // starting x position of slice
            $sliceY = 163 + $height; // starting y position of slice
            $sliceWidth = 390; // width of slice
            $sliceHeight = 57; // height of slice
            $command = 'pdftoppm -png ' . $pdfPath . ' address_' . $silsila . '_' . $gharana . ' -f 8 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
            exec($command);
            $images = glob('address_' . $silsila . '_' . $gharana . '*.png');
            foreach ($images as $image) {
                $command = 'tesseract ' .  $image . ' stdout';
                $output = [];
                exec($command, $output);
                $numericValues[] = implode(' ', $output);
            }
            foreach ($numericValues as $key => $value) {
                if ($value > 0) { // replace true with meaningful condition
                    $filter[$cnic]['address'] = $image;
                }
            }
            $height += 86;
            $cnic = "";
            $gharana = "";
            $silsila = "";
            $value = "";
        }

        // print_r($filter); // print filtered numeric values for debugging

        // $sliceX = 1020; // starting x position of slice
        // $sliceY = 160; // starting y position of slice
        // $sliceWidth = 60; // width of slice
        // $sliceHeight = 60; // height of slice
        // $command = 'pdftoppm -png ' . $pdfPath . ' _4 -f 4 -singlefile -x ' . $sliceX . ' -y ' . $sliceY . ' -W ' . $sliceWidth . ' -H ' . $sliceHeight;
        // exec($command);
        // $images = glob('_4*.png');
        // foreach ($images as $image) {

        //     $command = 'tesseract ' . $image . ' stdout';
        //     $output = [];
        //     exec($command, $output);
        //     $numericValues =  preg_replace('/[^\d-]+/', ' ', $output);
        // }
        // foreach ($numericValues as $key => $value) {
        //     if (true) {
        //         $filter[] = $value;
        //     }
        // }

            echo "<body style='background: white;'><img src='".asset('fname_70_30.png')."' style='mix-blend-mode: multiply;' ></body>";
        echo "<pre>";
        print_r(array_filter($filter));
        die();
        return view('Home.Index');
    }
}
