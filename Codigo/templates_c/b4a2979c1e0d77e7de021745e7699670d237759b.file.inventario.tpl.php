<?php /* Smarty version Smarty-3.1.13, created on 2013-06-14 02:11:55
         compiled from "templates\inventario.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3006451a28752a0ad83-42629674%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4a2979c1e0d77e7de021745e7699670d237759b' => 
    array (
      0 => 'templates\\inventario.tpl',
      1 => 1371174131,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3006451a28752a0ad83-42629674',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_51a28752ab0321_92975362',
  'variables' => 
  array (
    'inventarios' => 0,
    'inventario' => 0,
    'pdf' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51a28752ab0321_92975362')) {function content_51a28752ab0321_92975362($_smarty_tpl) {?><style type="text/css">
		span{
			  color:#8B8B8B;
		  }
		  
		  .pdf
		  {
			border: solid 1px #000;
		  }
		  
		  table
{
border-collapse:collapse;
}
table,th, td
{
border: 1px solid black;
}

 </style>


<body>
  <div class="well span7" >
	<h3>Reporte de Inventario</h3>
    <hr>

	<div class="row-fluid">

	 
        <?php if (is_array($_smarty_tpl->tpl_vars['inventarios']->value)){?>
        <table class="table table-hover table-bordered tabla pdf" >
						<thead>
							<tr>
								<th>
									ID
								</th>
								<th>
									Fecha
								</th>
								<th>
									# Productos
								</th>
								<th>
									# Real
								</th>
								<th>
									# Esperada
								</th>
								<th>
									Descripcion
								</th>
                                <th>
                                    Nombre Usuario
                                </th>
                                
                                
                                
								
							</tr>
		</thead>
         <tbody>   
		<?php  $_smarty_tpl->tpl_vars['inventario'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['inventario']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['inventarios']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['inventario']->key => $_smarty_tpl->tpl_vars['inventario']->value){
$_smarty_tpl->tpl_vars['inventario']->_loop = true;
?>
					
						
							<!-- Crear el Script para la consulta SQL -->
							<tr>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['inventario']->value['id'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['inventario']->value['fecha'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['inventario']->value['cantidadProducto'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['inventario']->value['cantidadReal'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['inventario']->value['cantidadEsperada'];?>

								</td>
								<td>
									<?php echo $_smarty_tpl->tpl_vars['inventario']->value['descripcion'];?>

								</td>
                                <td>
                                <?php echo $_smarty_tpl->tpl_vars['inventario']->value['nombre'];?>

                                </td>

								
							</tr>
					
					
		<?php } ?>
        	</tbody>

         
         
        </table>
        
       <a href="temp/<?php echo $_smarty_tpl->tpl_vars['pdf']->value;?>
.pdf" target="_blank"> <button class="btn btn-primary">Generar Reporte</button></a>
        
        <?php }else{ ?>
        <p><?php echo $_smarty_tpl->tpl_vars['inventarios']->value;?>
</p>
        <?php }?>

	</div>
  </div>

<?php }} ?>