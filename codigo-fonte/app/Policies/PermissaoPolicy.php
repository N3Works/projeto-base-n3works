<?php
namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class PermissaoPolicy {
    use HandlesAuthorization;

    public function __call($name, $arguments) {
        return \App\User::verificarPermissao($name);
    }
}
