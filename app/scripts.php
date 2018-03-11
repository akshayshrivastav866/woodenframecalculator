<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="/assets/js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="/assets/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="/assets/js/custom.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="/assets/js/dataTables.buttons.min.js"></script>
<script src="/assets/js/buttons.flash.min.js"></script>
<!-- end - This is for export functionality only -->
<script>
    $(document).ready(function()
        {
            // $('#myTable').DataTable();
            $('#orderList').dataTable(
                {
                    "aLengthMenu": [[4, 5, 10, 20, 25, 50, 75, -1], [4, 5, 10, 20, 25, 50, 75, "All"]],
                    "pageLength": 4
                });
        });
</script>
<script src="/assets/js/scripts.js"></script>