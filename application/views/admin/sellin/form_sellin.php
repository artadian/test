 <?php 
$header = $data['header']; 
$detail = $data['detail'];
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0"><?php print $page_title; ?></h3>
                            <p class="text-muted m-b-30 font-13"></p>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Sellin No</label>    
                                        <input type="text" id="txtNo" class="form-control" value="<?php print $header['sellinno']; ?>"<?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>                                    
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Sales Office</label>
                                        <select id="cmbSalesOffice" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
										<?php foreach ($salesoffice as $so): ?>																	
                                            <option value="<?php echo $so['id']; ?>" <?php if ($so['id'] == $header['salesofficeid']) { ?> selected="selected" <?php } ?>><?php echo $so['name']; ?></option>
                                        <?php endforeach ?>							
                                        </select>                	
                                    </div>
                                </div>
                            </div>                                                                              
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Sellin Date</label>
                                        <input class="form-control" type="date" id="rdpTanggal" value="<?php print $header['sellindate']; ?>" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?> >                        
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Salesman</label>
                                        <select id="cmbSalesman" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
										<?php foreach ($salesman as $sm): ?>																	
                                            <option value="<?php echo $sm['userid']; ?>" <?php if ($sm['userid'] == $header['userid']) { ?> selected="selected" <?php } ?>><?php echo $sm['name']; ?></option>
                                        <?php endforeach ?>									
                                        </select>                                           
                                   	</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Region</label>
                                        <select id="cmbRegion" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>
											<?php foreach ($region as $rg): ?>																	
                                                <option value="<?php echo $rg['id']; ?>" <?php if ($rg['id'] == $header['regionid']) { ?> selected="selected" <?php } ?>><?php echo $rg['name']; ?></option>
                                            <?php endforeach ?>
                                        </select>   
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Customer</label>
                                        <select id="cmbCustomer" class="form-control select2" <?php if ($header['id'] > 0 || $mode == 'view') { ?> disabled="disabled" <?php } ?>>			
                                        <?php foreach ($customer as $ct): ?>																	
                                            <option value="<?php echo $ct['customerno']; ?>" <?php if ($ct['customerno'] == $header['customerno']) { ?> selected="selected" <?php } ?>><?php echo $ct['name']; ?></option>
                                        <?php endforeach ?>									
                                        </select>                                           
                                   	</div>
                                </div>
                            </div>                                                                                                                             
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h3 class="box-title">LIST MATERIAL</h3>
                                            </div>                                            
                                            <div class="col-sm-2">
                                                <button id="btnAdd" class="btn btn-block btn-info btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>><i class="fa fa-plus"></i> ADD</button>
                                            </div>
                                        </div>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblMaterial" class="table table-striped color-table primary-table">
                                                <thead>
                                                    <tr>                                                   	      
                                                        <th style="width:25%">Material</th>          
                                                        <th style="width:12%; display:none">PriceID</th>
                                                        <th style="width:12%">Price</th>
                                                        <th style="width:12%; display:none">Price</th>
                                                        <th style="width:12%; display:none">BAL ID</th>
                                                        <th style="width:12%; display:none">SLOF ID</th>                     
                                                        <th style="width:7%">BAL</th>          
                                                        <th style="width:7%">SLOF</th>                                         
                                                        <th style="width:7%">PAC</th>
                                                        <th style="width:10%">Total PAC</th>
                                                        <th style="width:12%; display:none">Qty Order</th>                     
                                                        <th style="width:12%; display:none">Qty Bonus</th>   
                                                        <th style="width:12%; display:none">Cust Introdeal</th>                     
                                                        <th style="width:7%">Introdeal</th>
                                                        <th style="width:15%">Total Price</th> 
                                                        <th style="width:12%; display:none">Total Price</th>           
                                                        <th style="width:12%; display:none">ID</th>           
                                                        <th class="text-nowrap" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>Action</th>	                                                    
                                                	</tr>                                                    
                                                </thead>
                                                <tbody>                                                    	                                                   	<?php for ($i=0;$i<count($detail);$i++) { ?>                                         			<tr id="trMat<?php print ($i+1); ?>">					
                                                        <td>
                                                            <select id="cmbMaterial<?php print ($i+1); ?>" class="form-control select2" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>> 
                                                            <?php foreach ($material as $mt): ?>																	
                                                                <option value="<?php echo $mt['id']; ?>" <?php if ($mt['id'] == $detail[$i]["materialid"]) { ?> selected="selected" <?php } ?>><?php echo $mt['name']; ?></option>
                                                            <?php endforeach ?>
                                                            </select>  
                                                        </td>        
                                                        <td style="display:none">
                                                            <input type="text" id="txtPriceID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $header['priceid']; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="txtPrice<?php print ($i+1); ?>" class="form-control text-right" disabled="disabled" value="<?php print number_format($detail[$i]['price']); ?>">
                                                        </td>  
                                                        <td style="display:none">
                                                            <input type="text" id="txtPriceAsli<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['price']; ?>">
                                                        </td>  
                                                        <td style="display:none">
                                                            <input type="text" id="txtBalID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['balid']; ?>">
                                                        </td>    
                                                        <td style="display:none">
                                                            <input type="text" id="txtSlofID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['slofid']; ?>">
                                                        </td>      					                                           
                                                        <td>
                                                            <input type="text" id="txtBal<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['bal']; ?>" onkeypress="return isNumber(event)" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                                        </td>          
                                                        <td>
                                                            <input type="text" id="txtSlof<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['slof']; ?>" onkeypress="return isNumber(event)" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                                        </td>                                                        
                                                        <td>
                                                            <input type="text" id="txtPac<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['pac']; ?>" onkeypress="return isNumber(event)" <?php if ($mode == 'view') { ?> disabled="disabled" <?php } ?>>
                                                        </td>
                                                        <td>
                                                            <input type="text" id="txtTotalPac<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['qty']; ?>" disabled="disabled">
                                                        </td>
                                                        <td style="display:none">
                                                            <input type="text" id="txtQtyOrder<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['qtyorder']; ?>">
                                                        </td>
                                                        <td style="display:none">
                                                            <input type="text" id="txtQtyBonus<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['qtybonus']; ?>">
                                                        </td> 
                                                        <td style="display:none">
                                                            <input type="text" id="txtCustIntrodeal<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['custintrodeal']; ?>">
                                                        </td> 
                                                        <td>
                                                            <input type="text" id="txtQtyIntrodeal<?php print ($i+1); ?>" class="form-control text-right" value="<?php print $detail[$i]['qtyintrodeal']; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="txtTotalPrice<?php print ($i+1); ?>" class="form-control text-right" disabled="disabled" value="<?php print number_format($detail[$i]['sellinvalue']); ?>">
                                                        </td>
                                                        <td style="display:none">
                                                            <input type="text" id="txtTotalPriceAsli<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['sellinvalue']; ?>">
                                                        </td>  
                                                        <td style="display:none">
                                                            <input type="text" id="txtID<?php print ($i+1); ?>" class="form-control" disabled="disabled" value="<?php print $detail[$i]['id']; ?>">
                                                        </td> 
                                                        <td class="text-nowrap" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>
                                                            <a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>
                                                        </td>
                                                    </tr>                                                	
                                                	<?php } ?>
                                                </tbody>  
                                                <tfoot class="bg-primary text-white">
                                                    <tr>                                                   	      
                                                        <td colspan="7" align="right"><strong>TOTAL</strong></td>
                                                        <td>
                                                        	<input type="text" id="txtTotal" class="form-control text-right" disabled="disabled" value="<?php print number_format($header['amount']); ?>">                                                            
                                                        </td>                                    
                                                        <td <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>
                     										<input type="text" id="txtTotalAsli" class="form-control" value="<?php print $header['amount']; ?>" style="display:none">                                   	
                                                        </td>	    
                                                 	</tr>                                                    
                                                </tfoot>                                             
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->                                                              
                                                                      
                            <div class="row">
                            	<div class="col-sm-2">
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-8">
									<input type="hidden" class="form-control" id="hidID" value="<?php print $header['id']; ?>">		
                                    <input type="text" class="form-control" id="hidIndex" value="<?php print count($detail); ?>">	
                                    <input type="hidden" class="form-control" id="hidPriceID" value="<?php print $header['priceid']; ?>">		                                    
                                </div>
                                <div class="col-sm-2">                                    
                                    <button id="btnSubmit" class="btn btn-block btn-success btn-rounded" <?php if ($mode == 'view') { ?> style="display:none" <?php } ?>>SUBMIT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
	var arrMaterial;
	
	function formatNumber(num) {
	  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	}
	
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}

 	function FillSalesOffice()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getSalesOffice",
			data:  {id: $("#cmbRegion").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				$('#cmbSalesOffice').html(html);	
				$('#cmbSalesOffice').val("-").trigger('change');				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillSalesman()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getSalesman",
			data:  {id: $("#cmbSalesOffice").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].userid+'>'+data[i].name+'</option>';
				}
				$('#cmbSalesman').html(html);	
				$('#cmbSalesman').val("-").trigger('change');				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillCustomer()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getCustomerbydate",
			data:  {id: $("#cmbSalesman").val(), date: $("#rdpTanggal").val()},
			dataType: 'json',
			success: function(data){																
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].customerno+'>'+data[i].name+'</option>';
				}
				$('#cmbCustomer').html(html);	
				$('#cmbCustomer').val("-").trigger('change');					
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}

	function FillMaterial()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getMaterial",
			data:  {id: $("#cmbSalesOffice").val()},
			dataType: 'json',
			success: function(data){																				
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
				}
				arrMaterial = html;				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillPriceID()
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getPriceID",
			data:  {id: $("#cmbCustomer").val()},
			dataType: 'json',
			success: function(data){	
				var priceid;																			
				if (data.length > 0)
				{
					priceid = data[0].priceid;
				}
				else
				{
					priceid = '';
				}
				$("#hidPriceID").val(priceid);
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillPrice(idx)
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getPrice",
			data:  {materialid: $("#cmbMaterial" + idx).val(), priceid: $("#txtPriceID" + idx).val(), tgl: $("#rdpTanggal").val()}, 
			dataType: 'json',
			success: function(data){																				
				var price;																			
				if (data.length > 0)
				{
					price = data[0].value;
				}
				else
				{
					price = '0';
				}				
				$("#txtPriceAsli" + idx).val(price);
				$("#txtPrice" + idx).val(formatNumber(price));
				FillBalSlofPac(idx);													
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillBalSlofPac(idx)
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getBalSlofPac",
			data:  {materialid: $("#cmbMaterial" + idx).val()}, 
			dataType: 'json',
			success: function(data){																									
				var bal;																			
				var slof;
				if (data.length > 0)
				{
					bal = data[0].bal;
					slof = data[0].slof;
				}
				else
				{
					bal = '0';
					slof = '0';
				}								
				$("#txtBalID" + idx).val(bal);
				$("#txtSlofID" + idx).val(slof);
				FillTotalPac(idx);	
				FillTotalPrice(idx);
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillTotalPac(idx)
	{			
		var totalpac = parseInt($("#txtBalID" + idx).val() * $("#txtBal" + idx).val()) + parseInt($("#txtSlofID" + idx).val() * $("#txtSlof" + idx).val()) + parseInt($("#txtPac" + idx).val());
		$("#txtTotalPac" + idx).val(totalpac);
	}
	
	function FillTotalPrice(idx)
	{			
		var totalprice = parseInt($("#txtTotalPac" + idx).val() * $("#txtPriceAsli" + idx).val());
		$("#txtTotalPriceAsli" + idx).val(totalprice);
		$("#txtTotalPrice" + idx).val(formatNumber(totalprice));
		FillTotal();
	}
	
	function FillIntrodeal(idx)
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getIntrodeal",
			data:  {materialid: $("#cmbMaterial" + idx).val(), salesofficeid: $("#cmbSalesOffice").val(), tgl: $("#rdpTanggal").val()},
			dataType: 'json',
			success: function(data){				
				var qtyorder;																			
				if (data.length > 0)
				{
					qtyorder = data[0].qtyorder;
					qtybonus = data[0].qtybonus;
				}
				else
				{
					qtyorder = '0';
					qtybonus = '0';
				}
				$("#txtQtyOrder" + idx).val(qtyorder);
				$("#txtQtyBonus" + idx).val(qtybonus);
				FillCustIntrodeal(idx);	
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillCustIntrodeal(idx)
	{		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>admin/sellin/getCustIntrodeal",
			data:  {materialid: $("#cmbMaterial" + idx).val(), customerno: $("#cmbCustomer").val()},
			dataType: 'json',
			success: function(data){					
				var custintrodeal;																			
				if (data.length > 0)
				{
					custintrodeal = "Y";
				}
				else
				{
					custintrodeal = "N";
				}
				$("#txtCustIntrodeal" + idx).val(custintrodeal);	
				FillQtyIntrodeal(idx);				
			},
			error: function(jqXHR, textStatus, errorThrown ){
				swal("Error", errorThrown, "error");
			}
		});
	}
	
	function FillQtyIntrodeal(idx)
	{	
		if ($("#txtCustIntrodeal" + idx).val() != 'Y' && parseInt($("#txtQtyBonus" + idx).val()) > 0)
		{
			if (parseInt($("#txtTotalPac" + idx).val()) >= parseInt($("#txtQtyOrder" + idx).val()))
			{
				$("#txtQtyIntrodeal" + idx).val($("#txtQtyBonus" + idx).val());
			}
			else
			{
				$("#txtQtyIntrodeal" + idx).val('0');
			}
		}
		else
		{
			$("#txtQtyIntrodeal" + idx).val('0');
		}
	}
	
	function FillTotal()
	{			
		var total = 0;
		$('#tblMaterial tbody tr').each(function(row, tr){			
			total += parseInt($(tr).find("td:eq(15) input[type='text']").val());				
		}); 		
		$("#txtTotalAsli").val(total);
		$("#txtTotal").val(formatNumber(total));
	}
		
 	$(document).ready(function(){			
				
		$("#cmbRegion").select2();
		$("#cmbSalesOffice").select2();
		$("#cmbSalesman").select2();
		$("#cmbCustomer").select2();
		
		<?php if ($header['id'] == '') { ?>
		FillSalesOffice();	
		<?php } ?>
		
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/sellin/list_sellin";				
		});		 	
				
		$("#btnSubmit").click(function() {	
			var rowCount = $('#tblMaterial tr').length;		
			var sellinno = $("#txtNo").val();			
			var sellindate = $("#rdpTanggal").val();
			var customer = $("#cmbCustomer").val();			
			
			var cekMatDouble = true;	
			var materialDouble = '';	
			for (var i=1;i<rowCount-1;i++)
			{
				var materialid = $('#tblMaterial').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();
				if (materialid != '-')
				{
					if (i < rowCount-2)
					{
						var ok = false;
						for (var j=(i+1);j<rowCount-1;j++)
						{
							var materialcek = $('#tblMaterial').find("tr:eq("+ j +")").find("td:eq(0)").find('option:selected').val();	
							if (materialcek != '-')
							{
								if (materialid == materialcek)
								{												
									ok = true;									
									break;
								}			
							}									
						}
						if (ok == true)
						{
							cekMatDouble = false;
							materialDouble = materialid;
							break;
						}		
					}					
				}					
			}
			
			var barisKosong = '';
			for (var i=1;i<rowCount-1;i++)
			{
				var materialid = $('#tblMaterial').find("tr:eq("+ i +")").find("td:eq(0)").find('option:selected').val();
				var totalpac = $('#tblMaterial').find("tr:eq("+ i +")").find("td:eq(9) input[type='text']").val();
				var totalprice = $('#tblMaterial').find("tr:eq("+ i +")").find("td:eq(15) input[type='text']").val();
				if (materialid == '-' || parseInt(totalpac) == 0 || parseInt(totalprice) == 0)
				{
					barisKosong = i;
					break;
				}
			}
			
			if (sellinno.trim() == '')
			{
				swal('Warning','Please enter Sellin No','warning');				
				return false;
			}					
			else if (sellindate == '')
			{
				swal('Warning','Please enter Sellin Date','warning');				
				return false;
			}	
			else if (customer == '-')
			{
				swal('Warning','Please select Customer','warning');				
				return false;
			}	
			else if (rowCount == 2)
			{
				swal('Warning','Please add material','warning');				
				return false;
			}		
			else if (cekMatDouble == false && rowCount > 3)
			{
				swal('Warning','Double material no ' + materialDouble,'warning');				
				return false;
			}			
			else if (barisKosong != '')
			{
				swal('Warning','Please enter Material, Bal, Slof, Pac at row ' + barisKosong,'warning');				
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
				  confirmButtonText: "Yes, submit it!",
				  closeOnConfirm: false
				},
				function(){
					var data= new Object();
					
					var TableData;
					TableData = storeTblValues();
					TableData = $.toJSON(TableData);	
					data["detail"]  = TableData;
						
					var v_data = {};				
					v_data.id = $("#hidID").val();
					v_data.sellinno = $("#txtNo").val();
					v_data.userid = $("#cmbSalesman").val();	
					v_data.customerno = $("#cmbCustomer").val();				
					v_data.sellindate = $("#rdpTanggal").val();
					v_data.total = $("#txtTotalAsli").val();
										
					data["header"]  = JSON.stringify(v_data);
					
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/sellin/save",
						data: {data:JSON.stringify(data)},
						dataType: 'json',
						success: function(jsonData){						
							
							if (jsonData.responseCode=="200"){
								swal({
									title: "Save Success",allowEscapeKey:false,
									text: jsonData.responseMsg, type: "success",
									confirmButtonText: "OK", closeOnConfirm: false
								},
									function () {
										location.href="<?php echo base_url();?>admin/sellin/list_sellin";		
								});                   							
								
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
				
		function storeTblValues()
		{
			var TableData = new Array();
		
			$('#tblMaterial tbody tr').each(function(row, tr){
				TableData[row]={
					"materialid" : $(tr).find('td:eq(0)').find('option:selected').val(),
					"bal" : $(tr).find('td:eq(6) input[type="text"]').val(),					
					"slof" : $(tr).find('td:eq(7) input[type="text"]').val(),
					"pac" : $(tr).find('td:eq(8) input[type="text"]').val(),
					"qty" : $(tr).find('td:eq(9) input[type="text"]').val(),
					"qtyintrodeal" : $(tr).find('td:eq(13) input[type="text"]').val(),
					"price" : $(tr).find('td:eq(3) input[type="text"]').val(),
					"sellinvalue" : $(tr).find('td:eq(15) input[type="text"]').val(),
					"id" : $(tr).find('td:eq(16) input[type="text"]').val(),			
				}    
			}); 
			//TableData.shift();  // first row will be empty - so remove	
			console.log(TableData);					
			return TableData;
		}	
		
		<?php if ($header['id'] == '') { ?>
		$("#cmbRegion").change(function() {		
			FillSalesOffice();
		});	
		
		$("#cmbSalesOffice").change(function() {		
			FillSalesman();
			FillMaterial();
		});	
		
		$("#rdpTanggal").change(function() {		
			FillCustomer();
		});
		
		$("#cmbSalesman").change(function() {		
			FillCustomer();
		});	
		
		$("#cmbCustomer").change(function() {		
			FillPriceID();			
			$('#tblMaterial tbody').html('');			
			FillTotal();
		});	
		<?php } ?>
		
		$("#tblMaterial").on('click','.btnDel',function(){
			$(this).closest('tr').remove();		
			FillTotal();	
		});	

		$("#btnAdd").click(function() {				
			if ($("#cmbCustomer").val() == '-')
			{
				swal('Warning','Please select Customer','warning');				
				return false;
			}
			else
			{
				var idx = parseInt($("#hidIndex").val()) + 1;					
				$("#tblMaterial tbody").append(
					'<tr id="trMat' + idx +'">' +					
					'<td>' +
						'<select id="cmbMaterial' + idx +'" class="form-control select2">' + arrMaterial + '</select>' +   
					'</td>' +          
					'<td style="display:none">' +
						'<input type="text" id="txtPriceID' + idx +'" class="form-control" disabled="disabled" value="' + $("#hidPriceID").val() + '">' +
					'</td>' +     
					'<td>' +
						'<input type="text" id="txtPrice' + idx +'" class="form-control text-right" disabled="disabled" value="0">' +
					'</td>' +   
					'<td style="display:none">' +
						'<input type="text" id="txtPriceAsli' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' +  
					'<td style="display:none">' +
						'<input type="text" id="txtBalID' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' +     
					'<td style="display:none">' +
						'<input type="text" id="txtSlofID' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' +      					                                           
					'<td>' +
						'<input type="text" id="txtBal' + idx +'" class="form-control text-right" value="0" onkeypress="return isNumber(event)">' +
					'</td>' +           
					'<td>' +
						'<input type="text" id="txtSlof' + idx +'" class="form-control text-right" value="0" onkeypress="return isNumber(event)">' +
					'</td>' +                                                        
					'<td>' +
						'<input type="text" id="txtPac' + idx +'" class="form-control text-right" value="0" onkeypress="return isNumber(event)">' +
					'</td>' +
					'<td>' +
						'<input type="text" id="txtTotalPac' + idx +'" class="form-control text-right" value="0" disabled="disabled">' +
					'</td>' +
					'<td style="display:none">' +
						'<input type="text" id="txtQtyOrder' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' + 
					'<td style="display:none">' +
						'<input type="text" id="txtQtyBonus' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' + 
					'<td style="display:none">' +
						'<input type="text" id="txtCustIntrodeal' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' + 
					'<td>' +
						'<input type="text" id="txtQtyIntrodeal' + idx +'" class="form-control text-right" value="0">' +
					'</td>' +
					'<td>' +
						'<input type="text" id="txtTotalPrice' + idx +'" class="form-control text-right" disabled="disabled" value="0">' +
					'</td>' +
					'<td style="display:none">' +
						'<input type="text" id="txtTotalPriceAsli' + idx +'" class="form-control" disabled="disabled">' +
					'</td>' +  
					'<td style="display:none">' +
						'<input type="text" id="txtID' + idx +'" value="0" class="form-control" disabled="disabled">' +
					'</td>' +  
					'<td class="text-nowrap">' +
						'<a class="btnDel" href="#" onclick="return false;" data-toggle="tooltip" data-original-title="Delete"> <button type="button" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-close"></i></button> </a>' +
					'</td>' +
					'</tr>'
				);
				$("#hidIndex").val(idx); 
				
				$("#cmbMaterial" + idx).change(function() {						
					FillPrice(idx);				
					FillIntrodeal(idx);													
				});
				
				$("#txtBal" + idx).change(function() {						
					if ($("#txtBal" + idx).val() == '')
					{
						$("#txtBal" + idx).val('0');
					}
					FillTotalPac(idx);
					FillTotalPrice(idx);
					FillQtyIntrodeal(idx);	
				});
				
				$("#txtSlof" + idx).change(function() {	
					if ($("#txtSlof" + idx).val() == '')
					{
						$("#txtSlof" + idx).val('0');
					}					
					FillTotalPac(idx);	
					FillTotalPrice(idx);
					FillQtyIntrodeal(idx);	
				});
				
				$("#txtPac" + idx).change(function() {						
					if ($("#txtPac" + idx).val() == '')
					{
						$("#txtPac" + idx).val('0');
					}
					FillTotalPac(idx);	
					FillTotalPrice(idx);
					FillQtyIntrodeal(idx);	
				});
				
			}						
		});			
		
		<?php for ($i=0;$i<count($detail);$i++) { ?>
		$("#cmbMaterial<?php print ($i+1); ?>").change(function() {						
			FillPrice(<?php print ($i+1); ?>);				
			FillIntrodeal(<?php print ($i+1); ?>);													
		});
		
		$("#txtBal<?php print ($i+1); ?>").change(function() {						
			if ($("#txtBal<?php print ($i+1); ?>").val() == '')
			{
				$("#txtBal<?php print ($i+1); ?>").val('0');
			}
			FillTotalPac(<?php print ($i+1); ?>);
			FillTotalPrice(<?php print ($i+1); ?>);
			FillQtyIntrodeal(<?php print ($i+1); ?>);	
		});
		
		$("#txtSlof<?php print ($i+1); ?>").change(function() {	
			if ($("#txtSlof<?php print ($i+1); ?>").val() == '')
			{
				$("#txtSlof<?php print ($i+1); ?>").val('0');
			}					
			FillTotalPac(<?php print ($i+1); ?>);	
			FillTotalPrice(<?php print ($i+1); ?>);
			FillQtyIntrodeal(<?php print ($i+1); ?>);	
		});
		
		$("#txtPac<?php print ($i+1); ?>").change(function() {						
			if ($("#txtPac<?php print ($i+1); ?>").val() == '')
			{
				$("#txtPac<?php print ($i+1); ?>").val('0');
			}
			FillTotalPac(<?php print ($i+1); ?>);	
			FillTotalPrice(<?php print ($i+1); ?>);
			FillQtyIntrodeal(<?php print ($i+1); ?>);	
		});		
		<?php } ?>
		
		<?php if ($header['id'] > 0) { ?>
		FillMaterial();	
		<?php } ?>
		
	}); 	
 </script>