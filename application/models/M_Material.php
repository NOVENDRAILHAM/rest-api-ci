<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Material extends CI_Model {

    //menampilkan semua data material
    function get_all_material()
    {
        $this->db->select('*');
        $this->db->from('materials');
        $this->db->join('material_type', 'materials.material_type_code = material_type.material_type_code', 'left');        
        $this->db->join('suppliers', 'materials.supplier_code = suppliers.supplier_code', 'left');        
        return $this->db->get()->result();    
    }

    //menampilkan semua data material by kode
    function get_material_by_code($material_code)
    {
        $this->db->select('*');
        $this->db->from('materials');
        $this->db->join('material_type', 'materials.material_type_code = material_type.material_type_code', 'left');        
        $this->db->join('suppliers', 'materials.supplier_code = suppliers.supplier_code', 'left');     
        $this->db->where('materials.material_code', $material_code);
        return $this->db->get()->result();    
    }

    //Ceking data material code harus unique
    function check_material_code($material_code)
    {
        $this->db->where('material_code', $material_code);
        return $this->db->get('materials')->result();    
    }

    //Ceking data material type code
    function check_material_type_code($material_type_code)
    {
        $this->db->where('material_type_code', $material_type_code);
        return $this->db->get('material_type')->result();    
    }

    //Ceking data supplier code
    function check_supplier_code($supplier_code)
    {
        $this->db->where('supplier_code', $supplier_code);
        return $this->db->get('suppliers')->result();    
    }

    //insert data 
    function insert_data($data)
    {
        return $this->db->insert('materials', $data);   
    }
    
    //update data 
    function update_data($material_code,$data)
    {
        $this->db->where('material_code', $material_code);
        return $this->db->update('materials', $data);   
    }

    //delete data 
    function delete_data($material_code)
    {
        $this->db->where('material_code', $material_code);
        return $this->db->delete('materials');   
    }

    //filter material by material type
    function filter_material_by_type($material_type_code)
    {
        $this->db->select('*');
        $this->db->from('materials');
        $this->db->join('material_type', 'materials.material_type_code = material_type.material_type_code', 'left');        
        $this->db->join('suppliers', 'materials.supplier_code = suppliers.supplier_code', 'left');  
        if ($material_type_code != null) {
            $this->db->where('materials.material_type_code', $material_type_code);
        }   
        return $this->db->get()->result();     
    }

}

