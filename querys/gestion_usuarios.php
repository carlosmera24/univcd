<?php
  session_start();
  ob_start();
  $retorno = array();
  if( $_POST )
  {
    include "../functions.php";
    $con = start_connect();
      if( $con ) //Conexion establecida
      {
        switch ( $_POST["opcion"] )
        {
          case 1://Registrar nuevo estudiante
              //Verificar si el documento existe
              $query = "SELECT COUNT(documento) FROM persona WHERE documento='". $_POST["doc"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);
              if( $row[0] > 0 ) //El correo ya se encuentra registrado
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Documento estudiante registrado";
              }else
              {
                //Guardar datos en la tabla persona
                $query = "INSERT INTO persona(nombres, apellidos, email, documento)
                          VALUES('". utf8_decode($_POST["nombre"]) ."','". utf8_decode($_POST["apellido"]) ."','". $_POST["correo"] ."','". $_POST["doc"] ."')";
                if( mysqli_query($con,$query) )
                {
                  //Registrar usuario
                  $id_persona = mysqli_insert_id($con);
                  $query = "INSERT INTO usuarios(usuario,usuario_perfil_id_usuario_perfil, persona_id_persona)
                          VALUES('". $_POST["doc"] ."','2',
                          '". $id_persona ."')";
                  if( mysqli_query($con,$query) )
                  {
                    $retorno["status"] = "OK";
                    $retorno["id"] = mysqli_insert_id($con);
                  }else{
                    $retorno["status"] = "ERROR";
                    $retorno["msg"] = "Error al realizar el Insert usuario en la BDD: ". mysqli_error($con);
                  }
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert persona en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 2://Login estudiante
              $query = "SELECT id_usuarios, id_perfil, nombres FROM qr_usuarios WHERE usuario='". $_POST["doc"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);
              if( $row )
              {
                //Iniciar variables de session
                $_SESSION["tiempo_activo"] = time();
                $_SESSION["id_usuario"] = $row["id_usuarios"];
                $_SESSION["id_perfil"] = $row["id_perfil"];
                $_SESSION["nombres"] = utf8_encode($row["nombres"]);
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "INVALID";
                $retorno["msg"] = "Código no encontrado";
              }
            break;
          case 3://Login administrador
              $query = "SELECT id_usuarios, id_perfil, nombres
                        FROM qr_usuarios WHERE password=AES_ENCRYPT('". $_REQUEST["pass"] ."','". $GLOBALS["KEY_ENCRYPT_PASS"] ."') AND usuario='". $_POST["doc"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);
              if( $row )
              {
                //Iniciar variables de session
                $_SESSION["tiempo_activo"] = time();
                $_SESSION["id_usuario"] = $row["id_usuarios"];
                $_SESSION["usuario"] = $_POST["doc"];
                $_SESSION["id_perfil"] = $row["id_perfil"];
                $_SESSION["nombres"] = utf8_encode($row["nombres"]);
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "INVALID";
                $retorno["msg"] = "Usuario/Contraseña incorrectos";
              }
            break;
          case 4://Consultar perfiles
              $query = "SELECT * FROM usuario_perfil ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $perfiles = array( array( "id" => "null", "nombre" => "--Perfil--" ) );
              while( $row = mysqli_fetch_array($result) )
              {
                $perfiles[] = array( "id" => $row["id_usuario_perfil"], "nombre" => utf8_encode($row["nombre"]) );
              }
              $retorno["status"] = "OK";
              $retorno["perfiles"] = $perfiles;
            break;
          case 5: //Agregar nuevo usuario
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM usuarios WHERE usuario='". $_POST["usuario"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 )
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Usuario registrado";
              }else
              {
                $query = "INSERT INTO usuarios(usuario, password, usuario_perfil_id_usuario_perfil)
                          VALUES('". utf8_decode($_POST["usuario"]) ."',AES_ENCRYPT('". $_POST["password"] ."','". $GLOBALS["KEY_ENCRYPT_PASS"] ."'),'". $_POST["perfil"] ."')";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                  $retorno["id"] = mysqli_insert_id($con);
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Insert en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 6: //Actualizar usuario
              //Verificar que el correo no está registrado
              $query = "SELECT COUNT(*) FROM usuarios WHERE usuario='". $_POST["usuario"] ."' AND id_usuarios!='". $_POST["id_user"] ."'";
              $result = mysqli_query($con,$query);
              $row = mysqli_fetch_array($result);

              if( $row[0] > 0 )
              {
                $retorno["status"] = "EXIST";
                $retorno["msg"] = "Usuario registrado.";
              }else
              {
                $query = "UPDATE usuarios SET usuario='". utf8_decode($_POST["usuario"]) ."', password=AES_ENCRYPT('". $_POST["password"] ."','". $GLOBALS["KEY_ENCRYPT_PASS"] ."'),
                           usuario_perfil_id_usuario_perfil='". $_POST["perfil"] ."'
                           WHERE id_usuarios='". $_POST["id_user"] ."'";
                if( mysqli_query($con,$query) )
                {
                  $retorno["status"] = "OK";
                }else{
                  $retorno["status"] = "ERROR";
                  $retorno["msg"] = "Error al realizar el Update en la BDD: ". mysqli_error($con);
                }
              }
            break;
          case 7: //Consultar usuarios
              $query = "SELECT id_usuarios,usuario,AES_DECRYPT(password,'". $GLOBALS["KEY_ENCRYPT_PASS"] ."') AS password,id_perfil,perfil
                        FROM qr_usuarios ORDER BY id_usuarios ASC";
              $result = mysqli_query($con,$query);
              $usuarios = array();
              while( $row = mysqli_fetch_array($result) )
              {
                $usuarios[] = array(
                                      "id" => $row["id_usuarios"],
                                      "usuario" => utf8_encode( $row["usuario"] ),
                                      "id_perfil" => $row["id_perfil"],
                                      "perfil" => utf8_encode( $row["perfil"] ),
                                      "password" => $row["password"]
                                    );
              }
              $retorno["status"] = "OK";
              $retorno["usuarios"] = $usuarios;
            break;
          case 8://Eliminar usuario
              $query = "DELETE FROM usuarios WHERE id_usuarios='". $_POST["id_user"] ."'";
              if( mysqli_query($con,$query) )
              {
                $retorno["status"] = "OK";
              }else{
                $retorno["status"] = "ERROR";
                $retorno["msg"] = "Error al borrar el usuario: ". mysqli_error($con);
              }
            break;
        }
        //Close BD Connection
        if( !close_bd($con) )
        {
          $retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
        }
      }else //Error en conexion
      {
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "Error en la conexión a la BDD:". mysqli_connect_error();
      }
  }else
  {
    $retorno["status"] = "ERROR";
    $retorno["msg"] = "No se encontraron parámetros POST";
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode( $retorno );
?>
