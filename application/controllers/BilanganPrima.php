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
class BilanganPrima extends REST_Controller {

    public function index_get()
    {
        //bilangan prima = habis dibagi 1 dan dirinya sendiri
        function prima($bilangan)
        {
            for ($i=2; $i < $bilangan ; $i++) { 
                if ($bilangan % $i == 0) {
                    return false; // bukan bilangan pruma
                }
            }    
            return true;
        }
        
        $limit = $this->get('limit');
        echo "Bilangan prima sebelum angka {$limit} adalah ";
        for ($i=2; $i < $limit ; $i++) { 
            if (prima($i)) {
                echo "{$i} ";
            }
        }
    }
}
