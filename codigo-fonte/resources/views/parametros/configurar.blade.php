@extends('layout.master')
@section('conteudo')

@php
echo LayoutBuilder::gerarBreadCrumb(array(
    'Página Inicial' => url('/'),
    'Configurar Parâmetros',
));
@endphp

@section('javascript')
{!!Html::script('resources/assets/js/parametros/configurar.js')!!}
@stop
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">      
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-sharp bold uppercase">Configurar Parâmetros</span>
                </div>
            </div>

            <?php echo Util::showMessage(); ?>    
            
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th style="width: 30%;">Nome</th>
                        <th style="width: 40%;">Descrição</th>
                        <th>Valor</th>
                    </thead>
                    <tbody>
                        @foreach ($model->buscarTodos() as $parametro)
                        <tr>
                            <td>{{ $parametro->nome }}</td>
                            <td>{{ $parametro->descricao }}</td>
                            <td>
                                <?php 
                                switch ($parametro->tipo) {
                                    case $model::TIPO_BOOLEAN:
                                        echo '
                                            <div class="inputBoolean">
                                                <div class="icheck-inline">
                                                    <label>
                                                        <div class="iradio_minimal-grey">
                                                             <input type="radio" name="valor" data-rel="'.$parametro->id.'" ' . ($parametro->valor == 'true' ? 'checked="checked"' : '') . ' id="optionRadioTrue" value="true" class="icheck">
                                                        </div> <span class="nameLabelTrue">'.$parametro->ParametroValoresTipos->where('value', true)->first()->header.'</span>
                                                    </label>
                                                    <label>
                                                        <div class="iradio_minimal-grey">
                                                            <input type="radio" name="valor" data-rel="'.$parametro->id.'" ' . ($parametro->valor == 'false' ? 'checked="checked"' : '') . ' id="optionRadioFalse" value="false" class="icheck">
                                                        </div> <span class="nameLabelFalse">' . $parametro->ParametroValoresTipos->where('value', false)->first()->header . '</span>
                                                    </label>
                                                </div>
                                            </div>';
                                        break;
                                    case $model::TIPO_TEXT:
                                        echo '<input type="text" data-rel="'.$parametro->id.'" value="'.$parametro->valor.'" class="inputText form-control" maxlength="255" />';
                                        break;
                                    case $model::TIPO_DROPDOWN:
                                        echo Form::select('valor', 
                                            $parametro->ParametroValoresTipos->pluck('header', 'value'), 
                                            $parametro->valor, 
                                            [
                                                'class' => 'select2 form-control inputDropdown',
                                                'data-rel' => $parametro->id,
                                            ]);
                                        break;
                                    case $model::TIPO_INTEGER:
                                        echo '<input type="text" data-rel="'.$parametro->id.'" value="'.$parametro->valor.'" class="inputInteger numeric-input form-control" maxlength="10" />';
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
