 <!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Sent Package </h3>
            <p class="text-muted m-b-30"></p>
            <div class="table-responsive">
                <table id="tblDokumen" class="table display">
                    <thead>
                        <tr>                            
                            <th></th>                            
                            <th>Package No</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Sender</th>
                            <th>Final Stop</th>                            
                            <th>Notes</th>
                            <th>StatusHistory</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>                        	
                            <th></th>                            
                            <th>Package No</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Sender</th>
                            <th>Final Stop</th>                            
                            <th>Notes</th>
                            <th>StatusHistory</th>
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
				url : "<?php echo base_url();?>admin/sentpackage/get_list_sent",
				type : 'POST'
			},
			'columnDefs': [
			  {
				 'targets': 0,
				 'data': null,            	 	 
				 'render': function (data, type, row, meta) {
					if (type == 'display') 
					{
						var label = '';
						if (row[8] == 'COMPLETE') 
						{
							return "<button type='button' class='btn btn-danger btn-circle btnEdit'><i class='fa fa-list'></i> </button> <button type='button' class='btn btn-primary btn-circle btnPrint'><i class='fa fa-print'></i></button>"
						} 
						else 
						{
							return "<button type='button' class='btn btn-danger btn-circle btnEdit'><i class='fa fa-list'></i> "
						}					
					}
					return data;
				 },
				 //"defaultContent": "<button type='button' class='btn btn-danger btn-circle btnEdit'><i class='fa fa-list'></i> </button> <button type='button' class='btn btn-primary btn-circle btnPrint'><i class='fa fa-print'></i></button>"				 
			  },
			  {
				 'targets': 2,
				 'render': function (data, type, row, meta) {
					if (type == 'display') 
					{
						var label = '';
						if (data == 'STOP') 
						{
							label = 'label-danger';
						} 
						else if (data == 'PROGRESS') 
						{
							label = 'label-info';
						}
						else if (data == 'COMPLETE') 
						{
							label = 'label-success';
						}
						//return '<span class="label ' + label + '">' + data + '</span>';
						return '<div class="label label-table ' + label + '">'+ data +'</div>'
					}
					return data;
				  }
			   },
			   { "visible": false,  "targets": [ 8 ] }
		   ],		   
		   'order': [[1, 'asc']]
		});	
		
		$('#tblDokumen tbody').on('click', 'button.btnEdit', function () {
			var data = table.row( $(this).parents('tr') ).data();			
			location.href="<?php echo base_url();?>admin/sentpackage/edit_sent_package/" + data[0];		
		});
		
		$('#tblDokumen tbody').on('click', 'button.btnPrint', function () {
			var data = table.row( $(this).parents('tr') ).data();						
			window.open( "<?php echo base_url();?>admin/sentpackage/print_sentpackage/" + data[0], '_blank' );
		});		
		
	}); 	
 </script>