<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{!! app('AppConfig')->getParam('CABECALHO_NOME_PROJETO') !!}</title>

 <!--Core do processo dos includes--> 
<link href="{{ asset('template/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" >
 <!--Começo da pagina voltada a plugins--> 
<link href="{{ asset('plugins/datetimepicker-master/build/jquery.datetimepicker.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" >        
<link href="{{ asset('template/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" >        
<link href="{{ asset('template/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" >        
<link href="{{ asset('template/global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/jquery-file-upload/css/jquery.fileupload.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css') }}" rel="stylesheet" type="text/css" >

 <!--Estilo do tema global--> 
<link href="{{ asset('template/global/css/components.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" >        
 <!--Estilo do tema admin 4--> 
<link href="{{ asset('template/layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ asset('template/layouts/layout4/css/themes/light.min.css') }}" rel="stylesheet" type="text/css" >

<link href="{{ asset('template/layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css" >

{!!Html::style('resources/assets/css/custom-app.css')!!}

<?php //Validação do parâmetro para selecionar layout do sistema.
if (app('AppConfig')->getParam('LAYOUT_SISTEMA') == 'PORTAL_AZUL') {
    echo Html::style('resources/assets/css/layoutPortal-azul.css');
} else if (app('AppConfig')->getParam('LAYOUT_SISTEMA') == 'PORTAL_GOLD') {
    echo Html::style('resources/assets/css/layoutPortal-gold.css');
}
?>
