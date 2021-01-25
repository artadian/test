 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Receive Package </h3>
            <p class="text-muted m-b-30"></p>
            <div class="table-responsive">
                <table id="tblDokumen" class="table display">
                    <thead>
                        <tr>                            
                            <th></th>                            
                            <th>Package No</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Sender</th>
                            <th>Final Stop</th>                            
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>                        	
                            <th></th>                            
                            <th>Package No</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Sender</th>
                            <th>Final Stop</th>                            
                            <th>Notes</th>
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
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		
		var table = $('#tblDokumen').DataTable({
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/receivepackage/get_list_receive",
				type : 'POST'
			},
			'columnDefs': [
			  {
				 'targets': 0,
				 "data": null,            	 	 
				 "defaultContent": "<button type='button' class='btn btn-danger btn-circle'><i class='fa fa-list'></i> </button>"	
			  }
		   ],		   
		   'order': [[1, 'asc']]
		});	
		
		$('#tblDokumen tbody').on('click', 'button', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/receivepackage/edit_receive_package/" + data[0];		
		});
		
		
	}); 	
 </script>