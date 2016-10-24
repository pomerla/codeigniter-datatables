<?php

/**
 * The file that defines the datatable class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://rahulasr.com/
 * @since      1.0.0
 *
 * @package    Datatables
 */

/**
 * The core plugin class.
 *
 * This is used to create datatables without any extra code, developer sepcify
 * table, columns.
 *
 *
 * @since      1.0.0
 * @package    Datatable Library
 * @author     Rahul Sharma <rahulsharma841990@outlook.com>
 */

class Datatables{
	/*
	*
	* Save class instance
	*
	*/
	private $CI;

	/*
	*
	* Store the table name for generate table
	*
	*/

	private $table;

	/*
	*
	* Store columns to display in datatable
	*
	*/

	private $columns = '*';

	/*
	*
	* Store columns for searchable
	*
	*/

	private $searchable;

	function __construct($config){

		/*
		*
		* Create instance of class
		*
		*/
		$this->CI = &get_instance();

		/*
		*
		* Get table name from config
		*
		*/
		$this->table = $config['table'];

		/*
		*
		* Get columns from config and store
		* in private variable.
		*
		*/

		$this->columns = $config['columns'];

		/*
		*
		* Get column's name for make searchable
		*
		*/

		$this->searchable = $config['searchable'];
	}

	/*
	*
	* Generate the datatable
	*
	*/
	function generate(){

		//Getting all posted data
		$postData = $this->CI->input->post();
		
		//Get the total number of records
		$Query = $this->CI->db->get($this->table);

		$totalData = $Query->num_rows();

		//Store totalData in filteredData assumes all not get any search right now 
		$filteredData = $totalData;
		
		//Getting data with limit and offset
		$this->CI->db->limit($postData['length'],$postData['start'])->order_by(
											$this->columns[$postData['order'][0]['column']],$postData['order'][0]['dir']
										);

		//check if search is not empty
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

			//get all the filtered rows
			$Query = $this->CI->db->get($this->table);

			$filteredData = $Query->num_rows();

			$parseData = $Query->result();
		}else{

			//if not searched any value
			$Query = $this->CI->db->get($this->table);

			$parseData = $Query->result();
		}

		//Generating array according to datatable
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