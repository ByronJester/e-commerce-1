<link href="<?= base_url('assets/admintemp/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<div style="text-align: center; font-size:40px; font-weight:700">
  Secret Shop Report
</div>
<div class="row">
  <div class="col-md-12">
    <div id="order-data">

    </div>
  </div>
</div>

<?= $reports ?>
<?= $from ?>
<?= $to ?>

<script type="text/javascript">
  var action     = $("#action").val();
  var onsuccess     = function(data) {
    console.log(data);

        var append  = `<table id="example" class="table  table-bordered dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th style="width:50px">Customer Name</th>
                                <th style="width:50px">Email</th>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date Closed</th>
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
          break;
        case '1':
            order_status = 'Delivery';

          break;
        case '2':
            order_status = 'Closed';
          break;
        case '3':
            order_status = 'Closed';
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
                                              <td rowspan="${count}">${order.date_closed}</td>
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
    var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}

head.appendChild(style);

window.print();

  }

    if (action == 'genall') {

      var controller = "functions/"+action;
      var data       = "";

    }else{
      var controller = "functions/"+action;
      var data       = {"from" : $("#datefrom").val(), "to": $("#dateto").val()};
    }

    ajaxCall(controller, data, onsuccess);


    function ajaxCall(controller, data, onsuccess, onerror = '', onfailure = ''){

    	$.ajax({

    		type 	 : "POST",
    		url 	 : '<?= base_url() ?>' + controller,
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

</script>
