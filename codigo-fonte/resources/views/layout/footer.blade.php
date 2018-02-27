<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('template/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('template/global/plugins/bootstrap-daterangepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/radar.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/themes/patterns.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amcharts/themes/chalk.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/ammap/ammap.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/ammap/maps/js/worldLow.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/amcharts/amstockcharts/amstock.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('template/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/mask/src/jquery.mask.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('template/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/pages/scripts/table-datatables-managed.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/pages/scripts/ui-toastr.min.js') }}" type="text/javascript"></script>

<!-- upload::begin -->
<script src="{{ asset('template/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/global/plugins/jquery-file-upload/js/jquery.fileupload.js') }}" type="text/javascript"></script>
<!-- upload::end -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('template/layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>

{!!Html::script('resources/assets/js/config.js')!!}
{!!Html::script('resources/assets/js/app-validation.js')!!}
{!!Html::script('resources/assets/js/app-format.js')!!}
{!!Html::script('resources/assets/js/app-util.js')!!}
{!!Html::script('resources/assets/js/app-custom.js')!!}

@yield('javascript')

