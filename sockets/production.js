/**
 * Created by Hubert Léo on 17/03/2018.
 */

const fs = require('fs');
const https = require('https');

const express = require('express');
const app = express();

const hskey = fs.readFileSync('ssl/www.ezgames.eu_private_key.key');
const hscert = fs.readFileSync('ssl/www.ezgames.eu_ssl_certificate.cer');
const ca = fs.readFileSync('ssl/ezgames.eu_ssl_certificate_INTERMEDIATE.cer');


const options = {
        ca: ca,
        key: hskey,
        cert: hscert
};

const serverPort = 4224;
const server = https.createServer(options, app);

const io = require('socket.io')(server);

server.listen(serverPort, function () {
    console.log('server up and running at %s port', serverPort);
});

require('./sockets.js')(io);