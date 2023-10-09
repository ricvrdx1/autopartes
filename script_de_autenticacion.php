<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $NombreCliente = $_POST["Nombre"];
    $Apellidos = $_POST["apellidos"];
    $DireccionCliente = $_POST["domicilio"];
    $TelefonoCliente = $_POST["Telefono"];
    $CorreoElectronicoCliente = $_POST["mail"];
    $Contraseña = $_POST["password"];

    // Conectarse a la base de datos (ajusta los valores según tu configuración)
    $servername = "localhost"; //dirección del servidor de base de datos
    $username = "root"; //nombre de usuario de la base de datos
    $password = "12345"; //contraseña de la base de datos
    $dbname = "autopartexpress"; //nombre de tu base de datos

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión a la base de datos
    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
    }

    // Preparar la consulta SQL (usando sentencias preparadas para evitar la inyección SQL)
    $sql = "INSERT INTO cliente (NombreCliente, Apellidos, DireccionCliente, TelefonoCliente, CorreoElectronicoCliente, Contraseña)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular parámetros y ejecutar la consulta
        $stmt->bind_param("ssssss", $NombreCliente, $Apellidos, $DireccionCliente, $TelefonoCliente, $CorreoElectronicoCliente, $Contraseña);
        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
        
        // Cerrar la sentencia preparada
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
