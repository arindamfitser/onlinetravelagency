<script src="{{ asset('backend/assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/core/popper.min.js') }}"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<script src="{{ asset('backend/assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="{{ asset('backend/assets/js/plugins/chartist.min.js') }}"></script>
<!-- Library for adding dinamically elements -->
<script src="{{ asset('backend/assets/js/plugins/arrive.min.js') }}" type="text/javascript"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{ asset('backend/assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library -->
<script src="{{ asset('backend/assets/js/material-dashboard.js?v=2.0.0') }}"></script>
<!-- demo init -->
<script src="{{ asset('backend/assets/js/plugins/demo.js') }}"></script>
<script src="{{ asset('backend/assets/js/plugins/jquery.dataTables.js') }}"></script>
<script src="{{ asset('backend/assets/js/plugins/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('backend/assets/js/plugins/data-table.js') }}"></script>
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        //init wizard

        // demo.initMaterialWizard();

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initCharts();

    });

</script>

 @yield('th_foot')
</html>
