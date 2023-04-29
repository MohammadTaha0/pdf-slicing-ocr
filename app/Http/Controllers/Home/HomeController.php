<?php

namespace App\Http\Controllers\Home;

ini_set('max_execution_time', 300);

// putenv("PATH=" . getenv('PATH') . ";C:\Program Files\Tesseract-OCR\"");
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\ImageManagerStatic as Image;
use Smalot\PdfParser\Parser;
// use Intervention\Image\Facades\Image;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\ImageContext;
use \Google\Cloud\Vision\V1\Image as NewIMage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Laravel\OCR\Facades\OCR;

use const \IMG_FILTER_THRESHOLD;
// use const \IMG_FILTER_THRESHOLD;

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
        $pdfPath = public_path('sample.pdf');
        $command = 'pdfinfo ' . $pdfPath;
        exec($command, $output);
        print_r($output);
        die();
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

        echo "<body style='background: white;'><img src='" . asset('fname_70_30.png') . "' style='mix-blend-mode: multiply;' ></body>";
        echo "<pre>";
        print_r(array_filter($filter));
        // foreach ($filter as $key => $value) {

        // }
        die();
        return view('Home.Index');
    }
    public function ocr()
    {
        // Set the path to the image file
        // $imagePath = public_path('image.jpg');

        // // Set the language for OCR to use
        // $language = 'eng';

        // // Extract tables from the image
        // $tables = OCR::table_extraction($imagePath, $language);

        // // Print the extracted tables
        // print_r($tables);
        // die();
        putenv('TESSDATA_PREFIX=' . 'C:\Program Files\Tesseract-OCR\tessdata');
        $imagePath = 'image.jpg';
        $rowH = 0;
        // $imagePath = public_path('images/table.png');

        // $image = Image::make($imagePath);

        // // Convert to grayscale
        // $image->greyscale();

        // // Apply adaptive threshold
        // $image->contrast(-2);
        // $image->brightness(-10);
        // $image->contrast(-2);

        // // Apply median filter
        // $image->blur(0);

        // // Save the preprocessed image
        // $image->save(public_path('preprocessed.jpg'));
        // $imagePath = 'preprocessed.jpg';
        // die();


        // for ($row = 1; $row <= 16; $row++) {
        //     // echo $row;
        //     #cnic
        //     $width = 276;
        //     $height = 90;
        //     $cnic = '';
        //     $slice = imagecreatetruecolor($width, $height);
        //     $x = 1000;
        //     $y = 170 + $rowH;
        //     $source = imagecreatefromjpeg($imagePath);
        //     imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
        //     $slicePath = 'cnic-' . $row . '.jpg';
        //     imagejpeg($slice, $slicePath);
        //     try {

        //         $sliceText = (new TesseractOCR($slicePath))
        //             // ->psm(6) // set page segmentation mode
        //             ->run();
        //         $urduText = $sliceText;
        //         $cnic .= $urduText;
        //         // unlink($slicePath);
        //     } catch (\Exception $e) {
        //         $e->getMessage();
        //     }
        //     // print_r($cnic);
        //     // die();
        //     if (!File::exists('imgs/' . $cnic)) {
        //         File::makeDirectory('imgs/' . $cnic);
        //     }
        //     #silsila
        //     $width = 80;
        //     $height = 90;
        //     $silsila = '';
        //     $slice = imagecreatetruecolor($width, $height);

        //     $x = 2100;
        //     $y = 180 + $rowH;
        //     $source = imagecreatefromjpeg($imagePath);
        //     imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
        //     $slicePath = 'silsila-' . $cnic . '.jpg';
        //     imagejpeg($slice, $slicePath);
        //     try {
        //         $sliceText = (new TesseractOCR($slicePath))
        //             // ->psm(6) // set page segmentation mode
        //             ->run();
        //         $urduText = $sliceText;
        //         $silsila .= $urduText;
        //         unlink($slicePath);
        //     } catch (\Exception $e) {
        //         $e->getMessage();
        //     }

        //     #gharana
        //     $width = 90;
        //     $height = 90;
        //     $gharana = '';
        //     $slice = imagecreatetruecolor($width, $height);

        //     $x = 1960;
        //     $y = 180 + $rowH;
        //     $source = imagecreatefromjpeg($imagePath);
        //     imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
        //     $gharana = 'imgs/' . $cnic . '/gharana.jpg';
        //     imagejpeg($slice, $gharana);
        //     try {
        //         $sliceText = (new TesseractOCR($gharana))
        //             // ->psm(6) // set page segmentation mode
        //             ->run();
        //         $urduText = $sliceText;
        //         $gharana .= $urduText;
        //         unlink($gharana);
        //     } catch (\Exception $e) {
        //         $e->getMessage();
        //     }

        //     #name
        //     $width = 150;
        //     $height = 80;
        //     $name = '';
        //     $slice = imagecreatetruecolor($width, $height);

        //     $x = 1780;
        //     $y = 140 + $rowH;
        //     $source = imagecreatefromjpeg($imagePath);
        //     imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
        //     $name = 'imgs/' . $cnic . '/name.jpg';
        //     imagejpeg($slice, $name);

        //     // address
        //     $width = 740;
        //     $height = 90;
        //     $slice = imagecreatetruecolor($width, $height);
        //     $x = 160;
        //     $y = 180 + $rowH;
        //     $source = imagecreatefromjpeg($imagePath);
        //     imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
        //     $address = 'imgs/' . $cnic . '/address.jpg';
        //     imagejpeg($slice, $address);


        //     $data[$cnic] = [
        //         'cnic' => $cnic,
        //         'silsila' => $silsila,
        //         'gharana' => $gharana,
        //         'name' => $name,
        //         'address' => $address,
        //         'nameIsImg' => true,
        //         'gharanaIsImg' => true,
        //         'addressIsImg' => true,
        //     ];
        //     if ($row < 5) {
        //         $rowH += 160;
        //     } elseif ($row === 5) {
        //         $rowH += 145;
        //     } elseif ($row > 8) {
        //         $rowH += 150;
        //     }
        // }
        // session(['data' => $data]);
        // $data = Session::get('data');
        // echo '<br><br><br><br><br><pre>';
        // print_r($data);
        return view('Home.Index');

        // header('Content-Type: text/html; charset=Windows-1256');
        // echo '<html><head><style>@font-face {font-family: "Nastaliq";src: url("Nastaliq.ttf") format("truetype");}body {font-family: "Nastaliq"; background-color: black; color: white;}</style></head><body>
        // <pre>' . print_r($data) . '</pre>
        // </body></html>';
    }
    public function op()
    {

        // Load OpenCV library
        // $opencv = new \OpenCV\OpenCV();

        // // Load image
        // $image = $opencv->imread('image.jpg', \OpenCV\ImreadModes::IMREAD_GRAYSCALE);

        // // Apply Gaussian blur to smooth the image
        // $blurred = $opencv->GaussianBlur($image, new \OpenCV\Size(5, 5), 0);

        // // Apply Canny edge detection to find edges
        // $edges = $opencv->Canny($blurred, 50, 150);

        // // Apply Hough line transform to find lines
        // $lines = $opencv->HoughLines($edges, 1, M_PI / 180, 100);

        // // Draw detected lines on the original image
        // foreach ($lines as $line) {
        //     $opencv->line($image, $line->getP1(), $line->getP2(), new \OpenCV\Scalar(255, 0, 0), 3, \OpenCV\LineTypes::LINE_AA, 0);
        // }

        // // Display result
        // $opencv->imshow('Table Detection', $image);
        // $opencv->waitKey();
    }
    public function ocr_edit(Request $request)
    {
        if ($request->get === 'true') {
            putenv('TESSDATA_PREFIX=' . 'C:\Program Files\Tesseract-OCR\tessdata');
            $imagePath = $request->file('image');
            $rowH = 0;
            for ($row = 1; $row <= 16; $row++) {
                #cnic
                $width = 276;
                $height = 90;
                $cnic = '';
                $slice = imagecreatetruecolor($width, $height);
                $x = 1000;
                $y = 170 + $rowH;
                $source = imagecreatefromjpeg($imagePath);
                imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
                $slicePath = 'cnic-' . $row . '.jpg';
                imagejpeg($slice, $slicePath);
                try {

                    $sliceText = (new TesseractOCR($slicePath))
                        // ->psm(6) // set page segmentation mode
                        ->run();
                    $urduText = $sliceText;
                    $cnic .= $urduText;
                    // unlink($slicePath);
                } catch (\Exception $e) {
                    $e->getMessage();
                }
                // print_r($cnic);
                // die();
                if (!File::exists('imgs/' . $cnic)) {
                    File::makeDirectory('imgs/' . $cnic);
                }
                #silsila
                $width = 80;
                $height = 90;
                $silsila = '';
                $slice = imagecreatetruecolor($width, $height);

                $x = 2100;
                $y = 180 + $rowH;
                $source = imagecreatefromjpeg($imagePath);
                imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
                $slicePath = 'silsila-' . $cnic . '.jpg';
                imagejpeg($slice, $slicePath);
                try {
                    $sliceText = (new TesseractOCR($slicePath))
                        // ->psm(6) // set page segmentation mode
                        ->run();
                    $urduText = $sliceText;
                    $silsila .= $urduText;
                    unlink($slicePath);
                } catch (\Exception $e) {
                    $e->getMessage();
                }

                #gharana
                $width = 90;
                $height = 90;
                $gharana = '';
                $slice = imagecreatetruecolor($width, $height);

                $x = 1960;
                $y = 180 + $rowH;
                $source = imagecreatefromjpeg($imagePath);
                imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
                $gharana = 'imgs/' . $cnic . '/gharana.jpg';
                imagejpeg($slice, $gharana);
                try {
                    $sliceText = (new TesseractOCR($gharana))
                        // ->psm(6) // set page segmentation mode
                        ->run();
                    $urduText = $sliceText;
                    $gharana .= $urduText;
                    unlink($gharana);
                } catch (\Exception $e) {
                    $e->getMessage();
                }

                #name
                $width = 150;
                $height = 80;
                $name = '';
                $slice = imagecreatetruecolor($width, $height);

                $x = 1780;
                $y = 140 + $rowH;
                $source = imagecreatefromjpeg($imagePath);
                imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
                $name = 'imgs/' . $cnic . '/name.jpg';
                imagejpeg($slice, $name);

                // address
                $width = 740;
                $height = 90;
                $slice = imagecreatetruecolor($width, $height);
                $x = 160;
                $y = 180 + $rowH;
                $source = imagecreatefromjpeg($imagePath);
                imagecopy($slice, $source, 0, 0, $x, $y, $width, $height);
                $address = 'imgs/' . $cnic . '/address.jpg';
                imagejpeg($slice, $address);


                $data[$cnic] = [
                    'cnic' => $cnic,
                    'silsila' => $silsila,
                    'gharana' => $gharana,
                    'name' => $name,
                    'address' => $address,
                    'nameIsImg' => true,
                    'gharanaIsImg' => true,
                    'addressIsImg' => true,
                ];
                if ($row < 5) {
                    $rowH += 160;
                } elseif ($row === 5) {
                    $rowH += 145;
                } elseif ($row > 8) {
                    $rowH += 150;
                }
            }
            session(['data' => $data]);
            $data = Session::get('data');
        } else {
            $data = Session::get('data');
            $data[$request->cnic][$request->type] = $request->inpValue;
            $data[$request->cnic][$request->type . 'IsImg'] = false;
            Session::put('data', $data);
        }
        foreach ($data as $item) {
?>
            <tr>
                <td>
                    <?php echo  $item['cnic'] ?>
                </td>

                <td>
                    <?php echo  $item['silsila'] ?>
                </td>
                <td>
                    <?php
                    if ($item['gharanaIsImg']) {
                    ?>
                        <img src="<?php echo $item['gharana'] ?>" style="width: 50px" alt="">
                    <?php
                    } else {
                        echo $item['gharana'];
                    }
                    ?>
                    <input type="text" id="gharana-<?php echo $item['cnic'] ?>" class="form-control form-control-sm">
                    <button type="button" data-role='update' data-type="gharana" class="btn btn-outline-primary" data-id="<?php echo $item['cnic'] ?>">save</button>
                </td>
                <td>
                    <?php
                    if ($item['nameIsImg']) {
                    ?>
                        <img src="<?php echo $item['name'] ?>" style="width: 150px" alt="">
                    <?php
                    } else {
                        echo $item['name'];
                    }
                    ?> <input type="text" id="name-<?php echo $item['cnic'] ?>" class="form-control form-control-sm">
                    <button type="button" data-role='update' data-type="name" class="btn btn-outline-primary" data-id="<?php echo $item['cnic'] ?>">save</button>
                </td>
                <td>
                    <?php
                    if ($item['addressIsImg']) {
                    ?>
                        <img src="<?php echo $item['address'] ?>" style="width: 450px" alt="">
                    <?php
                    } else {
                        echo $item['address'];
                    }
                    ?> <div class="input-group form-group">
                        <input type="text" id="address-<?php echo $item['cnic'] ?>" class="form-control form-control-sm">
                        <button type="button" data-role='update' data-type="address" class="btn btn-outline-primary" data-id="<?php echo $item['cnic'] ?>">save</button>
                    </div>
                </td>
            </tr>
<?php
        }
        // return response()->json(['status'=>200,'data'=>session('data')]);
        // return $request->all();
    }
}
