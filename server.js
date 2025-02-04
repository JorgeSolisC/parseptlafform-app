// Importar los módulos necesarios
import express from 'express';
import { ParseServer } from 'parse-server';
import http from 'http';

// Configuración de Parse Server
const parseServerConfig = {
    "allowInsecureHTTP": "true",
  databaseURI: 'mongodb://localhost:27017/parse', // URI de MongoDB
  appId: 'MiSuperApp123', // ID de la aplicación (debe coincidir con dashboard.json)
  masterKey: 'MiMasterKey456', // Clave maestra (debe coincidir con dashboard.json)
  serverURL: 'http://localhost:1337/parse', // URL del servidor de Parse
  liveQuery: {
    classNames: ['_User'], // Clases que soportarán LiveQuery
  },
  webhook: "http://localhost:1337/parse",
  websocketTimeout: 10 * 1000,
  cacheTimeout: 60 * 600 * 1000,
  logLevel: 'VERBOSE'
};

// Crear una instancia de Parse Server
const api = new ParseServer(parseServerConfig);

// Crear una aplicación Express
const app = express();

// Servir la API de Parse en la ruta /parse
app.use('/parse', api);

// Ruta de inicio (opcional)
app.get('/', (req, res) => {
  res.send('Parse Server está en funcionamiento.');
});

// Iniciar el servidor en el puerto 1337 usando http
const port = 1337;
const httpServer = http.createServer(app);
httpServer.listen(port, () => {
  console.log(`Parse Server está ejecutándose en http://localhost:${port}/parse`);
});

// Iniciar el servidor de LiveQuery
ParseServer.createLiveQueryServer(httpServer);
