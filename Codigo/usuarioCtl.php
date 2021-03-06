<?php

/**
 * @package mvc
 * @subpackage controller
 * @author
 */

//Este controlador require tener acceso al modelo
include_once('model/usuarioBss.php');
//La clase controlador

class usuarioCtl {

	public $modelo;
	//Cuando se crea el controlador crea el modelo de usuario
	function __construct(){
		$this -> modelo = new usuarioBss();
	}

	function ejecutar(){
		global $smarty;
		//Si no tengo parametros, listo los usuarios
		if( !isset($_REQUEST['action']) ){
			if(isset($_SESSION['mail']) && $_SESSION['tipo'] == 2){//solo el encargado de ventas puede consultar los usuarios
					$usuario = $this->modelo->listar();
					if(is_array($usuario))
						include('View/usuarioListaView.php');		
					else
						echo 'Error no se pudo listar';
				}
				else {
					echo 'No tienes permisos para realizar esta accion';
				}
		}
		else switch($_REQUEST['action']){
			case 'insertar':
				if( !isset($_SESSION['mail']) || $_SESSION['tipo'] == 2 ){//un visitante y el encargado de ventas puede crear un nuevo usuario
					include('validaciones.php');
					if(isset($_REQUEST['nombre']) &&isset($_REQUEST['mail']) && isset($_REQUEST['pass'])  && isset($_REQUEST['direccion'])
					   && isset($_REQUEST['rfc']) && isset($_REQUEST['telefono']) && isset($_REQUEST['estatus']) && isset($_REQUEST['tipo'])){
					if( isNombre($_REQUEST['nombre']) && isMail($_REQUEST['mail']) && isPass($_REQUEST['pass']) && isDireccion($_REQUEST['direccion']) && 
						isRfc($_REQUEST['rfc']) && isTelefono($_REQUEST['telefono']) && isEstatus($_REQUEST['estatus']) && isTipo($_REQUEST['tipo']) ){
							 
						$estatus=1;
						$tipo=1;
						$usuario = $this->modelo->insertar($_REQUEST['nombre'],$_REQUEST['mail'],$_REQUEST['pass'],$_REQUEST['direccion'],$_REQUEST['rfc'],$_REQUEST['telefono'],$estatus,$tipo);
						//echo gettype($cadena);

						if ( is_object($usuario) )
						{
							require_once('phpmail/class.phpmailer.php');
							require_once('phpmail/class.smtp.php');
							
							
							$smarty->assign('registro', 'Registro Exitoso');
							$enlace= '<a class="btn btn-success" href="http://alanturing.cucei.udg.mx/cc409/virtualtd/index.php?modulo=estandar&action=login">AQUI</a>';
							
							
							
							
							
							
							
							$mensaje.= 'Gracias <b>'.$usuario->nombre.'</b> por registrarte en <em><strong>TD-INFORMATICA</strong></em>,
							ahora mismo puedes iniciar sesion y comenzar a realizar compras haciendo click'.'&nbsp;&nbsp;'.$enlace;
							$mensaje.= '</br></br>Tu correo de acceso es  '. $usuario->mail; 
							
							
							
							$smarty->assign('mensaje', $mensaje);
							$msg=  '<style>'.file_get_contents('bootstrap/css/bootstrap.css').'</style>';
							$msg.= '<div class="well span7 text-center">';
							$msg.='<a class="text-center" href="http://alanturing.cucei.udg.mx/cc409/virtualtd/index.php"><img class="img-rounded" src="images/logo_mail.jpg"  /></a></br>';
							$msg.=$mensaje.'</div>';
							
									
							$var=$smarty->fetch("usuario_registrado.tpl");
							ob_start();
							echo $var;
							//var_dump($usuario);
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
							$smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
							
							
							
							//Enviamos el correo
							$mail = new PHPMailer();
							$mail->IsSMTP();
							$mail->SMTPAuth = true;
							$mail->SMTPSecure = "ssl";
							$mail->Host = "smtp.gmail.com";
							$mail->Port = 465;

							
							$mail->Username = 'virtual.td.26@gmail.com';
							$mail->Password = 'virtualtd';
							
							$mail->From= 'virtual.td.26@gmail.com';
							$mail->FromName= 'Le Administradore';
							$mail->Subject = 'Registro en TD-INOFRMATICA';
							$mail->AltBody = 'No se puede mostrar el correo, por favor actualiza tu navegador';
							$mail->MsgHTML($msg);
							

							$mail->AddAddress($usuario->mail, $usuario->nombre);
							
							$log= fopen('mail_log.txt','a+');	
							
							if($mail->Send()) {
								//echo 'Email para '.$usuario->mail.' enviado correctamente el dia '.date('l jS \of F Y ').'a las '.date('h:i:s A')."\n";
								fwrite($log,'Email para '. $usuario->mail.' enviado correctamente el dia '.date('l jS \of F Y ').'a las '.date('h:i:s A')."\n");
							
							} else {
								fwrite($log,'No se pudo enviar el email a '.$usuario->mail.'\n');
							}
							fclose($log);

							
						}
						else
						{
							$smarty->assign('registro','Fallo el registro');
							$smarty->assign('mensaje','Lo sentimos, no se pudo completar el registro, intenta de nuevo');
							$var=$smarty->fetch("usuario_registrado.tpl");
							ob_start();
							echo $var;
							//var_dump($usuario);
							$panel = ob_get_clean();
						   //echo $count+"  saasdasd";
							$smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
							
						}
					}
					else 
						echo 'Datos no validos. Porfavor revise la sintaxis';

					}
					else
					{
						$smarty->assign('titulo',"Registrar cuenta");
						ob_start();
						  require 'templates/registrar_usuario.tpl';
						  //$smarty->assign('usuario',$_SESSION['usuario']);
						  $panel = ob_get_clean();
						  $smarty->assign('contenido',$panel);
						  
					}
					
				}
				else {
					echo 'No tienes permisos para realizar esta accion';
				}
				break;
			
			

			
			case 'listar':
				if(isset($_SESSION['mail']) && $_SESSION['tipo'] == 2){//solo el encargado de ventas puede consultar los usuarios
					$usuario = $this->modelo->listar();
					if(is_array($usuario))
						{
							$smarty->assign('usuarios', $usuario);
							
							$var=$smarty->fetch("vista_Usuario.tpl");
							ob_start();
							echo $var;
							//var_dump($usuario);
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						   $smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
							
						}
					else
						{
							$smarty->assign('usuarios', "No se han podido encontrar usuarios'");

							$var=$smarty->fetch("vista_Usuario.tpl");
							ob_start();
							echo $var;
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						   $smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
						}
				}
				else {
					echo 'No tienes permisos para realizar esta accion';
				}
						
				break;
			case 'consultarDato':
					//echo $_SESSION['tipo'];
					if( isset($_SESSION['mail']) ){//cualquiera puede consultar excepto un visitante
						include('validaciones.php');
						if(isset($_REQUEST['atributo']) && isset($_REQUEST['dato'])){
						if(isUsuarioAD($_REQUEST['atributo'],$_REQUEST['dato'])){
							$usuario = $this->modelo->consultarDato($_REQUEST['dato'],$_REQUEST['atributo']);
							//var_dump($usuario);
							if(is_object($usuario))
							{
								if( $_SESSION['tipo'] == 2  ){//si es un encargado de ventas puede consultar cualquier usuario
									include('View/usuarioListaView.php');	
								}
								else if( $usuario->mail ==  $_SESSION['mail'] ){//un cliente solo puede consultar informacion propia
									include('View/usuarioListaView.php');
								} 
								else
									echo 'No tienes permisos para ver la informacion de otro usuario';
								
							}
										
							else
								echo 'Error no se pudo listar';
						}
						else {
								echo 'Datos no validos. Porfavor revise la sintaxis';
							}
						}
						else
						{
							
							//$smarty->get_template_vars();
							
							
							
							//echo  $var;
							$smarty->assign('titulo',"Mi Perfil");
							$smarty->assign('usuario', $_SESSION['nombre']);
							$smarty->assign('correo', $_SESSION['mail']);
							$smarty->assign('direccion', $_SESSION['direccion']);
							$smarty->assign('rfc', $_SESSION['rfc']);
							$smarty->assign('telefono', $_SESSION['telefono']);

							$var=$smarty->fetch("perfil.tpl");
							ob_start();

						  echo $var;
						  $panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						  
						  $smarty->assign('titulocontenido','');
						  $smarty->assign('contenido',$panel);
						
						  

						}
					}
					else
						echo 'No tienes permisos para consultar esta informacion' ;
						
						break;
					
					
			case 'consultar':
				if(isset($_SESSION['mail']) && $_SESSION['tipo']==2)
				{
					//var_dump($_REQUEST['nombre']);
					$smarty->assign('titulo',"Consultar usuario");
					if(isset($_REQUEST['nombre']))
					{
						$usuario = $this->modelo->consultarDato($_REQUEST['nombre'],'nombre');
						echo "  sadsdasdasd.".count($usuario);
						/*if(is_object($usuario))
						{
							
							
							
							$smarty->assign('usuario', $usuario);
							
							$var=$smarty->fetch("vista_Usuario.tpl");
							ob_start();
							echo $var;
							//var_dump($usuario);
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						   $smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
							//$smarty->assign('contenido','Exito');
							
						}
						
						else*/
						if(is_array($usuario))
						{
							$smarty->assign('usuarios', $usuario);
							
							$var=$smarty->fetch("vista_Usuario.tpl");
							ob_start();
							echo $var;
							//var_dump($usuario);
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						   $smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
						}
						else
						{
							
							$smarty->assign('usuarios', "No se ha encontrado el usuario '$_REQUEST[nombre]'");

							$var=$smarty->fetch("vista_Usuario.tpl");
							ob_start();
							echo $var;
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						   $smarty->assign('titulocontenido','');
							$smarty->assign('contenido',$panel);
						}
					}
					else
					{
						$var=$smarty->fetch('consulta_usuario.tpl');
						ob_start();
						echo $var;
						$panel=ob_get_clean();
						$smarty->assign('titulocontenido','');
						$smarty->assign('contenido',$panel);
						
						
					}
					
					  
					
					
				}
				else
				echo "ERROR, no tienes permisos";
				
			break;
			
			case 'modificarPass':
				
						 if( isset($_SESSION['mail'])  ){//si es un cliente solo puede modificar su informacion 
							include('validaciones.php');
							
							if( isset($_REQUEST['passNuevo'])){
								if( $_REQUEST['passAnterior'] == $_SESSION['pass'] ){
									if(isUsuarioAD('pass',$_REQUEST['passNuevo'])){
										$usuario = $this->modelo->modificarDato($_SESSION['id'],$_REQUEST['passNuevo'],'pass');
										$_SESSION['pass']=$_REQUEST['passNuevo'];
										//var_dump($usuario);
										if($usuario == TRUE)
										{
											$smarty->assign('titulo',"Modificar contraseña");
											$smarty->assign('error',0);
											$var= $smarty->fetch("modificar_pass.tpl");
											ob_start();
											echo $var;
											$panel = ob_get_clean();
											$smarty->assign('contenido',$panel);
											$smarty->assign('titulocontenido','');
										}
										else {
											echo 'El campo no pudo ser modificado';
										}
									}
									else {
										echo 'Datos no validos. Porfavor revise la sintaxis';
									}
								}
								else{
									$smarty->assign('titulo',"Modificar contraseña");
									$smarty->assign('error',1);
									$var= $smarty->fetch("modificar_pass.tpl");
									ob_start();
									echo $var;
									$panel = ob_get_clean();
									$smarty->assign('contenido',$panel);
									$smarty->assign('titulocontenido','');	
								}
							}
							else
							{

										$smarty->assign('titulo',"Modificar contraseña");
										$smarty->assign('error',-1);
										$var= $smarty->fetch("modificar_pass.tpl");
										ob_start();
										echo $var;
										$panel = ob_get_clean();
										$smarty->assign('contenido',$panel);
										$smarty->assign('titulocontenido','');
										
	
							}
						} 
						else
							echo 'No tienes permisos para modificar la informacion de otro usuario';
						
						break;
					
					
				case 'modificarUsuario':
				
						if( isset($_SESSION['mail']) && $_SESSION['tipo'] == 2  ){//si es un encargado de ventas puede modificar cualquier usuario
							include('validaciones.php');
							
							if(isId($_REQUEST['id']) && isUsuarioAD($_REQUEST['atributo'],$_REQUEST['dato'])){
								$usuario = $this->modelo->modificarDato($_REQUEST['id'],$_REQUEST['dato'],$_REQUEST['atributo']);
								if($usuario == TRUE)
									echo 'El campo fue modificado exitosamente';
								else {
									echo 'El campo no pudo ser modificado';
								}	
							}
							else {
								echo 'Datos no validos. Porfavor revise la sintaxis';
								}
							
						}
						else if( isset($_SESSION['mail']) && $_REQUEST['id'] ==  $_SESSION['id'] ){//si es un cliente solo puede modificar su informacion 
							include('validaciones.php');
							if(isId($_REQUEST['id']) && isUsuarioAD($_REQUEST['atributo'],$_REQUEST['dato'])){
								$usuario = $this->modelo->modificarDato($_REQUEST['id'],$_REQUEST['dato'],$_REQUEST['atributo']);
								//var_dump($usuario);
								if($usuario == TRUE)
									echo 'El campo fue modificado exitosamente';
								else {
									echo 'El campo no pudo ser modificado';
								}
							}
							else {
								echo 'Datos no validos. Porfavor revise la sintaxis';
							}
						} 
						else
							echo 'No tienes permisos para modificar la informacion de otro usuario';
						
						break;	
					
					
			case 'modificar':
				$modificar = new Smarty();
				if( isset($_SESSION['mail']) ){
					include('validaciones.php');
					if(isset($_REQUEST['nombre']) &&isset($_REQUEST['mail']) && isset($_REQUEST['pass'])  && isset($_REQUEST['direccion'])
					   && isset($_REQUEST['rfc']) && isset($_REQUEST['telefono']) && isset($_REQUEST['estatus']) && isset($_REQUEST['tipo'])){
					if( isNombre($_REQUEST['nombre']) && isMail($_REQUEST['mail']) && isPass($_REQUEST['pass']) && isDireccion($_REQUEST['direccion']) && 
						isRfc($_REQUEST['rfc']) && isTelefono($_REQUEST['telefono']) && isEstatus($_REQUEST['estatus']) && isTelefono($_REQUEST['tipo']) ){
							 
						$usuario = $this->modelo->modificar($_REQUEST['nombre'],$_REQUEST['mail'],$_REQUEST['pass'],$_REQUEST['direccion'],$_REQUEST['rfc'],$_REQUEST['telefono'],$_REQUEST['estatus'],$_REQUEST['tipo']);
						//echo gettype($cadena);
						if ( is_object($usuario) )
							include('View/usuarioInsertadoView.php');
						else
							echo 'Error no se pudo insertar';
					}
					else 
						echo 'Datos no validos. Porfavor revise la sintaxis';
					}
					else
					{
						/*ob_start();
						  require 'templates/modificar_usuario.tpl';
						  $panel = ob_get_clean();
						  $smarty->assign('usuario',$_SESSION['nombre']);
						  //$modificar->display('modificar_usuario.tpl');
						  $smarty->assign('contenido',$panel);
						  $smarty->assign('titulocontenido','');
						  */
							
							$smarty->assign('titulo',"Editar perfil");
							$smarty->assign('id', $_SESSION['id']);
							$smarty->assign('usuario', $_SESSION['nombre']);
							$smarty->assign('correo', $_SESSION['mail']);
							$smarty->assign('direccion', $_SESSION['direccion']);
							if($_SESSION['rfc']!="")
								$smarty->assign('rfc', $_SESSION['rfc']);
							else
								$smarty->assign('rfc', "NULO");
							
							$smarty->assign('telefono', $_SESSION['telefono']);
							$smarty->assign('error','');
							$var=$smarty->fetch("modificar_usuario.tpl");
							ob_start();

							echo $var;
							$panel = ob_get_clean();
						  
						   //echo $count+"  saasdasd";
						  
						  $smarty->assign('titulocontenido','');
						  $smarty->assign('contenido',$panel);
						  
						  
					}
					
				}
				else {
					echo 'No tienes permisos para realizar esta accion';
				}
				break;
			
			
			case 'eliminar':
				if(isset($_SESSION['mail']) && $_SESSION['tipo']== 2)
				{
					
					if(isset($_REQUEST['id']))
					{
						$this->modelo->eliminar($_REQUEST['id']);
					}
					else
					{
						//header('Location: index.php');
					}
				}
				
				else
				{
					echo 'No tienes los permisos para eliminar ';
				}
				break;
			case 'modificaUsuario':
					include('validaciones.php');
					if(isset($_REQUEST['direccion']) && isset($_REQUEST['telefono']) ){
						$usuario = $this->modelo->modificaUsuario($_REQUEST['id'],$_REQUEST['direccion'],$_REQUEST['telefono']);
						//var_dump($usuario);
						if($usuario == TRUE){
							$error='El Usuario ha sido modificado';
							$smarty->assign('titulo','Editar Perfil');
							$smarty->assign('error',$error);
							$smarty->assign('usuario',$_REQUEST['usuario']);
							$smarty->assign('correo',$_REQUEST['correo']);
							$smarty->assign('rfc',$_REQUEST['rfc']);
							$var=$smarty->fetch("modificar_usuario.tpl");
							
							ob_start();
							echo $var;
							//var_dump($usuario);
							$panel = ob_get_clean();
							$smarty->assign('contenido',$panel);
						}
						
						else {
							echo 'El campo no pudo ser modificado';
						}
					}
					else {
						echo 'Datos no validos. Porfavor revise la sintaxis';
							}
				break;
			
			case 'checaUsuario':
				$smarty->assign('titulo',"Editar perfil");
				$smarty->assign('id', $_REQUEST['id']);
				$smarty->assign('usuario', $_REQUEST['nombre']);
				$smarty->assign('correo', $_REQUEST['mail']);
				$smarty->assign('direccion', $_REQUEST['direccion']);
				if($_REQUEST['rfc']!="")
					$smarty->assign('rfc', $_REQUEST['rfc']);
				else
					$smarty->assign('rfc', "NULO");
				
				$smarty->assign('telefono', $_REQUEST['telefono']);
				$smarty->assign('error', '');
				$var=$smarty->fetch("modificar_usuario.tpl");
				ob_start();

				echo $var;
				$panel = ob_get_clean();
			  
			   //echo $count+"  saasdasd";
			  
			  $smarty->assign('titulocontenido','');
			  $smarty->assign('contenido',$panel);
				break;
			default:
					echo 'Opcion no valida. Intente de nuevo';
					break;
		}				
		
		
	}
}

?>
