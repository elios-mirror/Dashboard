module.exports = function (io) {

    io.on('connection', function (socket) {
        console.log("New connection !");

        socket.on("linked", function (data) {
           io.emit("linked_" + data.mirror_id, data);
        });

        socket.on('disconnect', function () {
            console.log("Disconnected !");
        });
    });

};



