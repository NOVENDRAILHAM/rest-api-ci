<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class DigitAngka extends REST_Controller {

    function index_get() {

        //function menemukan place angka pada deret angka

        function placeNumber($place, $number)
        {
            //convert number to string
            $strNumber = strval($number);
           
            if ($place >= 1 && $place <= strlen($strNumber)) {  //strlen untuk menghitung jumlah karakter string
                $placeDigit = $strNumber[$place - 1]; //array dimulai dari 0 maka place dikurang 1
                return intval($placeDigit);
            } else {
                return null;
            }
        }

        function countNumber($number)
        {
            $count = strlen(strval($number));
            return $count;
        }

        $number = $this->get('number');
        $place = $this->get('place');

        $placeNumber = placeNumber($place, $number);
        $countNumber = countNumber($number);

        echo "Digit ke {$place} dari angka {$number} adalah {$placeNumber} <br>";
        echo "Jumlah Karakter pada {$number} adalah {$countNumber}";
       
    }
}
