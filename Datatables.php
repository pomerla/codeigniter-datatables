<?php


class Datatables{

	private $CI;

	private $table;

	private $columns = '*';

	private $searchable;

	function __construct($config){

		$this->CI = &get_instance();

		$this->table = $config['table'];

		$this->columns = $config['columns'];

		$this->searchable = $config['searchable'];
	}

	function generate(){

		$postData = $this->CI->input->post();
		
		$Query = $this->CI->db->get($this->table);
		$totalData = $Query->num_rows();
		$filteredData = $totalData;
		
		$this->CI->db->limit($postData['length'],$postData['start'])->order_by(
											$this->columns[$postData['order'][0]['column']],$postData['order'][0]['dir']
										);

		if(!empty($postData['search']['value'])){
			$index = 1;
			foreach($this->searchable as $key => $value){
				if($index == 1){

					$this->CI->db->where($value. " LIKE '%".$postData['search']['value']."%'");
				}else{

					$this->CI->db->or_where($value. " LIKE '%".$postData['search']['value']."%'");
				}
				$index++;
			}

			$Query = $this->CI->db->get($this->table);
			$filteredData = $Query->num_rows();
			$parseData = $Query->result();
		}else{

			$Query = $this->CI->db->get($this->table);
			$parseData = $Query->result();
		}

		$ArrayData = [];
		foreach($parseData as $key => $value){
			$dataArray = [];
			foreach($this->columns as $cKey => $cValue){

				$dataArray[] = $value->{$cValue};
			}
			$ArrayData[] = $dataArray;
		}

		$jsonData = array(
							'draw' => (int)$postData['draw'],
							'recordsTotal' => (int)$totalData,
							'recordsFiltered' => (int)$filteredData,
							'data' => $ArrayData
						 );


		echo json_encode($jsonData);
		

	}
}