$(document).ready(function() {
  $('#sidenavToggler').trigger('click');
  loadOrders();


  $(document).on('click', '.deleteorder', function() {
        var order      = $(this).attr('id').substr(6);
        var controller = "functions/deleteOrder";
        var data       = {"order" : order};
        var onsuccess  = function() {
            loadOrders();
            swal(
              'Deleted!',
              'Order has been deleted',
              'success'
            )
        }


        swal({
            title: 'Delete Order?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
                  ajaxCall(controller, data, onsuccess);
            }
          })
  })

  $(document).on('click', '.acceptorder', function() {
        var order      = $(this).attr('id').substr(6);
        var controller = "functions/acceptOrder";
        var data       = {"order" : order};
        var onsuccess  = function(data) {

            if (data[0].code == 3) {
              var errhold = "";
              data.forEach(function(data) {
                errhold += data.msg+"<br>";
              })
              swal(
                'Error!',
                errhold,
                'error'
              )

            }else{
              loadOrders();
              swal(
                'Success!',
                'Order has been accepted',
                'success'
              )
            }

        }


        swal({
            title: 'Accept Order?',
            text: "The status will change to delivery",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => {
            if (result.value) {
                  ajaxCall(controller, data, onsuccess);
            }
          })
  });


  $(document).on('click', '.closeorder', function() {
      var order = $(this).attr('id').substr(5);
      var controller = "functions/closeOrder";
      var data       = {"order" : order};
      var onsuccess  = function() {
        loadOrders();
        swal(
          'Success!',
          'Order has been closed',
          'success'
        )
      }

      swal({
          title: 'Close Order?',
          text: "The status will change to closed",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.value) {
                ajaxCall(controller, data, onsuccess);
          }
        })



  })


  $(document).on('click', '.archiveorder', function() {
    var order = $(this).attr('id').substr(4);
    var controller = "functions/archiveOrder";
    var data       = {"order" : order};
    var onsuccess  = function() {
      loadOrders();
      swal(
        'Success!',
        'Order has been closed',
        'success'
      )
    }

    swal({
        title: 'Archive Order?',
        text: "The order will not show in the table anymore",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
              ajaxCall(controller, data, onsuccess);
        }
      })

  })


}); //DOCUMENT READY








function loadOrders() {

  var controller    = "functions/loadOrders";
  var data          = "";
  var onsuccess     = function(data) {
    console.log(data);

        var append  = `<table id="example" class="table  table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th style="width:70px">Customer Name</th>
                                <th style="width:50px">Email</th>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        </thead>
                        <tbody>`;

    data['orderinfo'].forEach(function(order) {

      var product   = order.product.split(',');
      var qty       = order.quantity.split(',');
      var count     = product.length;
      var x         = 0;
      var order_status = '';
      var buttons   = "";



      switch (order.order_status) {
        case '0':
            order_status = 'Pending';
            buttons      = `
                            <button class="btn btn-success acceptorder" data-toggle="tooltip" title="Approve Order" id="accept${order.order_num}">
                              <i style="color:#FFF" class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-danger deleteorder" data-toggle="tooltip" title="Decline Order" id="delete${order.order_num}">
                              <i class="fas fa-trash"></i>
                            </button>
                          `;
          break;
        case '1':
            order_status = 'Delivery';
            buttons      = `
                            <button class="btn btn-info closeorder" data-toggle="tooltip" title="Delivered" id="close${order.order_num}">
                              <i class="fas fa-truck"></i>
                            </button>
                            <button class="btn btn-danger deleteorder" data-toggle="tooltip" title="Delete Order" id="delete${order.order_num}" disabled>
                              <i class="fas fa-trash"></i>
                            </button>
                          `;

          break;
        case '2':
            order_status = 'Closed';
            buttons      = `
                            <button class="btn btn-danger archiveorder" data-toggle="tooltip" title="Archive Order" id="arch${order.order_num}">
                              <i class="fas fa-archive"></i>
                            </button>
                          `;
          break;
        default:

      }

      console.log(product);

      append       += `<tr>
                          <td rowspan="${count}" style="margin:0 auto;"><b>${order.order_num}</b></td>
                          <td rowspan="${count}">${order.cus_name}</td>
                          <td rowspan="${count}">${order.cus_email}</td>


                          `;
                            product.forEach(function(pid) {

                                if (x==0) {
                                  append += `
                                              <td><b>${data['productinfo'][pid]['product_name']}</b></td>
                                              <td><b>${qty[x]}</b></td>
                                              <td>₱ ${data['productinfo'][pid]['product_price']}</td>
                                              <td rowspan="${count}"><b>₱ ${order.total} </b></td>
                                              <td rowspan="${count}"><b>${order_status}</b></td>
                                              <td rowspan="${count}"  style="text-align:center">
                                                ${buttons}
                                              </td>
                                            </tr>`;
                                }else{
                                  append += `<tr>
                                              <td><b>${data['productinfo'][pid]['product_name']}</b></td>
                                              <td><b>${qty[x]}</b></td>
                                              <td>₱ ${data['productinfo'][pid]['product_price']}</td>

                                            </tr>`;
                                }
                                    x++;

                            });

                      append += "</tr>"




    });

    $("#order-data").html(append);
    //$('#example').DataTable();

  }
  ajaxCall(controller, data, onsuccess);

}



function ajaxCall(controller, data, onsuccess, onerror = '', onfailure = ''){

	$.ajax({

		type 	 : "POST",
		url 	 : base_url + controller,
		dataType : "JSON",
		data 	 : data,

		success	 : function(data){
			onsuccess(data);
		},
		error	 : function(data){
			onerror();
		},
		failure	 : function(data){
			onfailure();
		},

	});

}
