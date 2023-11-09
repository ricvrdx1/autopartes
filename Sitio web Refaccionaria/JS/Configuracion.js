const express = require('express');
const mysql = require('mysql');

const app = express();
app.use(express.json());
app.use(express.urlencoded({ extended: false }));

// Configura la conexión a la base de datos desde tu archivo de configuración
const dbConfig = require('./config.json');
const connection = mysql.createConnection(dbConfig);

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/registro.html');
});

app.post('/registrar', (req, res) => {
  const { Nombre, apellidos, domicilio, Telefono, mail, password } = req.body;

  // Realiza la inserción en la base de datos
  const query = 'INSERT INTO Cliente (NombreCliente, ApellidoCliente, DomicilioCliente, TelefonoCliente, CorreoCliente, ContraseniaCliente) VALUES (?, ?, ?, ?, ?, ?)';
  connection.query(query, [Nombre, apellidos, domicilio, Telefono, mail, password], (error, results) => {
    if (error) {
      console.error('Error al registrar el usuario:', error);
      return res.status(500).send('Error en el servidor.');
    }
    res.send('Usuario registrado con éxito.');
  });
});

app.listen(3000, () => {
  console.log('Aplicación de registro en ejecución en http://localhost:3000');
});
