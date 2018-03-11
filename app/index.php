<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("meta_css.php"); include("classes.php"); ?>
        <style>
            .error
                {
                  border: 2px solid #b72424;
                }

            #message
                {
                    font-size: 16px;
                    text-align: justify;
                    text-align-last: center;
                    color: #327231;
                    line-height: 25px;
                }

            #message2
                {
                    font-size: 16px;
                    text-align: justify;
                    text-align-last: center;
                    color: #b72424;
                    line-height: 25px;
                }

            #message3
                {
                    font-weight: normal !important;
                    font-size: 16px;
                    text-align: left;
                    color: #b72424;
                    line-height: 25px;
                }
        </style>
    </head>
    <body class="fix-header fix-sidebar card-no-border">
        <!-- Preloader - style you can find in spinners.css -->
        <?php include("preloader.php"); ?>
        <!-- Preloader - style you can find in spinners.css -->

        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- Header - style you can find in pages.scss -->
            <?php include("header.php"); ?>
            <!-- End header -->
            <!-- Sidebar - style you can find in sidebar.scss  -->
            <?php include("sidebar.php"); ?>            
            <!-- End Sidebar - style you can find in sidebar.scss  -->

            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles">
                        <div class="col-md-5 col-8 align-self-center">
                            <h3 class="text-themecolor">Home Page</h3>
                            <!-- <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            </ol> -->
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Wooden Frame Calculator</h4>
                                    <form enctype="multipart/form-data" onsubmit="return false;" id="makeForm" class="form p-t-20">
                                        <div class="form-group">
                                            <label class="control-label">Select SKU</label>
                                            <select class="make_select form-control custom-select" name="sku" id="make_select" data-placeholder="Choose a Category" tabindex="1">
                                                <option value="" selected disabled>Select SKU First</option>
                                                <?php $sku->getList(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price/CM</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-money"></i></div>
                                                <input readonly type="text" class="form-control" name="price" id="price" placeholder="Price Will Be Displayed Here">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="width">Width (CM)</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-split-h"></i></div>
                                                    <input type="number" class="make_width form-control" name="width" id="make_width" placeholder="Enter Width (CM)">
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="height">Height (CM)</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-split-v"></i></div>
                                                    <input type="number" class="make_height form-control" name="height" id="make_height" placeholder="Enter Height (CM)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label for="perimeter">Total Perimeter</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-fullscreen"></i></div>
                                                    <input readonly type="number" class="form-control" name="perimeter" id="perimeter" placeholder="Total Perimeter is..">
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label for="cost">Total Cost of One Frame</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="ti-money"></i></div>
                                                    <input readonly type="text" class="form-control" name="cost" id="cost" placeholder="Total Cost is..">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="message">
                                            <b>Order Added To List! Please Check Order List.</b>
                                        </div>
                                        <div class="form-group" id="message2">
                                            <b>Please Fill Out All The Fields!</b>
                                        </div>
                                        <div class="pull-right">
                                            <button class="calculate btn btn-rounded btn-outline-primary waves-effect waves-light m-r-10">Calculate</button>
                                            <button class="addToOrder btn btn-rounded btn-outline-danger waves-effect waves-light">Add To Order List</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Order List (Order Total is: Rs. <span id="orderTotalAmt"> <?php $order->getTotalAmt() ?></span>/-)</h4>
                                    <div class="table-responsive m-t-40" style="margin-top: 15px !important;">
                                        <div class="form-group" id="message3">
                                            Minimum Quantity Should Be 1. Quantity You Changed is Less Than 1
                                        </div>
                                        <table id="orderList" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th width='15%'>Qty</th>
                                                    <th>Width</th>
                                                    <th>Height</th>
                                                    <th>Cost</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $order->getOrdersList(); ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th width='15%'>Qty</th>
                                                    <th>Width</th>
                                                    <th>Height</th>
                                                    <th>Cost</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End PAge Content -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- footer -->
                <?php include("footer.php"); ?>
                <!-- End footer -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <?php include("scripts.php"); ?>
    </body>
</html>