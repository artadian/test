
 <!--row -->
                <!-- <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading"> TRACKING PACKAGE
                                <div class="pull-right"> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="col-md-10 col-sm-10">
                                        <input type="text" id="txtTrackPackage" class="form-control" placeholder="Enter Package No" >
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <button id="btnTrackPackage" class="btn btn-block btn-primary btn-rounded"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading"> TRACKING DOCUMENT
                                <div class="pull-right"> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="col-md-10 col-sm-10">
                                        <input type="text" id="txtTrackDocument" class="form-control" placeholder="Enter Document No" >
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <button id="btnTrackDocument" class="btn btn-block btn-info btn-rounded"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                    </div>                
                    
                    
                </div> -->
                <!--/row -->
 <!--row -->
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box bg-warning">
                            <div class="r-icon-stats">
                                <i class="fa fa-dollar bg-white text-warning"></i>
                                <div class="bodystate">
                                <span class="text-muted"><a href="<?php echo base_url('admin/ongoingpackage/list_ongoing') ?>" style="color:white">
Total PO</a></span>
                                    <h3 style="color:white; font-weight:bold" id="totalAmount"></h3>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-6">
                        <div class="white-box bg-danger">
                            <div class="r-icon-stats">
                                <i class="fa fa-shopping-cart bg-white text-danger"></i>
                                <div class="bodystate">
                                <span class="text-muted"><a href="<?php echo base_url('admin/sendpackage/send_package') ?>" style="color:white">
Total </a></span>
                                    <h3 style="color:white; font-weight:bold" id="totalSellin"></h3>
                                    
                                </div>
                            </div>
                        </div>
                    </div> -->

           
                    
                </div>
                <!--/row -->
               
<script type="text/javascript">
    $(document).ready(function(){
        function thousandSeparator(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
        }   
        // $.ajax({
        //     type: "POST",
        //     url: "<?php echo base_url();?>admin/home/count_dashboard",
        //     data: {data:JSON.stringify(data)},
        //     dataType: 'json',
        //     success: function(jsonData){                
        //         $("#totalAmount").html(thousandSeparator(jsonData.total));                                        
        //     },
        //     error: function(jqXHR, textStatus, errorThrown ){
        //         swal("Error", errorThrown, "error");
        //     }
        // });
        
        $("#btnTrackPackage").click(function() {                        
            var no = $("#txtTrackPackage").val();
                        
            if (no == '')
            {
                swal('Warning','Please enter package no','warning');                
                return false;
            }               
            else
            {
                var data= new Object();                 
                    
                var v_data = {};                
                v_data.no = no;
                
                data["header"]  = JSON.stringify(v_data);
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/home/tracking_package",
                    data: {data:JSON.stringify(data)},
                    dataType: 'json',
                    success: function(jsonData){                                                
                        location.href="<?php echo base_url();?>admin/trackingpackage/tracking_package";         
                    },
                    error: function(jqXHR, textStatus, errorThrown ){
                        swal("Error", errorThrown, "error");
                    }
                });
            }           
                            
        }); 
        
        $("#btnTrackDocument").click(function() {                       
            var no = $("#txtTrackDocument").val();
                        
            if (no == '')
            {
                swal('Warning','Please enter document no','warning');               
                return false;
            }               
            else
            {
                var data= new Object();                 
                    
                var v_data = {};                
                v_data.no = no;
                
                data["header"]  = JSON.stringify(v_data);
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/home/tracking_document",
                    data: {data:JSON.stringify(data)},
                    dataType: 'json',
                    success: function(jsonData){                                                
                        location.href="<?php echo base_url();?>admin/trackingdocument/tracking_document";           
                    },
                    error: function(jqXHR, textStatus, errorThrown ){
                        swal("Error", errorThrown, "error");
                    }
                });
            }           
                            
        }); 
        
    });
</script>
    