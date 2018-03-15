var socket = io.connect('http://localhost:8080');

$(document).ready(function() {

  socket.on('admin order', function(data) {
    console.log(data);
  })



});


function realtimeOrder(data) {
  socket.emit('new order', data);
}
