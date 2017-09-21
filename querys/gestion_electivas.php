<?php
	session_start();
	ob_start();

	$retorno = array();
	if ($_POST) {

		include "../functions.php";
		if (session_valida()) {
			$con = start_connect();
			if ($con)
      {
        switch ( $_POST["opcion"] )
				{
          case 1://Consultar electivas usuario
              $query = "SELECT id_electiva,nombre_electiva,desc_electiva,nombre_profesor,cupos,cupos_disponibles  FROM qr_electiva_usuario
                        WHERE id_usuario='". $_POST["id_user"] ."'
                        ORDER BY id_electiva ASC";
              $result = mysqli_query($con,$query);
              $electivas = array();
              while( $row = mysqli_fetch_array($result) )
  						{
  							$electivas[] = array(
            													"id" => $row["id_electiva"],
            													"nombre" => utf8_encode( $row["nombre_electiva"] ),
            													"descripcion" => utf8_encode( $row["desc_electiva"] ),
            													"profesor" => utf8_encode( $row["nombre_profesor"] ),
            													"profesor" => utf8_encode( $row["nombre_profesor"] ),
            													"cupos" => $row["cupos_disponibles"] ."/". $row["cupos"]
            												);
  						}
  						$retorno["status"] = "OK";
  						$retorno["electivas"] = $electivas;
            break;
          case 2://Consultar electivas disponibles para el usuario
              $query = "SELECT electiva_id_electiva FROM alumno_electiva WHERE usuarios_id_usuarios='". $_POST["id_user"] ."'";
              $result = mysqli_query($con,$query);
              $ids_in = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $ids_in[] = $row["electiva_id_electiva"];
              }
              $query = "SELECT id_electiva,nombre,descripcion,cupos,cupos_registrados,cupos_disponibles,nombre_profesor
                        FROM qr_electivas_cupos";
              if( !empty( $ids_in ) )
              {
                $query .= " WHERE id_electiva NOT IN (". implode(',',$ids_in) .")";

              }
              $query .= " ORDER BY id_electiva ASC";
              $result = mysqli_query($con,$query);
              $electivas = array();
              while( $row = mysqli_fetch_array($result) )
  						{
  							$electivas[] = array(
            													"id" => $row["id_electiva"],
            													"nombre" => utf8_encode( $row["nombre"] ),
            													"profesor" => utf8_encode( $row["nombre_profesor"] ),
            													"cupos_label" => $row["cupos_disponibles"] ."/". $row["cupos"],
            													"cupos" => $row["cupos"],
            													"cupos_registrados" => $row["cupos_registrados"],
            													"cupos_disponibles" => $row["cupos_disponibles"],
                                      "descripcion" => utf8_encode( $row["descripcion"] ),
            													"profesor" => utf8_encode( $row["nombre_profesor"] ),
            												);
  						}
  						$retorno["status"] = "OK";
  						$retorno["electivas"] = $electivas;
            break;
          case 3://Registrar electiva usuario
              $query = "INSERT INTO alumno_electiva(usuarios_id_usuarios, electiva_id_electiva)
                        VALUES('".  $_POST["id_user"] ."','". $_POST["id_electiva"] ."')";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
                $retorno["id"] = mysqli_insert_id($con);
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
              }
            break;
          case 4://Consultar datos usuario por electiva
              $query = "SELECT a.*, b.* FROM alumno_electiva AS a
                        LEFT JOIN qr_usuarios AS b ON a.usuarios_id_usuarios = b.id_usuarios
                        WHERE electiva_id_electiva='". $_POST["id_electiva"] ."'
                        ORDER BY nombres ASC";
              $result = mysqli_query($con,$query);
              $estudiantes = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $estudiantes[] = array(
                                      "id" => $row["id_usuarios"],
                                      "nombre" => utf8_encode( $row["nombres"] ),
                                      "apellido" => utf8_encode( $row["apellidos"] ),
                                      "email" => $row["email"]
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["estudiantes"] = $estudiantes;
            break;
          case 5://Consultar datos electivas por profesor
              $query = "SELECT * FROM electiva WHERE profesor_id_profesor='". $_POST["id_profesor"] ."' ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $electivas = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $electivas[] = array(
                                      "id" => $row["id_electiva"],
                                      "nombre" => utf8_encode( $row["nombre"] ),
                                      "descripcion" => utf8_encode( $row["descripcion"] )
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["electivas"] = $electivas;
            break;
          case 6://Consultar profesores
              $query = "SELECT * FROM qr_profesor ORDER BY nombres ASC";
              $result = mysqli_query($con,$query);
              $profesores = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $profesores[] = array(
                                      "id" => $row["id_profesor"],
                                      "nombre" => utf8_encode( $row["nombres"] ),
                                      "apellido" => utf8_encode( $row["apellidos"] )
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["profesores"] = $profesores;
            break;
          case 7://Consultar electivas
              $query = "SELECT * FROM qr_electiva ORDER BY id_electiva ASC";
              $result = mysqli_query($con,$query);
              $electivas = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $electivas[] = array(
                                      "id" => $row["id_electiva"],
                                      "nombre" => utf8_encode( $row["nombre"] ),
                                      "descripcion" => utf8_encode( $row["descripcion"] ),
                                      "cupos" => utf8_encode( $row["cupos"] ),
                                      "id_profesor" => $row["profesor_id_profesor"],
                                      "profesor" => utf8_encode($row["nombres"]) .' '. utf8_encode($row["apellidos"]) ,
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["electivas"] = $electivas;
            break;
          case 8://Registrar nueva electiva
              $query = "INSERT INTO electiva(nombre,descripcion,cupos,profesor_id_profesor)
                        VALUES('".  utf8_decode($_POST["nombre"]) ."','". utf8_decode($_POST["desc"]) ."','". $_POST["cupos"] ."','". $_POST["id_profesor"] ."')";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
                $retorno["id"] = mysqli_insert_id($con);
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
              }
            break;
          case 9://Actulizar electiva
              $query = "UPDATE electiva SET nombre='".  utf8_decode($_POST["nombre"]) ."', descripcion='". utf8_decode($_POST["desc"]) ."',
              cupos='". $_POST["cupos"] ."',profesor_id_profesor='". $_POST["id_profesor"] ."' WHERE id_electiva='". $_POST["id_electiva"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al realizar el Update en la BDD: ". mysqli_error($con);
              }
            break;
          case 10://Eliminar
              $query = "DELETE FROM electiva WHERE id_electiva='". $_POST["id"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al realizar el Update en la BDD: ". mysqli_error($con);
              }
            break;
        }

        //Close BD Connection
        if( !close_bd($con) )
        {
          $retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
        }
      }else{
				$retorno["status"] = "ERROR";
				$retorno["msg"] = "Fallo de conexion";
			}

		}else{
			$retorno["status"] = "EXPIRED";
			$retorno["msg"] = "Sesion no valida";
		}
	}else{
		$retorno["status"] = "ERROR";
		$retorno["msg"] = "POST vacio";
	}
	header('Content-Type: application/json');
	echo json_encode( $retorno );
?>
