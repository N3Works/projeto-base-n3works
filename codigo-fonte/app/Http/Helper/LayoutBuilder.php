<?php
namespace App\Http\Helper;

/**
 * Classe de construção de html
 * @author Thiago Farias <thiago.farias@jointecnologia.com.br>
 */
class LayoutBuilder {
    
    /**
     * Monta o Html dos menus
     * @param array $menus array de configuração dos menus
     * @return string
     */
    public static function montarHtmlMenus($menus) {
        $html = '';
        
        foreach ($menus as $menu) {
            $menusOrder[$menu['id']] = $menu['order'];
        }

        asort($menusOrder);
        
        foreach ($menusOrder as $id => $order) {
            
            $menu = $menus[$id];
            
            list($active, $open) = self::validarMenusAtivos($menu);
            if (!self::validarMenuPermissao($menu)) {
                continue;
            }
            
            $menu['key'] = array_key_exists('key', $menu) ? $menu['key'] : '';
            $html .= '<ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">';
            $url = (isset($menu['controller']) && isset($menu['action']) ? url($menu['controller'].'/'.$menu['action'], ['id' => $menu['key']]) : 'javascript:void(0)');
            $htmlOptions = '';
            
            if (isset($menu['htmlOptions'])) {
                foreach ($menu['htmlOptions'] as $atribute => $value) {
                    $htmlOptions .= $atribute.'="' . $value . '" ';
                }
            }
            
            $html .= '<li class="nav-item start ' . $active . ' ' . $open . ' ">';
            $html .= '<a '.$htmlOptions.' href="' . $url . '" class="nav-link nav-toggle" id="'.$menu['controller'].'">
                            <i class="fa fa-' . $menu['icon'] . '"></i>
                            <span class="title">' . $menu['header'] . '</span>
                            <span class="selected"></span>
                            ' . (!empty($menu['child']) ? '<span class="arrow ' . $open . '"></span>' : '') . '
                        </a>';
            
            if (!empty($menu['child'])) {
                $childsOrder = [];
                
                foreach ($menu['child'] as $child) {
                    $childsOrder[$child['id']] = $child['order'];
                }
                
                asort($childsOrder);
                
                $html .= '<ul class="sub-menu">';
                
                foreach ($childsOrder as $idChild => $order) {
                    
                    $child = $menu['child'][$idChild];
                    
                    $child['key'] = array_key_exists('key', $child) ? $child['key'] : '';
                    
                    list($activeChild, $open) = self::validarMenusAtivos($child, $menu['controller']);
                    if (!self::validarMenuPermissao($child)) {
                        continue;
                    }
                    
                    $urlChild = 'javascript:void(0)';
                    $htmlOptions = '';
                    
                    if (!empty($child['action'])) {
                        if (isset($child['controller']) && !empty($child['controller'])) {
                            $urlChild = url($child['controller'].'/'.$child['action'], ['id' => $child['key']]);
                        } else {
                            $urlChild = url($menu['controller'].'/'.$child['action'], ['id' => $child['key']]);
                        }
                    }
                    
                    if (isset($child['htmlOptions'])) {
                        foreach ($child['htmlOptions'] as $atribute => $value) {
                            $htmlOptions .= $atribute.'="' . $value . '" ';
                        }
                    }
                    
                    $html .= '<li class="nav-item start '.$activeChild.' ">';
                    $html .= '<a '.$htmlOptions.' href="' . $urlChild . '" class="nav-link ">
                                  <i class="fa fa-' . $child['icon'] . '"></i>
                                  <span class="title">'.$child['header'].'</span>
                                  <span class="selected"></span>
                              </a></li>';
                }
                $html .= '</ul>';
                 
            }

            $html .= '</li></ul>';
        }
        
        return $html;
    }
    
    /**
     * Valida menus ativos e abertos
     * @param array $menu
     * @param string $nomeControllerPai
     * @return array
     */
    public static function validarMenusAtivos($menu, $nomeControllerPai = '') {
        
        if (empty($nomeControllerPai) && isset($menu['controller'])) {
            if ($menu['controller'] != $_SESSION['CONTROLLER']) {
                return array('', '');
            } else {
                if (isset($menu['action']) && $menu['action'] == $_SESSION['ACTION']) {
                    return array('active', '');
                }
            }
        }
        
        if (!isset($menu['action']) && empty($nomeControllerPai)) {
            return array('active', 'open');
        }
        
        if (isset($menu['action']) && $menu['action'] == $_SESSION['ACTION']) {
            if ($menu['controller'] == $_SESSION['CONTROLLER']) {
                return array('active', '');
            }
        }
        
        if (isset($menu['action'])) {
            if (!empty($nomeControllerPai) && $_SESSION['ACTION'] == $menu['action']) {
                if ($menu['controller'] == $_SESSION['CONTROLLER']) {
                    return array('active', '');
                }
            } else {
                return array('', '');
            }
        } else {
            return array('', '');
        }
    }
    
    /**
     * Valida a permissao do menu ( Se deve mostrar ou não o menu )
     * @param array $menu
     * @return boolean
     */
    public static function validarMenuPermissao($menu) {
        if (!empty($menu['permissao_id'])) {
            $permissao_menu = \App\Models\Permissoes::find($menu['permissao_id'])->permissao;
            return \Auth::user()->verificarPermissao($permissao_menu);
        }
        return true;
    }
    
    /**
     * Gera o breadcrumb conforme passado por parãmetro
     * @param array $breadConfig
     * @return string
     */
    public static function gerarBreadCrumb($breadConfig = array()) {
        $html = '<ul class="page-breadcrumb breadcrumb">';
        $html .= '<li><b class="font-sharp" >Você está aqui: &nbsp;</b></li>';
        
        $count = 1;
        foreach ($breadConfig as $text => $url) {
           
            if ($count == count($breadConfig)) {
                $html .= '<li><span class="active">'.(is_int($text) ? $url : $text).'</span></li>';
            } else {
                $html .= '
                    <li style="color: #5A6467 !important; text-decoration: none !important;">
                        <b >
                            <a style="color: #5A6467 !important; text-decoration: none !important;" href="'.$url.'">'. $text.'</a>&nbsp;<b>></b>&nbsp;
                        </b>
                    </li>
                ';
            }
            $count++;
        }
        
//        $session = $session = app('session.store');
//        $time = ($session->get('tempo_sessao') > 0) ? $session->get('tempo_sessao') - time() : 0;
//        '.$time.' ---- 
        $html .= '</span></ul>';
        
        return $html;
    }
}
