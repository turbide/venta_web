<?php /* Smarty version Smarty-3.1.13, created on 2013-05-26 21:52:06
         compiled from "templates/vista_Usuario.tpl" */ ?>
<?php /*%%SmartyHeaderCode:162383337251a2772ba77728-07600905%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '396d459444a6d0f691bc5fdd0c6b237c19f20af2' => 
    array (
      0 => 'templates/vista_Usuario.tpl',
      1 => 1369622756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '162383337251a2772ba77728-07600905',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51a2772bb2cb40_92718855',
  'variables' => 
  array (
    'usuarios' => 0,
    'usuario' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51a2772bb2cb40_92718855')) {function content_51a2772bb2cb40_92718855($_smarty_tpl) {?>  <style type="text/css">
		span{
			  color:#8B8B8B;
		  }

  </style>

  <title></title>
</head>

<body>
  <div class="well span7">
	<h3>Resultados de Busqueda</h3>
    <hr>

	<div class="row-fluid">

	 
        <?php if (is_array($_smarty_tpl->tpl_vars['usuarios']->value)){?>
        <table class="table table-hover table-bordered tabla">
						<thead>
							<tr>
								<th>
									ID
								</th>
								<th>
									Nombre
								</th>
								<th>
									Correo
								</th>
								<th>
									RFC
								</th>
								<th>
									Direccion
								</th>
								<th>
									Tipo
								</th>
                                <th>
                                    Estatus
                                </th>
                                <th>
                                    Editar
                                </th>
                                <th>
                                    Eliminar
                                </th>
                                
								
							</tr>
		</thead>
         <tbody>   
		<?php  $_smarty_tpl->tpl_vars['usuario'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['usuario']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['usuarios']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['usuario']->key => $_smarty_tpl->tpl_vars['usuario']->value){
$_smarty_tpl->tpl_vars['usuario']->_loop = true;
?>
					
						
							<!-- Crear el Script para la consulta SQL -->
							<tr>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['usuario']->value['id'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['usuario']->value['nombre'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['usuario']->value['mail'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['usuario']->value['rfc'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['usuario']->value['direccion'];?>

								</td>
								<td>
									<?php if ($_smarty_tpl->tpl_vars['usuario']->value['tipo']==1){?>
                                    Cliente
                                    <?php }elseif($_smarty_tpl->tpl_vars['usuario']->value['tipo']==2){?>
                                    Ventas
                                    
                                    <?php }else{ ?>
                                    Inventario
                                    <?php }?>
								</td>
                                <td>
                                <?php if ($_smarty_tpl->tpl_vars['usuario']->value['estatus']==1){?>
                                Activo
                                <?php }else{ ?>
                                Inactivo
                                <?php }?>
                                </td>
                                <td>
                                   <a href="index.php?modulo=usuario&action=modificarUsuario&id=<?php echo $_smarty_tpl->tpl_vars['usuario']->value['id'];?>
"><img class="offset2" src="images/editar.png"></a> 
                                </td>
                                <td>
                                    <a href="index.php?modulo=usuario&action=eliminar&id=<?php echo $_smarty_tpl->tpl_vars['usuario']->value['id'];?>
"><img class="offset2" src="images/eliminar.png"></a>
                                </td>
								
							</tr>
					
					
		<?php } ?>
        	</tbody>
         
         
        </table>
        
        <button class="btn btn-primary">Generar Reporte</button>
        
        <?php }else{ ?>
        <p><?php echo $_smarty_tpl->tpl_vars['usuarios']->value;?>
</p>
        <?php }?>

	</div>
  </div>

<?php }} ?>