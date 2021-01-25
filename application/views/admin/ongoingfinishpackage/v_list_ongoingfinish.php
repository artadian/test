 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">List Received On Going Package </h3>
            <p class="text-muted m-b-30"></p>
            <div class="table-responsive">
                <table id="tblDokumen" class="table display">
                    <thead>
                        <tr>                            
                            <th><input name="chkAll" value="1" id="chkAll" type="checkbox" /></th>                            
                            <th>Package No</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Sender</th>
                            <th>Next Stop</th>
                            <th>Courier</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>                        	
                            <th></th>                            
                            <th>Package No</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Sender</th>
                            <th>Next Stop</th>
                            <th>Courier</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-sm-5"></div>              
    <div class="col-sm-2">
        <button id="btnCancel" class="btn btn-block btn-success btn-rounded">CANCEL RECEIVE</button>
    </div>              		
    <div class="col-sm-5"></div>
</div>
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		
		var table = $('#tblDokumen').DataTable({
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/ongoingfinishpackage/get_list",
				type : 'POST'
			},
			'columnDefs': [
			  {
				 'targets': 0,
				 /*'checkboxes': {
					'selectRow': true
				 }*/
				 'render': function (data, type, row, meta){
					 if (row[8] == 'RECEIVED') {
					 	return '<input type="checkbox" name="id[]" value="' 
							+ $('<div/>').text(data).html() + '">';
					 }
					 else
					 {
						 return '';
					 }
				 }
			  },
			  { "visible": false,  "targets": [ 8 ] }
		   ],
		   /*'select': {
			  'style': 'multi'
		   },*/
		   'order': [[1, 'asc']]
		});	
		
		$('#btnCancel').on('click', function(e){	
			var idcheck = [];					 	
			table.$('input[type="checkbox"]').each(function(){
				if(this.checked){
				   idcheck.push(this.value);
				}				 
		 	});
			
			if (idcheck.length > 0)
			{
				swal({
				  title: "Warning",
				  text: "Are you sure ?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Yes, cancel it!",
				  closeOnConfirm: false
				},
				function(){
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/ongoingfinishpackage/cancel_receive",
						data: {idcheck : idcheck },
						dataType: 'json',
						success: function(jsonData){						
							
							if (jsonData.responseCode=="200"){
								swal({
									title: "Save Success",allowEscapeKey:false,
									text: jsonData.responseMsg, type: "success",
									confirmButtonText: "OK", closeOnConfirm: false
								});                   
								table.ajax.reload();
							}else{
								 swal("Error", jsonData.responseMsg, "error");                    
							}	
						},
						error: function(jqXHR, textStatus, errorThrown ){
                            swal("Error", errorThrown, "error");
                    	}
					});
					
					
				});
			}
			else
			{
				swal('Warning','Please choose package to be cancelled','warning');
				return false;
			}
	   	});	
		
		$('#chkAll').on('click', function(){
			// Check/uncheck all checkboxes in the table
		  	var rows = table.rows({ 'search': 'applied' }).nodes();
		  	$('input[type="checkbox"]', rows).prop('checked', this.checked);
	   	});
	   
	   	// Handle click on checkbox to set state of "Select all" control
	   $('#tblDokumen tbody').on('change', 'input[type="checkbox"]', function(){
		  // If checkbox is not checked
		  if(!this.checked){
			 var el = $('#chkAll').get(0);
			 // If "Select all" control is checked and has 'indeterminate' property
			 if(el && el.checked && ('indeterminate' in el)){
				// Set visual state of "Select all" control 
				// as 'indeterminate'
				el.indeterminate = true;
			 }
		  }
	   });
		
	}); 	
 </script>