<?php 
function modulo_habilitado($permisos,$modulo) {
  foreach($permisos as $p) {
    if ($p->nombre == $modulo) return $p->permiso;
  }
  return 0;
}
?>
<div class="app-aside">
  
  <div class="aside-wrap">
    <div class="navi-wrap">

      <a href="javascript:void(0)" onclick="workspace.toggle_menu()" class="navbar-brand text-lt">
        <?php if ($realtyone == 0) { ?>
          <img src="<?php echo LOGO ?>"/>
        <?php } ?>
      </a>                
    
      <nav class="navi">
        <ul class="nav">
          <?php 
          // SUPERADMIN
          if ($perfil == -1) { ?>
            <li>
              <a href='app/#ver_proyecto/3'>
                <i class='material-icons'>group</i>
                Clientes
              </a>
            </li>
            <li>
              <a href='app/#novedades'>
                <i class='material-icons'>feed</i>
                Novedades
              </a>
            </li>
            <li>
              <a href='app/#videos'>
                <i class='material-icons'>settings</i>
                Videos
              </a>
            </li>
            <li>
              <a href='app/#web_templates'>
                <i class='material-icons'>settings</i>
                Templates
              </a>
            </li>
            <li>
              <a href='app/#proyectos'>
                <i class='material-icons'>settings</i>
                Modulos
              </a>
            </li>
            <li>
              <a href='app/#planes'>
                <i class='material-icons'>settings</i>
                Planes
              </a>
            </li>
            <li>
              <a href='app/#versiones_db'>
                <i class='material-icons'>settings</i>
                Versiones
              </a>
            </li>

          <?php 
          // CUENTA ESPECIAL DE INMOVAR
          } else if ($empresa->id == 1) { ?>
            <li>
              <a href="app/#consultas" class=""><i class="material-icons md-22">directions_run</i><span>Seguimiento</span></a>
            </li>
            <li>
              <a href="app/#cuentas_corrientes_clientes" class=""><i class="material-icons md-22">payment</i><span>Pagos</span></a>
            </li>
            <li>
              <a href="app/#cajas" class=""><i class="material-icons md-22">attach_money</i><span>Cajas</span></a>
            </li>
            <li>
              <a href="app/#clientes" class=""><i class="material-icons md-22">people</i><span>Contactos</span></a>
            </li>
            <li>
              <a href="app/#configuracion_menu" class=""><i class="material-icons md-22">settings</i><span>Configuración</span></a>
            </li>

          <?php 
          // USUARIO NORMAL
          } else { ?>
            <?php if (modulo_habilitado($permisos,"inicio")>0) { ?>
              <li>
                <a href="app/#inicio"><i class="material-icons md-22">equalizer</i><span>Escritorio</span></a>
              </li>
            <?php } ?>
            <?php if (modulo_habilitado($permisos,"consultas")>0) { ?>
              <li>
                <a href="app/#consultas" class=""><i class="material-icons md-22">directions_run</i><span>Seguimiento</span></a>
              </li>
            <?php } ?>

            <?php if (modulo_habilitado($permisos,"agenda")>0) { ?>
              <li>
                <a href="app/#agenda" class=""><i class="material-icons md-22">calendar_month</i><span>Agenda</span></a>
              </li>
            <?php } ?>

            <?php if (modulo_habilitado($permisos,"propiedades")>0) { ?>
              <li>
                <a href="app/#propiedades" class=""><i class="material-icons md-22">home</i><span>Propiedades</span></a>
              </li>
            <?php } ?>

            <?php if ( modulo_habilitado($permisos,"oportunidades")>0 && (isset($volver_superadmin) && $volver_superadmin == 1)) { ?>
              <li>
                <a href="app/#oportunidades" class=""><i class="material-icons md-22">search</i><span>Oportunidades</span></a>
              </li>
            <?php } ?>

            <?php if (modulo_habilitado($permisos,"permisos_red")>0) { ?>
              <li>
                <a href="app/#permisos_red" class=""><img class="svg-menu" src="resources/images/logo.svg" /><span><?php echo ($realtyone == 1) ? "Redes" : "Red Inmovar" ?></span></a>
              </li>
            <?php } ?>
            <?php if (modulo_habilitado($permisos,"alquileres")>0) { ?>
              <li>
                <a href="app/#alquileres" class=""><i class="material-icons md-22">vpn_key</i><span>Alquileres</span></a>
              </li>
              <li>
                <a href="app/#cajas" class=""><i class="material-icons md-22">attach_money</i><span>Cajas</span></a>
              </li>
            <?php } ?>
            <?php if (modulo_habilitado($permisos,"contactos")>0) { ?>
              <li>
                <a href="app/#clientes" class=""><i class="material-icons md-22">people</i><span>Contactos</span></a>
              </li>
            <?php } ?>
            <?php if (modulo_habilitado($permisos,"menu_web")>0) { ?>
              <li>
                <a href="app/#menu_web" class=""><i class="material-icons md-22">laptop_windows</i><span>Sitio Web</span></a>
              </li>
            <?php } ?>
            <?php /*
            <li>
              <a href="app/#estadisticas" class=""><i class="material-icons md-22">equalizer</i><span>Estadísticas</span></a>
            </li>
            */ ?>
            <?php if (modulo_habilitado($permisos,"configuracion_menu")>0) { ?>
              <li>
                <a href="app/#configuracion_menu" class=""><i class="material-icons md-22">settings</i><span>Configuración</span></a>
              </li>
            <?php } ?>

          <?php } ?>
        </ul>
      </nav>
    </div>
  </div>
</div>