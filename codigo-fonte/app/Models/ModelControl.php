<?php
namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use App\Http\Helper\Formatar as Formatar; /* @var Formatar Formatar*/

/**
 * Class ModelControl
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @package App\Models
 * @version Novembro 22, 2016, 10:00 am BRST
 */
class ModelControl extends Model {

    //Constantes da coluna de SIM/NAO
    const SIM = 1;
    const NAO = 0;

    //Constantes da coluna situação
    const ATIVO = 1;
    const INATIVO = 0;

    const UPDATE = 'UPDATE';
    const INSERT = 'INSERT';
    const DELETE = 'DELETE';


    /**
     * Array Estática com valores da coluna de situação
     * @var array
     */
    public static $status_sistem_list = [
        self::ATIVO => 'Ativo',
        self::INATIVO => 'Inativo',
    ];

    /**
     * Array Estática com valores com SIM/NAO
     * @var array
     */
    public static $sim_nao_sistem_list = [
        self::SIM => 'Sim',
        self::NAO => 'Não',
    ];

    /**
     * Seta todos os atributos do request
     * @param array $request
     */
    public function setAttributes($request) {
        foreach ($request as $campo => $valor) {
            if (in_array($campo, $this->fillable)) { //Busca o search da tabela que chama a ModelControl
                $this->setAttribute($campo, $valor);
            }
        }
    }

    /**
     * Formata os atributos conforme casts, e metodo setado get ou save
     * @param string $metodo get, save.
     */
    public function formatAttributes($metodo) {

        if ($metodo == 'get') {
            foreach ($this->casts as $attribute => $type) {

                if (empty($this->$attribute)) {
                    continue;
                }

                if ($type == 'data') {
                    $this->$attribute = Formatar::dateDbToAll($this->$attribute);
                }

                if ($type == 'dinheiro') {
                    $this->$attribute = Formatar::number($this->$attribute, 'BR');
                }
            }
        }

        if ($metodo == 'save') {
            foreach ($this->casts as $attribute => $type) {

                if ($attribute == 'created_at' || $attribute == 'updated_at') {
                    continue;
                }

                if (empty($this->$attribute)) {
                    $this->$attribute = null;
                    continue;
                }

                if ($type == 'data') {
                    $this->$attribute = Formatar::dateBrToAll($this->$attribute, 'DB');
                }

                if ($type == 'dinheiro' || $type == 'money') {
                    $this->$attribute = Formatar::number($this->$attribute, 'DB');
                }
            }
        }
    }

    /** Executa sempre que alguma manipulação de dados existir gerando um registro novo na table de logs */
    public static function boot()
    {
        static::creating(function ($model) {
            $usuario_id = !\Auth::guest() ? \Auth::user()->id : null;
            $usuario_nome = !\Auth::guest() ? \Auth::user()->nome : null;
            \DB::table('logs')->insert([
                'acao' => self::INSERT,
                'usuario_id' => $usuario_id,
                'usuario_nome' => $usuario_nome,
                'entidade' => $model->table ,
                'data' => Carbon::now()
            ]);
        });

        static::updating(function ($model) {
            $usuario_id = !\Auth::guest() ? \Auth::user()->id : null;
            $usuario_nome = !\Auth::guest() ? \Auth::user()->nome : null;
            \DB::table('logs')->insert([
                'acao' => self::UPDATE,
                'usuario_id' => $usuario_id,
                'usuario_nome' => $usuario_nome,
                'entidade' => $model->table ,
                'data' => Carbon::now()
            ]);
        });

        static::deleting(function ($model) {
            $usuario_id = !\Auth::guest() ? \Auth::user()->id : null;
            $usuario_nome = !\Auth::guest() ? \Auth::user()->nome : null;
            \DB::table('logs')->insert([
                'acao' => self::DELETE,
                'usuario_id' => $usuario_id,
                'usuario_nome' => $usuario_nome,
                'entidade' => $model->table ,
                'data' => Carbon::now()
            ]);
        });

        parent::boot();
    }
}

