<?php

/**
 * @package TD_INFORMATICA
 * @subpackage clase VentaBss
 * @author Gabriel Ortiz Valdovinos <gabrielortiz_26@hotmail.com>
 */
class ventaBss {

	/**
	 * @param string $fecha de la creacion de la venta, double $total de la venta realizada
	 * @return bool TRUE si se pudo generar la venta, FALSE en caso contrario
	 */
	function crearFactura( $fecha, $cantidad, $precio, $estatus) {

		require ('facturaClass.php');

		//Conectarse a la base de datos
		require ('dbdata.inc');
		require ('dbClass.php');
		$conexion = new DB($hostdb, $userdb, $passdb, $db);
		if (!$conexion -> conecta())
			die('No se ha podido realizar la conexion a la bd');

		//Limpiar las variables recibidas
		$fecha = $conexion -> limpiarVariable($fecha);
		$cantidad = $conexion -> limpiarVariable($cantidad);
		$precio = $conexion -> limpiarVariable($precio);
		$estatus = $conexion -> limpiarVariable($estatus);


		//Crear el query
		$query = "INSERT INTO 
					factura (fecha, cantidad, precio, estatus)
				  VALUES 
					('$fecha',
					 '$cantidad',
					 '$precio',
					 '$estatus')";

		//Ejecutar el query
		$resultado = $conexion -> ejecutarConsulta($query);

		if ($resultado == FALSE) {
			echo 'FALLO la consulta';
			//Cerrar la conexion
			$conexion -> cerrar();
			return FALSE;
		} 
		else {
			$dolio = $resultado;
			//Cerrar la conexion
			$conexion -> cerrar();

			
			$factura= new facturaClass($folio, $fecha, $cantidad, $precio, $estatus);

			return $venta;
		}

	}//Fin de generarVenta()

	/**
	 * @param int $id de la venta que se desea cancelar
	 * @return bool TRUE si se pudo generar la venta, FALSE en caso contrario
	 */
	function modificarEstatus($folio) {

		require ('dbdata.inc');
		require ('dbClass.php');
		$conexion = new DB($hostdb, $userdb, $passdb, $db);

		if (!$conexion)
			die('LIST. No se ha podido realizar la conexion a la bd');

		$folio = $conexion -> limpiarVariable($folio);

		//Crear el query
		$query = 'SELECT *
					FROM  
						venta
					WHERE folio='.$folio;

		//Ejecutar el query
		$resultado = $conexion -> ejecutarConsulta($query);

		if (!$resultado) {
			echo 'FALLO la consulta';

			//Cerrar la conexion
			$conexion -> cerrar();
			return FALSE;
		} else {
			$conexion -> cerrar();
			return TRUE;
		}

	}// fin de cancelarVenta()

	
	/**
	 * @return mixed. bool FALSE si no se realizo la consulta, venta $resultado con los datos del objeto encontrado
	 */
	function listar() {
		require ('dbdata.inc');
		require ('dbClass.php');
		$conexion = new DB($hostdb, $userdb, $passdb, $db);

		if (!$conexion)
			die('LIST. No se ha podido realizar la conexion a la bd');

		//Crear el query
		$query = 'SELECT *
					FROM  
					factura';

		//Ejecutar el query
		$resultado = $conexion -> ejecutarConsulta($query);

		if (!$resultado) {
			echo 'FALLO la consulta';

			//Cerrar la conexion
			$conexion -> cerrar();
			return FALSE;
		} else {
			//Cerrar la conexion
			$conexion -> cerrar();

			return $resultado;
		}

	}//Fin de listar
	
	/**
	 * @param string $tipo atributo de la entidad, string $dato que se desea comparar
	 * @return mixed. bool FALSE si no se realizo la consulta, venta $resultado con los datos del objeto encontrado
	 */

	function consultar($tipo, $dato) {
		require ('dbdata.inc');
		require ('dbClass.php');
		$conexion = new DB($hostdb, $userdb, $passdb, $db);

		if (!$conexion)
			die('No se ha podido realizar la conexion a la bd');

		$tipo = $conexion -> limpiarVariable($tipo);
		$dato = $conexion -> limpiarVariable($dato);
		//Crear el query
		$query = 'SELECT *
					FROM  
						factura
					WHERE' . $tipo . '=' . $dato;

		//Ejecutar el query
		$resultado = $conexion -> ejecutarConsulta($query);

		if (!$resultado) {
			echo 'FALLO la consulta';

			//Cerrar la conexion
			$conexion -> cerrar();
			return FALSE;
		} else {
			//Cerrar la conexion
			$conexion -> cerrar();

			return $resultado;
		}

	}//Fin de consultar()

}//Fin de la clase ventaBss
?>