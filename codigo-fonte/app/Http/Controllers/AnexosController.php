<?php
/* @var Controller $this */

namespace App\Http\Controllers;

//Base do controlador
use App\Http\Controllers\Controller; //Base do controlador
use Illuminate\Http\Request; //Controle de dados por request
use App\Http\Requests\AnexosFormRequest;
use App\DataTables\AnexosDataTable as DataTable;
use App\Http\Helper\Formatar;

//Modelo da controller
use App\Models\Anexos; 

use Response;

/**
 * Controlador dos Planos anuais
 * @author Ezequiel <email@email.com>
 */
class AnexosController extends Controller {

    protected $model;

    protected $dataTable;

    public function __construct(Anexos $anexos, DataTable $dataTable) {
        $this->model = $anexos;
        $this->dataTable = $dataTable;
    }


    public function index(Request $request) {
        
        $this->model->setAttributes($request->all());
        
        if (app('request')->isXmlHttpRequest()) {
            $this->dataTable->model = $this->model;
            return $this->dataTable->ajax();
        }
        
        return view('anexos.index', array(
            'model' => $this->model->get(),
            'dataTable' => $this->dataTable->html(),
        ));
    }

    public function consultar(Request $request) {
        $this->model->setAttributes($request->all());
        return $this->model->consultarDataTables();
    }

    public function form(Request $request) {
        $id = $request->route('id');
        $this->model->setAttributes($request->all());
        
        $model = $this->model;
        
        if ($id) {
            $model = $this->model->find($id);
            $model->formatAttributes('get');

            if (!$model) {
                $this->setMessage('O Anexo não foi encontrado', 'danger');
                return redirect(url('anexos/index'));
            }
        }
        
        return view('anexos.form', array(
            'model' => $model,
        ));
    }

    public function save(AnexosFormRequest $request) {
        $this->model->fill($request->all());
        
        $session = app('session.store');
        
        if ($session->has('anexos') && !empty($session->get('anexos'))) {
            $this->model->fill($session->get('anexos'));
        }
        
        if (!empty($this->model->id)) {
            $alterar = $this->model->find($this->model->id);
            
            if (empty($alterar) || is_null($alterar)) {
                $this->setMessage('O Anexo a ser alterado não existe no banco de dados!', 'danger');    
            } else {
                $this->setMessage('O Anexo foi alterado com sucesso!', 'success');    
                $alterar->update($this->model->toArray());
            }
        } else {
            $this->model->create($this->model->toArray());
            $this->setMessage('O Anexo foi salvo com sucesso!', 'success');
        }
        
        return redirect(url('anexos/index'));
    }

    public function show($id) {
        $model = Anexos::find($id);
        $model->formatAttributes('get');
        
        if (!$model) {
            $this->setMessage('O Anexo não foi encontrado', 'danger');
            return redirect(url('anexos/index'));
        }
        return view('anexos.show', ['model' => $model]);
    }

    public function attachUpload(Request $request) {
        $file = \Illuminate\Support\Facades\Input::file('attach');
        
        try {
            if(empty($file)) {
                throw new \Exception('Anexo não foi recebido');
            }

            if(!$file->isValid()) {
                throw new \Exception('Upload falhou');
            }

            $filestored = $file->store('public');

            $session = app('session.store');
            $session->set('anexos', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'filename' => $filestored,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $row = [
                'name' => $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'type' => $file->getClientMimeType(),
                'dt_upload' => date('Y-m-d H:i:s'),
                'storage' => $filestored,
            ];

            $response['success'] = true;
            $response['files'][] = $row;
            $response['message'] =  sprintf('Arquivo(s) enviado com sucesso', $file->getClientOriginalName());

        }
        catch(\Exception $e){
            $response['message'] = $e->getMessage();
        }

        return Response::json($response);
    }

    public function attachList(\Illuminate\Http\Request $request){
        $response = [
            'sEcho' => intval($request->get('sEcho')),
            'draw' => 1,
            'aaData' => []
        ];

        $anexos = Anexos::get()->toArray();
        $total = 0;
        foreach($anexos as $row) {
            
            $tipo = '';
            $quebra = explode('.', $row['filename']);
            
            if (isset($quebra[1]) && !empty($quebra)) {
                $tipo = $quebra[1];
            }
            
            $response["aaData"][] = [
                isset($row['nome_fantasia']) && !empty($row['nome_fantasia']) ? $row['nome_fantasia'] : '',
                isset($row['descricao']) && !empty($row['descricao']) ? $row['descricao'] : '',
                $row['name'],
                strtoupper($tipo),
                Formatar::bytes($row['size']),
                Formatar::dateDbToAll($row['created_at']),
                $row['id'],
                $row['filename'],
            ];
            $total++;
        }

        $response['iTotalRecords'] = $total;
        $response['data'] = $response['aaData'];

        return Response::json($response);
    }

    public function attachDownload(\Illuminate\Http\Request $request){
        $id = $request->get('id');
        $anexo = Anexos::find($id);
       
        if ($anexo) {
            $path = storage_path('app').DIRECTORY_SEPARATOR.$anexo['filename'];

            if(!file_exists($path)) {
                throw new \Exception('Arquivo não foi localizado no diretório ou não pode ser lido');
            }

            return Response::download($path, $anexo['name'], array(
                'Content-Type' => $anexo['type'],
                'Content-Disposition' => 'attachment"',
                'Content-Length' => $anexo['size']
            ));
        }
    }

    public function attachDelete(\Illuminate\Http\Request $request) {
        $id = $request->get('id');
        
        if (!$id) {
            $response = array('success' => false, 'message' => 'Não localizado');
        } else {
            $attach = $this->model->find($id);
            if(!empty($attach)){
                $attach->delete();
            }

            $response['success'] = true;
            $response['message'] = 'Removido com sucesso';
        }

        return Response::json($response);
    }
}
