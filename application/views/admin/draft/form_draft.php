<?php 
$header = $data['header']; 
$detail = $data['detail']; 
?>
 <!-- .row -->
 				<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box p-l-20 p-r-20">
                            <h3 class="box-title m-b-0">Detail Draft Package </h3>
                            <p class="text-muted m-b-30 font-13"></p>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Package No</label>    
                                        <input type="text" id="txtNo" class="form-control" disabled value="<?php print $header['No']; ?>">                                    </div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Date</label>
                                        <input type="text" id="txtTgl" class="form-control" disabled value="<?php print $header['Tanggal']; ?>">                                	
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                        <label class="control-label">Courier</label>
                                        <input type="text" id="txtCourier" class="form-control" disabled value="<?php print $header['Kurir']; ?>">                                                                  
                                   	</div>
                                </div>
                                <div class="col-md-6">                                    
                                    <div class="form-group">
                                    	<label class="control-label">Notes</label>
                                        <input type="text" id="txtNotesHeader" class="form-control" disabled value="<?php print $header['Keterangan']; ?>">                                                        
                                   	</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="white-box">                                        
                                    	<h3 class="box-title">ROUTE</h3>
                                        <p class="text-muted m-b-20"></p>                                        
                                        <div class="tracking-list">
                                        	<div class="tracking-item text-inverse">
                                              <div class="tracking-icon status-intransit bg-inverse"></div>
                                              <div class="tracking-date"><span></span></div>
                                              <div class="tracking-content">[SENDER] <?php print $header['Dari']; ?></div>
                                            </div>
                                        	<?php											
											$arrRoute = explode(',',$header['NamaRoute']);	
											$arrRouteID = explode(',',$header['Route']);												
											for ($i=0;$i<count($arrRouteID);$i++)
											{
											?>                                           
                                            <div class="tracking-item text-inverse">
                                              <div class="tracking-icon status-intransit bg-inverse"></div>
                                              <div class="tracking-date"></div>
                                              <div class="tracking-content">[DEFAULT] <?php print $arrRoute[$i]; ?></div>
                                           </div>                                           
										   <?php } ?>	                                    	
                                    	</div>
                                    </div>
                                </div>
                            </div>                       
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <h3 class="box-title">LIST DOCUMENT</h3>
                                        <p class="text-muted m-b-20"></p>
                                        
                                        <div class="table-responsive">
                                            <table id="tblDokumen" class="table table-striped">
                                                <thead>
                                                    <tr>                                                        
                                                        <th>No</th>          
                                                        <th>Revisi</th>          
                                                        <th>Type</th>                                                        
                                                        <th>Description</th>
                                                        <th>Notes</th>
                                                        <th>Qty</th>
                                                        <th>Amount</th>                                                   	
                                                  	</tr>
                                                </thead>
                                                <tbody>                               
                                                	<?php for ($i=0;$i<count($detail);$i++) { ?>                                         
                                                	<tr>
                                                    	<td><?php print $detail[$i]["No"]; ?></td>
                                                        <td><?php print $detail[$i]["Revisi"]; ?></td>
                                                        <td><?php print $detail[$i]["Jenis"]; ?></td>
                                                        <td><?php print $detail[$i]["Deskripsi"]; ?></td>
                                                        <td><?php print $detail[$i]["Keterangan"]; ?></td>
                                                        <td><?php print $detail[$i]["Jumlah"]; ?></td>
                                                        <td><?php print $detail[$i]["Nominal"]; ?></td>                       
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
                                	<button id="btnBack" class="btn btn-block btn-danger btn-rounded">BACK</button>
                                </div>              
                                <div class="col-sm-8">
                                	<input type="hidden" class="form-control" id="hidID" value="<?php print $header['ID']; ?>">                                </div>              		
                                <div class="col-sm-2">
                                	<button id="btnEdit" class="btn btn-block btn-success btn-rounded">EDIT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
 
 <script type="text/javascript">
 	$(document).ready(function(){	
		
		$("#btnBack").click(function() {						
			location.href="<?php echo base_url();?>admin/draft/list_draft";				
		});		 		
				
		$("#btnEdit").click(function() {						
			location.href="<?php echo base_url();?>admin/createnew/create_new/<?php print $header['ID']; ?>";				
		});
	}); 	
 </script>