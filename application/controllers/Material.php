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
class Material extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('M_Material');
    }

    public function index_get()
    {
        $material_code = $this->get('material_code');

        // jika kode material tidak null find kode 
        if ($material_code) {
            $material = $this->M_Material->get_material_by_code($material_code);

            // kondisi ketika kode material tidak ditemukan
            if (count($material) == 0 ) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'data' => [],
                    'message' => 'Material Code '. $material_code .' no exist'
                ], REST_Controller::HTTP_NOT_FOUND); 
                 return false;
            }
        } else {
            $material = $this->M_Material->get_all_material();

            // kondisi ketika tidak ada data 
            if (count($material) == 0 ) {
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'data' => [],
                    'message' => 'Data material no exist'
                ], REST_Controller::HTTP_NOT_FOUND); 
                return false;
            }
        }

        // kondisi ketika find kode material
        if ($material_code != null || $material_code != '' && count($material) != 0) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'data' => $material,
                'message' => 'Successfully load data by code'
            ], REST_Controller::HTTP_OK); 
        } else {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'data' => $material,
                'message' => 'Successfully load data'
            ], REST_Controller::HTTP_OK); 
        }           
    }

    function index_post()
    {
        //validasi
        if ($this->post('material_code') == 'null' || $this->post('material_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Material code is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }
        if ($this->post('name') == 'null' || $this->post('name') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Name is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }
        if ($this->post('material_type_code') == 'null' || $this->post('material_type_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Material Type is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        if ($this->post('price_buy') == 'null' || $this->post('price_buy') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Price Buy is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }
        
        if (!is_numeric($this->post('price_buy'))) {
            $this->response([
                'status' => FALSE,
                'message' => 'Price Buy is Numeric!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        if (floatval($this->post('price_buy')) < 100) {
            $this->response([
                'status' => FALSE,
                'message' => 'Price Buy cannot be less than 100!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        if ($this->post('supplier_code') == 'null' || $this->post('supplier_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Supplier Code is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        //Ceking data di database code material harus unique
        $check_material_code = $this->M_Material->check_material_code($this->post('material_code'));
        if (count($check_material_code) > 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Material Code '.  $this->post('material_code')  .' already exist!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        //Ceking data di database code material type
        $check_material_type_code = $this->M_Material->check_material_type_code($this->post('material_type_code'));
        if (count($check_material_type_code) == 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Material type no exist!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        //Ceking data di database code material type
        $check_supplier_code = $this->M_Material->check_supplier_code($this->post('supplier_code'));
        if (count($check_supplier_code) == 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Supplier no exist!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }


        $data = [
            'material_code' => $this->post('material_code'),
            'name' => $this->post('name'),
            'material_type_code' => $this->post('material_type_code'),
            'price_buy' => $this->post('price_buy'),
            'supplier_code' => $this->post('supplier_code'),
        ]; 
        $insert = $this->M_Material->insert_data($data);
        if ($insert) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'data' => $data,
                'message' => 'Successfully adding material'
            ], REST_Controller::HTTP_OK); 

        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Failed adding material'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
        
    }

    function index_put()
    {
        //validasi
        if ($this->put('material_code') == 'null' || $this->put('material_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Material code is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }
        if ($this->put('name') == 'null' || $this->put('name') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Name is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }
        if ($this->put('material_type_code') == 'null' || $this->put('material_type_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Material Type is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        if ($this->put('price_buy') == 'null' || $this->put('price_buy') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Price Buy is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }
        
        if (!is_numeric($this->put('price_buy'))) {
            $this->response([
                'status' => FALSE,
                'message' => 'Price Buy is Numeric!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        if (floatval($this->put('price_buy')) < 100) {
            $this->response([
                'status' => FALSE,
                'message' => 'Price Buy cannot be less than 100!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        if ($this->put('supplier_code') == 'null' || $this->put('supplier_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Supplier Code is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        //Ceking data di database code material harus tersedia
        $check_material_code = $this->M_Material->check_material_code($this->put('material_code'));
        if (count($check_material_code) == 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Material Code '.  $this->put('material_code')  .' no exist!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        //Ceking data di database code material type
        $check_material_type_code = $this->M_Material->check_material_type_code($this->put('material_type_code'));
        if (count($check_material_type_code) == 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Material type no exist!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

        //Ceking data di database code material type
        $check_supplier_code = $this->M_Material->check_supplier_code($this->put('supplier_code'));
        if (count($check_supplier_code) == 0) {
            $this->response([
                'status' => FALSE,
                'message' => 'Supplier no exist!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }


        $data = [
            'material_code' => $this->put('material_code'),
            'name' => $this->put('name'),
            'material_type_code' => $this->put('material_type_code'),
            'price_buy' => $this->put('price_buy'),
            'supplier_code' => $this->put('supplier_code'),
        ]; 
        $update = $this->M_Material->update_data($this->put('material_code'),$data);
        if ($update) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'data' => $data,
                'message' => 'Successfully update material'
            ], REST_Controller::HTTP_OK); 

        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Failed update material'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }
        
    }

    public function index_delete()
    {
        //validasi
        if ($this->delete('material_code') == 'null' || $this->delete('material_code') == '') {
            $this->response([
                'status' => FALSE,
                'message' => 'Material code is Required!'
            ], REST_Controller::HTTP_BAD_REQUEST); 
            return false;
        }

         //Ceking data di database code material harus tersedia
         $check_material_code = $this->M_Material->check_material_code($this->delete('material_code'));
         if (count($check_material_code) == 0) {
             $this->response([
                 'status' => FALSE,
                 'message' => 'Material Code '.  $this->delete('material_code')  .' no exist!'
             ], REST_Controller::HTTP_BAD_REQUEST); 
             return false;
         }

        $material_code = $this->delete('material_code');
        $delete = $this->M_Material->delete_data($material_code);
        if ($delete) {
            // Set the response and exit
            $this->response([
                'status' => TRUE,
                'message' => 'Material Code ' . $material_code . ' Deleted!'
            ], REST_Controller::HTTP_OK); 

        } else {
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Failed delete material'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        }

       
    }

    function index_options()
    {
        $material_type_code = $this->options('material_type_code');
        $filter = $this->M_Material->filter_material_by_type($material_type_code);
        if (count($filter) <= 0) {
            $this->response([
                'status' => FALSE,
                'data' => [],
                'message' => 'Material Type no exist'
            ], REST_Controller::HTTP_BAD_REQUEST); 
        } elseif ($material_type_code == '' || $material_type_code == 'null' ) {
            $this->response([
                'status' => TRUE,
                'data' => $filter,
                'message' => 'Load all material'
            ], REST_Controller::HTTP_OK); 
        } else {
            $this->response([
                'status' => TRUE,
                'data' => $filter,
                'message' => 'Successfully load material by Material Type'
            ], REST_Controller::HTTP_OK); 
        }   
    }



}
