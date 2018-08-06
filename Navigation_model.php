<?php

/**
* 
*/
class Navigation_model extends CI_Model
{
	public function __construct(){
		
	}
	public function getAll(){
		$query=$this->db->get('navigation'); 
		return $this->getQueryResult($query);
	}

	protected function getQueryResult($query){
		if($query->num_rows()>0){
		return $query->result_array();
		}
		return false;
	}
	public function getCustomFieldsAll($data=[]){

		$this->selectedFields($data);
		return $this->getAll();
	}
	protected function selectedFields(array $data)
	{
		$fields=empty($data) ? '*': implode(', ', $data);	

		return $this->db->select($fields);
	}
	public function getNavigtionUrl($id)
	{
		$sql   = "SELECT url FROM navigation where id=?";
		$query = $this->db->query($sql,[
					'id'=>$id
				]);
		return $this->getQueryResult($query);
	}
	public function getNavigtionById($id)
	{
		$sql   = "SELECT * FROM navigation where id=?";
		$query = $this->db->query($sql,[
					'id'=>$id
				]);
		return $this->getQueryResult($query);
	}
	public function getNavigtionUrls($boolean,$limit=2,$offset=0)
	{

		$query = $this->db->get_where('navigation', array('is_active' => $boolean), $limit, $offset);
		 return $this->getQueryResult($query);
	}
	public function insertURL($data){

		$sql   = "INSERT INTO navigation (title,url,order_number) VALUES(?,?,?)";
		$query = $this->db->query($sql,[
					'title'=>htmlentities($data['title']),
					'url'=>$data['url'],
					'order_number'=>$data['order_number'],
				]);
		return  $this->db->last_query();

	}
	public function updateURL($id,$data){

		return $this->db->query($this->db->update_string('navigation', [
				'title'=>htmlentities($data['title']),
				'url'=>$data['url'],
				'order_number'=>$data['order_number'],
			], 
			"id=".$id
		));
	}
	public function getProducts($navigation_id,$data=[])
	{

		$this->selectedFields($data);
		$this->db->from('navigation');
		$this->db->join('products', 'products.navigation_id = navigation.id');
		$this->db->where('navigation.id', $navigation_id); 
		$query=$this->db->get(); 
		return $this->getQueryResult($query);
	}

	public function search($field){
		$this->db->select('*');
		$this->db->from('navigation');
		$this->db->like('title', $field); 
		$query=$this->db->get(); 
		return $this->getQueryResult($query);
	}
	
}