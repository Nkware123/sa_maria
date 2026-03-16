<?php 
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
class My_Model extends Model 
{
	public function getOne($table,$critere_array) 
	{
		return $this->db
		->table($table)
		->where($critere_array)
		->get()
		->getRowarray();
	}

	public function create($table,$data_array) 
	{
		$this->db
		->table($table)
		->insert($data_array);

		return $lastId = $this->db->insertID();
	}

	public function update_data($table,$critere_array=array(),$data_array=array()) 
	{
		return $this->db
		->table($table)
		->where($critere_array)
		->set($data_array)
		->update();
	}
	
	public function delete_data($table,$critere_array) {
		return $this->db
		->table($table)
		->where($critere_array)
		->delete();
	}

	public function getRequete($sql)
	{
		return $this->db
		->query($sql)
		->getResultarray();
	}
}
?>