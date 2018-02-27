@extends('layout.master')

@section('conteudo')

<?php
echo LayoutBuilder::gerarBreadCrumb(array(
    'Início' => url('default/index')
));
?>

@section('javascript')
{!!Html::script('resources/assets/js/default/index.js')!!}
@stop

<link href="{{ asset('resources/assets/css/default/index.css') }}" rel="stylesheet" type="text/css" >

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <?php echo Util::showMessage(); ?>
        
        <div class="portlet light bordered">    
            <div class="row">
                
                <div class="col-md-12">
                    <div class="portlet-body">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-sharp bold uppercase">Seja bem vindo <?php echo Auth::user()->nome; ?>! </span>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller" style="height:400px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                            <p> Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula,
                                eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus
                                sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. consectetur purus sit amet fermentum. Duis
                                mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. </p>
                            <p> nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras
                                mattis consectetur purus sit amet fermentum. consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus
                                sit amet fermentum. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@stop
