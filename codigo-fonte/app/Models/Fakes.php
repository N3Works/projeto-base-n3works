<?php
namespace App\Models;

use App\Models\ModelControl;

/**
 * Class Fakes
 * @package App\Models
 * @author Thiago do Amarante Farias <thiago.farias@jointecnologia.com.br>
 * @version <br />
<b>Warning</b>:  date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected the timezone 'UTC' for now, but please set date.timezone to select your timezone. in <b>/var/www/html/public/ProjetoGeradorLaravel/esqueletos/laravel-5.3/model.php</b> on line <b>10</b><br />
20/01/2017
 */
class Fakes extends ModelControl {
    
    public $table = 'fakes';
    
    /**
     * Variaveis seguras para uso e guardar dados 
     * @var array 
     */
    public $fillable = [
        'id',
        'nome',
        'data',
        'valor',
        'created_at',
        'updated_at',
    ];
    
    /**
     * Tipos nativos dos atributos
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nome' => 'string',
        'data' => 'data',
        'valor' => 'money',
        'created_at' => 'data_tempo',
        'updated_at' => 'data_tempo',
    ];    
    
    /**
     * Label dos atributos
     * @var array 
     */
    public $labels = [
        'id' => 'ID',
        'nome' => 'Nome',
        'data' => 'Data Fake',
        'valor' => 'Valor Fake',
        'created_at' => 'Data de criação',
        'updated_at' => 'Data de atualização',
    ];
    
    /**
     * Realiza a consulta da tabela
     * @return array
     */
    public function consultar() {
        $consulta = self::select('*')->orderBy('id', 'DESC');
        return $consulta->get();
    }
}