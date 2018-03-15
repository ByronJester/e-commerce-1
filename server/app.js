var express   = require('express');
var logger    = require('winston');
var app       = express();
var server    = require('http').createServer(app);
var port      = 8080;
var io        = require('socket.io')(server).listen(server);

server.listen(process.env.PORT || port);



// , {'pingInterval': 2000, 'pingTimeout': 5000}

logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, { colorize: true, timestamp: true });
logger.info('SocketIO > listening on port ' + port);


io.on('connection', function (socket){


		logger.info('SocketIO > Connected socket ' + socket.id);


		socket.on('disconnect', function(){
	    logger.info('Disconnected user id: ' + socket.id);
		});


    socket.on('new order', function(data) {
            io.emit('admin order', data);
						logger.info("neworder :"+ JSON.stringify(data));
    })





});
