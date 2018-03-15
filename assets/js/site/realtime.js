var socket = io.connect('http://localhost:8080');

$(document).ready(function() {

  socket.on('admin order', function(data) {
    console.log(data);




    var append = `<a class="dropdown-item" href="#">
                      <span class="text-success">
                            <strong>
                            ${data.name}
                            </strong>
                      </span>
      <div class="dropdown-message small">${data.msg}</div>`;

      $('#notiff').html(append);
      $('#alertt').html('<i class="fa fa-fw fa-circle"></i>');
      if ($('#currentpage').val() == 'orders') {
        loadOrders();
      }


  })



});
