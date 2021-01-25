 <!-- .row -->
<div class="row">
	<div class="col-sm-12">
		<div class="white-box p-l-20 p-r-20">
			<h3 class="box-title m-b-0"></h3>
			<p class="text-muted m-b-30 font-13"></p>
			<div class="row" style="display:none">
				<div class="col-md-6">                                    
					<div class="form-group">
						<label class="control-label">Final Stop</label>                                        
						                                  
					</div>
				</div>
				<div class="col-md-6">                                    
					<div class="form-group">
						<label class="control-label">Next Stop</label>
						<select id="cmbNextStop" class="form-control select2">
							
						</select>                                         
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">                                    
					<div class="form-group">
						<label class="control-label">Route</label>                                        
						<select id="cmbRoute" class="select2 m-b-10 select2-multiple" multiple="multiple">
							
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
							
						</select>                              
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">                                    
					<div class="form-group">
						<label class="control-label">Courier</label>
						<select id="cmbCourier" class="form-control select2">
							
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