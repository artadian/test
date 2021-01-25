<?php 
$header = $data['header']; 
$detail = $data['detail']; 
$arrRoute = explode(",",str_replace('D','',$header['Route']));
$arrNamaRoute = explode(",",$header['NamaRoute']);
$arrDefaultRoute = explode(",",str_replace('D','',$defaultRoute['Route']));
$arrNamaDefaultRoute = explode(",",$defaultRoute['NamaRoute']);
if (count($arrDefaultRoute) > 0)
{
	$defRoute['TujuanBerikut'] = $arrDefaultRoute[0];
	$defRoute['TujuanAkhir'] = $arrDefaultRoute[count($arrDefaultRoute)-1];
}

?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php if ($header['ID'] > 0) { print "Edit Package - ".$header['No']; } else print "Create New Package"; ?></h3>
                            <p class="text-muted m-b-30 font-13"></p>
                            <div class="row" style="display:none">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Final Stop</label>                                        
                    					<select id="cmbFinalStop" class="form-control select2">
                                          	<?php foreach ($userFinalStop as $us): ?>																	
                                                <option value="<?php echo $us['ID']; ?>" <?php if ($header['TujuanAkhir'] == $us['ID'] || $defRoute['TujuanAkhir'] == $us['ID']) { ?> selected="selected" <?php } ?>><?php echo $us['Nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>                                    
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Next Stop</label>
                                        <select id="cmbNextStop" class="form-control select2">
                                          	<?php foreach ($userNextStop as $us): ?>																	
                                                <option value="<?php echo $us['ID']; ?>" <?php if ($header['TujuanBerikut'] == $us['ID'] || $defRoute['TujuanBerikut'] == $us['ID']) { ?> selected="selected" <?php } ?>><?php echo $us['Nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>                                         
                                   	</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                    
                                    <div class="form-group">
                                        <label class="control-label">Route</label>                                        
                                        <select id="cmbRoute" class="select2 m-b-10 select2-multiple" multiple="multiple">
                                          	<?php foreach ($userRoute as $us): ?>																	
                                                <option value="<?php echo $us['ID']; ?>" <?php if (in_array($us['ID'],$arrRoute)) { ?> selected="selected" <?php } ?>><?php echo $us['Nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>                                                                            
                                   	</div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Notes</label>
                                        <input type="text" id="txtNotesHeader" class="form-control" value="<?php print $header['Keterangan']; ?>">
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Confidential</label>
                                        <select id="cmbConfidential" class="form-control select2">
                                        	<option value="-" <?php if ($header['Confidential'] == '-') { ?> selected="selected" <?php } ?>>--- Please select Confidential ---</option>
                                            <option value="1" <?php if ($header['Confidential'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                            <option value="2" <?php if ($header['Confidential'] == '2') { ?> selected="selected" <?php } ?>>No</option>  
                                        </select>                              
                                   	</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Courier</label>
                                        <select id="cmbCourier" class="form-control select2">
                                          	<?php foreach ($courier as $cr): ?>																	
                                                <option value="<?php echo $cr['ID']; ?>" <?php if ($header['KurirID'] == $cr['ID']) { ?> selected="selected" <?php } ?>><?php echo $cr['Nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>                                              
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                                               
                                   	</div>
                                </div>
                            </div>
                            <div class="row button-box">
                          	    <div class="col-lg-2 col-sm-4 col-xs-12">
                                	<div id="modalDokumen" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="lblAdd">ADD DOCUMENT</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">                                                            <label for="recipient-name" class="control-label">Document No:</label>
                                                            <select id="cmbNoDocument" class="form-control select2">                                                            	<?php foreach ($doc as $dc): ?>																	
                                                                    <option value="<?php echo $dc['ID']; ?>"><?php echo $dc['Nama']; ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="txtRevisi" class="control-label">Revisi:</label>
                                                            <input type="text" class="form-control" id="txtRevisi" value="00" disabled>                                                            
                                                        </div>
                                                        <div class="form-group">   
                                                        	<input type="hidden" class="form-control" id="hidID" />                                                            <label for="recipient-name" class="control-label">Type:</label>
                                                            <select id="cmbType" class="form-control select2">                                                            	<?php foreach ($type as $ty): ?>																	
                                                                    <option value="<?php echo $ty['ID']; ?>"><?php echo $ty['Nama']; ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="txtDesc" class="control-label">Description:</label>
                                                            <input type="text" class="form-control" id="txtDesc">                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="txtNotes" class="control-label">Notes:</label>
                                                            <input type="text" class="form-control" id="txtNotes">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="txtQty" class="control-label">Qty:</label>
                                                            <input type="text" class="form-control" id="txtQty">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="txtAmount" class="control-label">Amount:</label>
                                                            <input type="text" class="form-control" id="txtAmount">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    <button id="btnSave" type="button" class="btn btn-danger waves-effect">Save changes</button>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row button-box">
                          	    <div class="col-lg-2 col-sm-4 col-xs-12">
                                	<div id="modalDokumenStop" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="lblAdd">LIST EXISTING DOCUMENT</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table id="tblDokumenStop" class="table display">
                                                            <thead>
                                                                <tr>                            
                                                                    <th></th>                            
                                                                    <th>Document No</th>
                                                                    <th>Received Date</th>
                                                                    <th>Package No</th>                                            
                                                                    <th>From</th>
                                                                    <th>Type</th>
                                                                    <th>Description</th>
                                                                    <th>Qty</th>
                                                                    <th>Amount</th>
                                                                    <th>Type ID</th>
                                                                    <th>Notes</th>
                                                                    <th>Revisi</th>
                                                              	</tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>                        	
                                                                    <th></th>                            
                                                                    <th>Document No</th>
                                                                    <th>Received Date</th>
                                                                    <th>Package No</th>
                                                                    <th>From</th>   
                                                                    <th>Type</th>
                                                                    <th>Description</th>
                                                                    <th>Qty</th>
                                                                    <th>Amount</th>                                              
                                                                    <th>Type ID</th>
                                                                    <th>Notes</th>
                                                                    <th>Revisi</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>                        
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                    <button id="btnSelect" type="button" class="btn btn-danger waves-effect">Select</button>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                     	<div class="row">
                                            <div class="col-sm-6">
                                                <h3 class="box-title">LIST DOCUMENT</h3>
                                            </div>
                                            <div class="col-sm-4">
                                                <select id="cmbTemplate" class="form-control select2">
													<?php foreach ($template as $tm): ?>																	
                                                        <option value="<?php echo $tm['ID']; ?>"><?php echo $tm['Nama']; ?></option>
                                                    <?php endforeach ?>
                                                </select>   
                                            </div>
                                            <div class="col-sm-2">
                                                <button id="btnApply" class="btn btn-block btn-info btn-rounded"><i class="fa fa-plus"></i> APPLY</button>
                                            </div>
                                        </div>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblDokumen" class="table table-striped">
                                                <thead>
                                                    <tr>                                                        
                                                        <th>No</th>
                                                        <th>Revisi</th>
                                                        <th>Type</th>
                                                        <th style="display:none">Type ID</th>
                                                        <th>Description</th>
                                                        <th>Notes</th>
                                                        <th>Qty</th>
                                                        <th>Amount</th>
                                                        <!--<th style="display:none">No Doc</th>-->
                                                        <th class="text-nowrap">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                               
                                                	<?php for ($i=0;$i<count($detail);$i++) { ?>                                         
                                                	<tr id="trDok<?php print ($i+1); ?>">
                                                    	<td><?php print $detail[$i]["No"]; ?></td>
                                                        <td><?php print $detail[$i]["Revisi"]; ?></td>
                                                        <td><?php print $detail[$i]["Jenis"]; ?></td>
                                                        <td style="display:none"><?php print $detail[$i]["JenisID"]; ?></td>
                                                        <td><?php print $detail[$i]["Deskripsi"]; ?></td>
                                                        <td><?php print $detail[$i]["Keterangan"]; ?></td>
                                                        <td><?php print $detail[$i]["Jumlah"]; ?></td>
                                                        <td><?php print $detail[$i]["Nominal"]; ?></td>
                                                        <!--<td style="display:none"><?php print $detail[$i]["No"]; ?></td>-->
                                                        <td class="text-nowrap">                                                           	<a class="btnEdit" data-toggle="modal" href="#modalDokumen"> <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-pencil"></i></button> </a>
                                                        	<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>
                                                       	</td>
                                                    </tr>
                                                	<?php } ?>
                                                </tbody>
                                          	</table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnAdd" class="btn btn-block btn-info btn-rounded" data-toggle="modal" data-target="#modalDokumen"><i class="fa fa-plus"></i> NEW DOCUMENT</button>
                                </div>  
                                <div class="col-sm-2">
                                	<button id="btnAddStop" class="btn btn-block btn-primary btn-rounded" data-toggle="modal" data-target="#modalDokumenStop"><i class="fa fa-plus"></i> EXIST DOCUMENT</button>
                                </div>              
                                <div class="col-sm-4">
                                	<input type="hidden" class="form-control" id="hidIndex" value="<?php print count($detail); ?>">
                                    <input type="hidden" class="form-control" id="hidIDPaket" value="<?php print $header['ID']; ?>">
                                    <input type="hidden" class="form-control" id="hidNoPaket" value="<?php print $header['No']; ?>">
                                </div>              		
                                <div class="col-sm-2">
                                	<button id="btnDraft" class="btn btn-block btn-danger btn-rounded"><i class="fa fa-floppy-o"></i> SAVE TO DRAFT</button>
                                </div>
                                <div class="col-sm-2">
                                	<button id="btnSend" class="btn btn-block btn-success btn-rounded"><i class="fa fa-envelope-o"></i> SEND PACKAGE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		
		$("#cmbFinalStop").select2();
		$("#cmbNextStop").select2();
		$("#cmbCourier").select2();
		$("#cmbConfidential").select2();
		$("#cmbNoDocument").select2();	
		$("#cmbType").select2();		
		$("#cmbTemplate").select2();		
		$("#cmbRoute").select2({ 
			allowRepetitionForMultipleSelect: true
		});
		
		<?php if ($header['ID'] > 0) { ?>
		var selected = [
		<?php for ($i=0;$i<count($arrRoute);$i++) { ?>
			{id: <?php print $arrRoute[$i]; ?>, text: '<?php print $arrNamaRoute[$i]; ?>'},			
		<?php } ?>				
		];							
		$("#cmbRoute").select2('data', selected);
		<?php } else if ($this->session->userdata('route') <> NULL) { ?>
		var selected = [
		<?php for ($i=0;$i<count($arrDefaultRoute);$i++) { ?>
			{id: <?php print $arrDefaultRoute[$i]; ?>, text: '<?php print $arrNamaDefaultRoute[$i]; ?>'},			
		<?php } ?>				
		];							
		$("#cmbRoute").select2('data', selected);
		<?php } ?>
				
		var table = $('#tblDokumenStop').DataTable({
			"pageLength" : 10,
			"ajax": {
				url : "<?php echo base_url();?>admin/createnew/get_list_stop",
				type : 'POST'
			},
			'columnDefs': [
			  {
				 'targets': 0,				
				 'render': function (data, type, full, meta){
					 return '<input type="checkbox" name="id[]" value="' 
						+ $('<div/>').text(data).html() + '">';
				 }
			  },
			  {
                "targets": [ 9,10,11 ],
                "visible": false
            }        
		   ],		   
		   'order': [[1, 'asc']]
		});	
									
		$("#btnSave").click(function() {			
			var typeid = $("#cmbType").val();
			var type = $("#cmbType option:selected").text();
			var desc = $("#txtDesc").val();
			var notes = $("#txtNotes").val();
			var qty = $("#txtQty").val();
			var amount = $("#txtAmount").val();
			var nodoc = $("#cmbNoDocument").val();
			var revisi = $("#txtRevisi").val();
			
			if (desc.trim() == '')
			{
				swal('Warning','Please enter description','warning');
				$("#txtDesc").focus();
				return false;
			}
			else if (qty.trim() == '')
			{
				swal('Warning','Please enter Qty','warning');
				$("#txtQty").focus();
				return false;
			}
			else if (amount.trim() == '')
			{
				swal('Warning','Please enter Amount','warning');
				$("#txtAmount").focus();
				return false;
			}
			else
			{
				if ($("#lblAdd").html() == "ADD DOCUMENT")
				{
					var idx = parseInt($("#hidIndex").val()) + 1;					
					$("#tblDokumen tbody:last-child").append(
						'<tr id="trDok' + idx +'">' +					
							'<td>' + nodoc + '</td>' +
							'<td>' + revisi + '</td>' +
							'<td>' + type + '</td>' +
							'<td style="display:none">' + typeid + '</td>' +
							'<td>' + desc + '</td>' +
							'<td>' + notes + '</td>' +
							'<td>' + qty + '</td>' +
							'<td>' + amount + '</td>' +
							'<td class="text-nowrap">' + 
								'<a class="btnEdit" data-toggle="modal" href="#modalDokumen"> <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-pencil"></i></button> </a>' +
								'<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
							'</td>' +
						'</tr>'
					);
					$("#hidIndex").val(idx); 
				}
				else if ($("#lblAdd").html() == "EDIT DOCUMENT")
				{
					var ID = $("#hidID").val();
					if (nodoc == null)
					{
						nodoc = '-';
					}
					var newHtml = '<td>' + nodoc + '</td>' +
							'<td>' + revisi + '</td>' +
							'<td>' + type + '</td>' +
							'<td style="display:none">' + typeid + '</td>' +
							'<td>' + desc + '</td>' +
							'<td>' + notes + '</td>' +
							'<td>' + qty + '</td>' +
							'<td>' + amount + '</td>' +
							'<td class="text-nowrap">' + 
								'<a class="btnEdit" data-toggle="modal" href="#modalDokumen"> <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-pencil"></i></button> </a>' +
								'<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
							'</td>';
					$('#trDok' + ID).html(newHtml);
					$('#modalDokumen').modal('toggle'); 
				}
						
				$('#cmbNoDocument').val('-').trigger('change');
				//$("#cmbNoDocument").select2('data', { id: '-', text: 'New Document'});		
				$("#txtRevisi").val('00');						
				$("#txtDesc").val('');
				$("#txtNotes").val('');
				$("#txtQty").val('');
				$("#txtAmount").val('');
				$("#hidID").val('');
				$('#cmbType').val('-').trigger('change');
				//$("#cmbType").select2('data', { id: '-', text: '--- Please select Type ---'});	
				
				//$("#txtDesc").removeAttr('disabled');						
				$("#txtQty").removeAttr('disabled');			
				//$("#txtAmount").removeAttr('disabled');					
				$("#cmbType").removeAttr('disabled');	
			}			
			
			
		});	
		
		 $("#tblDokumen").on('click','.btnEdit',function(){
			 // get the current row
			 var currentRow = $(this).closest("tr"); 
			 var idx = $(this).closest("tr").attr("id"); 
			 
			 var nodoc = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
			 var revisi = currentRow.find("td:eq(1)").text(); // get current row 1st TD value
			 var type = currentRow.find("td:eq(2)").text(); 
			 var typeid = currentRow.find("td:eq(3)").text(); 
			 var desc = currentRow.find("td:eq(4)").text(); 
			 var notes = currentRow.find("td:eq(5)").text(); 
			 var qty = currentRow.find("td:eq(6)").text(); 
			 var amount = currentRow.find("td:eq(7)").text(); 
			
			 if (nodoc == '-')
			 {
				 $('#cmbNoDocument').val('-').trigger('change');
				 //$("#cmbNoDocument").select2('data', { id: '-', text:'New Document'});	
				 //$("#txtDesc").removeAttr('disabled');						
				 $("#txtQty").removeAttr('disabled');			
				 //$("#txtAmount").removeAttr('disabled');					
				 $("#cmbType").removeAttr('disabled');	
			 }
			 else
			 {
				 $('#cmbNoDocument').val(nodoc).trigger('change');
				 //$("#cmbNoDocument").select2('data', { id: nodoc, text: nodoc + ' - ' + desc});	
				 //$("#txtDesc").attr('disabled','disabled');						
				 $("#txtQty").attr('disabled','disabled');			
				 //$("#txtAmount").attr('disabled','disabled');			
				 $("#cmbType").attr('disabled','disabled');
			 }			 
			 $("#txtRevisi").val(revisi);	
			 $('#cmbType').val(typeid).trigger('change');		 		 
			 //$("#cmbType").select2('data', { id: typeid, text: type});		
			 $("#txtDesc").val(desc);
			 $("#txtNotes").val(notes);
			 $("#txtQty").val(qty);
			 $("#txtAmount").val(amount);		 
			 
			 $("#hidID").val(idx.substring(5)); //get number after trDok
			 $("#lblAdd").html("EDIT DOCUMENT");
		});		
		
		$("#btnAdd").click(function() {		
			$('#cmbNoDocument').val('-').trigger('change');		
			//$("#cmbNoDocument").select2('data', { id: '-', text: 'New Document'});		
			$("#txtRevisi").val('00');		
			$("#txtDesc").val('');
			$("#txtNotes").val('');
			$("#txtQty").val('');
			$("#txtAmount").val('');
			$('#cmbType').val('-').trigger('change');
			//$("#cmbType").select2('data', { id: '-', text: '--- Please select Type ---'});		
			//$("#txtDesc").removeAttr('disabled');						
			$("#txtQty").removeAttr('disabled');			
			//$("#txtAmount").removeAttr('disabled');					
			$("#cmbType").removeAttr('disabled');	
			$("#lblAdd").html("ADD DOCUMENT");
		});	
		
		$("#tblDokumen").on('click','.btnDel',function(){
			$(this).closest('tr').remove();			
		});	
		
		function storeTblValues()
		{
			var TableData = new Array();
		
			$('#tblDokumen tr').each(function(row, tr){
				TableData[row]={
					"no" : $(tr).find('td:eq(0)').text()
					, "revisi" : $(tr).find('td:eq(1)').text()
					, "typeid" : $(tr).find('td:eq(3)').text()
					, "desc" :$(tr).find('td:eq(4)').text()
					, "notes" : $(tr).find('td:eq(5)').text()
					, "qty" : $(tr).find('td:eq(6)').text()
					, "amount" : $(tr).find('td:eq(7)').text()
				}    
			}); 
			TableData.shift();  // first row will be empty - so remove			
			return TableData;
		}
		
		$("#cmbNoDocument").change(function() {		
			var no = $("#cmbNoDocument").val();		
			if (no == '-')
			{
				$("#txtRevisi").val('00');
				$("#txtDesc").val('');
				$("#txtNotes").val('');
				$("#txtQty").val('');
				$("#txtAmount").val('');	
				
				//$("#txtDesc").removeAttr('disabled');						
				$("#txtQty").removeAttr('disabled');			
				//$("#txtAmount").removeAttr('disabled');					
				$("#cmbType").removeAttr('disabled');					
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>admin/createnew/getNoDocument",
					data: "no=" + no,
					dataType: 'json',
					success: function(data){																
						$("#txtRevisi").val(data[0]['Revisi']);
						$("#txtDesc").val(data[0]['Deskripsi']);
						$("#txtNotes").val(data[0]['Keterangan']);
						$("#txtQty").val(data[0]['Jumlah']);
						$("#txtAmount").val(data[0]['Nominal']);
						$('#cmbType').val(data[0]['Jenis']).trigger('change');
						//$("#cmbType").select2('data', { id: data[0]['Jenis'], text: data[0]['JenisNama']});		
						
						//$("#txtDesc").attr('disabled','disabled');						
						$("#txtQty").attr('disabled','disabled');			
						//$("#txtAmount").attr('disabled','disabled');			
						$("#cmbType").attr('disabled','disabled');			
					},
					error: function(jqXHR, textStatus, errorThrown ){
						swal("Error", errorThrown, "error");
					}
				});
			}			
		});	
		
		$("#btnSend").click(function() {						
			var rowCount = $('#tblDokumen tr').length;		
			var route = $("#cmbRoute").select2('data');
			var nextStop = $("#cmbNextStop").val();
			var finalStop = $("#cmbFinalStop").val();
			var courier = $("#cmbCourier").val();
			var confidential = $("#cmbConfidential").val();
			
			table.ajax.reload();	
			var cekDokStop = true;		
			for (var i=1;i<rowCount;i++)
			{
				var nodok = $('#tblDokumen').find("tr:eq("+ i +")").find("td:eq(0)").text();
				if (nodok != '-')
				{
					var ok = false;
					for (var j=0;j<table.rows().count();j++)
					{
						var rowData = table.row(j).data();	
						var nodokstop = rowData[1];											
						if (nodok == nodokstop)
						{												
							ok = true;
						}					
					}
					if (ok == false)
					{
						cekDokStop = false;
						break;
					}	
				}				
			}
			
			if (rowCount == 1)
			{
				swal('Warning','Please add document','warning');				
				return false;
			}			
			else if (route == null)
			{
				swal('Warning','Please select Route','warning');				
				return false;
			}	
			else if (nextStop == '-')
			{
				swal('Warning','Please select Next Stop','warning');				
				return false;
			}		
			else if (finalStop == '-')
			{
				swal('Warning','Please select Final Stop','warning');				
				return false;
			}		
			else if (courier == '-')
			{
				swal('Warning','Please select Courier','warning');				
				return false;
			}		
			else if (confidential == '-')
			{
				swal('Warning','Please select Confidential','warning');				
				return false;
			}		
			else if (cekDokStop == false)
			{
				swal('Warning','Document no ' + nodok + ' is not valid','warning');				
				return false;
			}		
			else
			{
				swal({
				  title: "Warning",
				  text: "Are you sure ?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Yes, send it!",
				  closeOnConfirm: false
				},
				function(){
					var data= new Object();
					
					
					var TableData;
					TableData = storeTblValues();
					TableData = $.toJSON(TableData);	
					data["detail"]  = TableData;
					
					var arrRoute = '';
					for (var i=0;i<route.length;i++)
					{
						arrRoute = arrRoute + route[i]['id'] + 'D,';						
					}
					arrRoute = arrRoute.substring(0,arrRoute.length-1);
					
					var v_data = {};
					v_data.finalStop = $("#cmbFinalStop").val();
					v_data.nextStop = $("#cmbNextStop").val();
					v_data.notes = $("#txtNotesHeader").val();
					v_data.courier = $("#cmbCourier").val();
					v_data.route = arrRoute;
					v_data.confidential = $("#cmbConfidential").val();
					v_data.id = $("#hidIDPaket").val();
					v_data.no = $("#hidNoPaket").val();					
					
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/createnew/send",
						data: {data:JSON.stringify(data)},
						dataType: 'json',
						success: function(jsonData){						
							
							if (jsonData.responseCode=="200"){
								table.ajax.reload();
								swal({
									title: "Save Success",allowEscapeKey:false,
									text: jsonData.responseMsg, type: "success",
									confirmButtonText: "OK", closeOnConfirm: false
								});         
								if ($("#hidIDPaket").val() > 0)
								{
									location.href="<?php echo base_url();?>admin/draft/list_draft";		
								}
								else
								{
									$('#tblDokumen tbody').html('');
									$("#txtNotesHeader").val('');
									$('#cmbNextStop').val('-').trigger('change');
									$('#cmbFinalStop').val('-').trigger('change');
									$('#cmbConfidential').val('-').trigger('change');
									$('#cmbCourier').val('-').trigger('change');
									$('#cmbRoute').val(null).trigger('change');										
								}								
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
			
			
		});	
		
		$("#cmbRoute").on("change", function (e) {
			
			//this returns all the selected item
			var items = $(this).select2('data');    
			
			if (items == null) 
			{
				$('#cmbNextStop').val('-').trigger('change');
				$('#cmbFinalStop').val('-').trigger('change');
			}
			else
			{
				$('#cmbNextStop').val(items[0]['id']).trigger('change');
				$('#cmbFinalStop').val(items[items.length-1]['id']).trigger('change');
			}	
			
		
		});			
		
		$('#btnSelect').on('click', function(e){	
			var ok = false;			 	
			table.$('input[type="checkbox"]').each(function(){
				if(this.checked){
					var currentRow = $(this).closest("tr"); 				   
				   	var data = $('#tblDokumenStop').DataTable().row(currentRow).data();
					var cek = true;
					$('#tblDokumen tr').each(function(row, tr){
						if (data[1] == $(tr).find('td:eq(0)').text())
						{
							cek = false
						}
					}); 
					if (cek == true)
					{
						ok = true;
				   	    			   					   
						var idx = parseInt($("#hidIndex").val()) + 1;					
						$("#tblDokumen tbody:last-child").append(
							'<tr id="trDok' + idx +'">' +					
								'<td>' + data[1] + '</td>' +
								'<td>' + data[11] + '</td>' +
								'<td>' + data[5] + '</td>' +
								'<td style="display:none">' + data[9] + '</td>' +
								'<td>' + data[6] + '</td>' +
								'<td>' + data[10] + '</td>' +
								'<td>' + data[7] + '</td>' +
								'<td>' + data[8] + '</td>' +
								'<td class="text-nowrap">' + 
									'<a class="btnEdit" data-toggle="modal" href="#modalDokumen" data-toggle="tooltip" data-original-title="Edit"> <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-pencil"></i></button> </a>' +
									'<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
								'</td>' +
							'</tr>'
						);
						$("#hidIndex").val(idx);
					}					
					
				}				 
		 	});
						
			if (ok == true)
			{
				$('#modalDokumenStop').modal('toggle');		
			}
			else
			{
				swal('Warning','Please choose existing document','warning');
				return false;
			}
	   	});	
		
		$("#btnDraft").click(function() {	
			var rowCount = $('#tblDokumen tr').length;		
			var route = $("#cmbRoute").select2('data');
			var nextStop = $("#cmbNextStop").val();
			var finalStop = $("#cmbFinalStop").val();
			var courier = $("#cmbCourier").val();
			var confidential = $("#cmbConfidential").val();
			
			if (rowCount == 1)
			{
				swal('Warning','Please add document','warning');				
				return false;
			}			
			else if (route == null)
			{
				swal('Warning','Please select Route','warning');				
				return false;
			}	
			else if (nextStop == '-')
			{
				swal('Warning','Please select Next Stop','warning');				
				return false;
			}		
			else if (finalStop == '-')
			{
				swal('Warning','Please select Final Stop','warning');				
				return false;
			}		
			else if (courier == '-')
			{
				swal('Warning','Please select Courier','warning');				
				return false;
			}		
			else if (confidential == '-')
			{
				swal('Warning','Please select Confidential','warning');				
				return false;
			}		
			else
			{
				swal({
				  title: "Warning",
				  text: "Are you sure ?",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-success",
				  confirmButtonText: "Yes, save it!",
				  closeOnConfirm: false
				},
				function(){
					var data= new Object();
					
					
					var TableData;
					TableData = storeTblValues();
					TableData = $.toJSON(TableData);	
					data["detail"]  = TableData;
					
					var arrRoute = '';
					for (var i=0;i<route.length;i++)
					{
						arrRoute = arrRoute + route[i]['id'] + 'D,';					
					}
					arrRoute = arrRoute.substring(0,arrRoute.length-1);
					
					var v_data = {};
					v_data.finalStop = $("#cmbFinalStop").val();
					v_data.nextStop = $("#cmbNextStop").val();
					v_data.notes = $("#txtNotesHeader").val();
					v_data.courier = $("#cmbCourier").val();
					v_data.route = arrRoute;
					v_data.confidential = $("#cmbConfidential").val();
					v_data.id = $("#hidIDPaket").val();
					v_data.no = $("#hidNoPaket").val();					
										
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/createnew/draft",
						data: {data:JSON.stringify(data)},
						dataType: 'json',
						success: function(jsonData){						
							
							if (jsonData.responseCode=="200"){
								table.ajax.reload();
								swal({
									title: "Save Success",allowEscapeKey:false,
									text: jsonData.responseMsg, type: "success",
									confirmButtonText: "OK", closeOnConfirm: false
								});    
								if ($("#hidIDPaket").val() > 0)
								{
									location.href="<?php echo base_url();?>admin/draft/list_draft";		
								}
								else
								{
									$('#tblDokumen tbody').html('');
									$("#txtNotesHeader").val('');
									$('#cmbNextStop').val('-').trigger('change');
									$('#cmbFinalStop').val('-').trigger('change');
									$('#cmbConfidential').val('-').trigger('change');
									$('#cmbCourier').val('-').trigger('change');
									$('#cmbRoute').val(null).trigger('change');
								}															
								
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
			
			
		});
		
		$("#btnApply").click(function() {									
			var template = $("#cmbTemplate").val();
			
			if (template == '-')
			{
				swal('Warning','Please select Template','warning');				
				return false;
			}		
			else
			{
				var data= new Object();	
				var v_data = {};				
				v_data.templateid = $("#cmbTemplate").val();					
				
				data["header"]  = JSON.stringify(v_data);
				
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>admin/createnew/getTemplate",
					data: {data:JSON.stringify(data)},
					dataType: 'json',
					success: function(jsonData){						
						
						if (jsonData['status'] == 'ok')
						{
							for (var i=0;i<jsonData['header'].length;i++)
							{
								var idx = parseInt($("#hidIndex").val()) + 1;					
								$("#tblDokumen tbody:last-child").append(
									'<tr id="trDok' + idx +'">' +					
										'<td>-</td>' +
										'<td>00</td>' +
										'<td>' + jsonData['header'][i].JenisNama + '</td>' +
										'<td style="display:none">' + jsonData['header'][i].Jenis + '</td>' +
										'<td>' + jsonData['header'][i].Deskripsi + '</td>' +
										'<td>' + jsonData['header'][i].Keterangan + '</td>' +
										'<td>' + jsonData['header'][i].Jumlah + '</td>' +
										'<td>' + jsonData['header'][i].Nominal + '</td>' +										
										'<td class="text-nowrap">' + 
											'<a class="btnEdit" data-toggle="modal" href="#modalDokumen" data-toggle="tooltip" data-original-title="Edit"> <button type="button" class="btn btn-info btn-circle btn-xs"><i class="fa fa-pencil"></i></button> </a>' +
											'<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
										'</td>' +
									'</tr>'
								);
								$("#hidIndex").val(idx);		
							}													
						}										
					},
					error: function(jqXHR, textStatus, errorThrown ){
						swal("Error", errorThrown, "error");
					}
				});
			}			
			
			
		});		
		
		
	}); 
	
	
 </script>