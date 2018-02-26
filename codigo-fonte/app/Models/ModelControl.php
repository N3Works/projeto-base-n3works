<?php
namespace App\Models;

use Eloquent as Model;
use App\Http\Helper\Formatar as Formatar; /* @var Formatar Formatar*/

/**
 * Class ModelControl
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 * @package App\Models
 * @version Novembro 22, 2016, 10:00 am BRST
 */
class ModelControl extends Model {
    
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
}

