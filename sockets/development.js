/**
 * Created by Hubert Léo on 17/03/2018.
 */

const serverPort = 4224;

const io = require('socket.io')(serverPort);

console.log("Development server started with port: " + serverPort);

require('./sockets.js')(io);