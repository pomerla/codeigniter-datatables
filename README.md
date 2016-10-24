Codeigniter Datatables Library
===================================

Simple Datatable library for CodeIgniter. Generate datatable quickly.

## What is this?

Simple codeigniter library for generate datatables without using any queries and complex functionality.

## Quick Start

- Clone this repo
- Create a GitHub Application on GitHub.com
- Put into `/application/libraries/Datatables.php`


## Example

	##Controller

`function viewfunction(){

	$this->load->view('datatableview');
}

function getdata(){

	$config['table'] = 'table-name';
	$config['columns'] = array('column_one', 'column_two','column_three','column_four');
	$config['searchable'] = array('column_one','column_two');

	$this->load->library('datatables',$config);

	$this->datatables->generate();
}`

## View

`<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/b-1.2.2/b-html5-1.2.2/b-print-1.2.2/fh-3.1.2/se-1.2.0/datatables.min.css"/>
 
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/b-1.2.2/b-html5-1.2.2/b-print-1.2.2/fh-3.1.2/se-1.2.0/datatables.min.js"></script>

	
	$(document).ready(function() {
	    $('#datatables').DataTable( {
	    		dom: 'Bfrtip',
	    		
		      buttons: [
		          'copy', 'csv', 'excel', 'pdf', 'print'
		      ],
	        "processing": true,
	        "serverSide": true,
	        "ajax": {
	            "url": "<?=base_url()?>index.php/controller/getdata",
	            "type": "POST"
	        },

	    });
	} );


	<table id="datatables">
        <thead>
            <tr>
                <th>Column One</th>
                <th>Column Two</th>
                <th>Column Three</th>
                <th>Column Four</th>
                
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Column One</th>
                <th>Column Two</th>
                <th>Column Three</th>
                <th>Column Four</th>
            </tr>
        </tfoot>
    </table>
	
`
Contact if any problem: `rahulsharma841990@outlook.com`