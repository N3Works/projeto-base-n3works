<?php
namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Permissao {
    use HandlesAuthorization;

    public function __call($name, $arguments) {
        return \App\Http\Helper\Util::verificarPermissao($name);
    }
}
