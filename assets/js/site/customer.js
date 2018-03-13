$(document).ready(function() {
  loadCartcount();

  var quantitiy=0;

    $(document).on('click', '.quantity-right-plus', function(e) {
        e.preventDefault();
        var id = $(this).attr('id').substr(4);
        var quantity = parseInt($('#quantity'+id).val());
        $('#quantity'+id).val(quantity + 1);
        var newx = $('#quantity'+id).val();
        addQty(newx, id);
    });



    $(document).on('click', '.quantity-left-minus', function(e) {
        e.preventDefault();
        var id = $(this).attr('id').substr(5);
        var quantity = parseInt($('#quantity'+id).val());
        if(quantity>1){
        $('#quantity'+id).val(quantity - 1);
        }
        var newx = $('#quantity'+id).val();
        minusQty(newx, id);
    });

    $(document).on('click', '.deletecart', function() {
        var cartid      = $(this).attr('id').substr(3);

        var controller  = "customer/removeItem";
        var data        = {"cartid" : cartid};
        var onsuccess   = function(data) {
          loadCart();
          swal(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }

        swal({
            title: 'Remove from cart?',
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


    $(document).on('click', '#porder', function() {
      swal({
          title: 'Confirm cart content?',
          text: "Place Order",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.value) {
              window.location.href = base_url + "placeorder";
          }
        })
    })





  $(document).on('click', '.addtocart', function() {
      var product = $(this).attr('id').substr(4);

      var controller = "customer/addcart";
      var data       = {"product" : product};
      var onsuccess  = function(data) {
          $('#cartcount').html(data.cart);
          swal(
              'Success',
              'Item added to cart',
              'success'
          )
      }

      ajaxCall(controller, data, onsuccess);

  })

  $(document).on('submit', '#userform', function(e) {
    e.preventDefault();

    var controller    = "customer/placeorder";
    var data          = $(this).serialize();
    var onsuccess     = function(data) {

        if (data.code == 1) {
            swal(
              'Error',
              data.reply,
              'error'
            )
        }else{
          swal(
            'Success',
            `Order has been placed, your order number is <b>${data.ordernum}</b>`,
            'success'
          )
          swal({
              title: 'Success',
              html: `Order has been placed, your order number is <br> <b>${data.ordernum}</b>`,
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Click here to redirect',
              allowOutsideClick: false
            }).then((result) => {
              if (result.value) {
                  window.location.href = base_url;
              }
            })
        }

    }


    swal({
        title: 'Confirm credentials?',
        text: "Place Order",
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

}); // DOCUMENT READ

function loadCartcount() {
  var controller = "customer/loadCartcount";
  var data       = '';
  var onsuccess  = function(data) {
    $('#cartcount').html(data.cart);
  }
  ajaxCall(controller, data, onsuccess);
}


function loadProducts($categ = '') {

  var controller  = "customer/loadProducts/"+$categ;
  var data        = '';

  var products    = "";
  var onsuccess   = function(data){


      if (data != 0) {
        data.forEach(function(data){

          products += `
                      <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                          <a href="${base_url}product/${data.slug}"><img class="card-img-top" src="${base_url+data.image}" alt=""></a>
                          <div class="card-body">
                            <h4 class="card-title">
                              <a href="${base_url}product/${data.slug}"">${data.name}</a>
                            </h4>
                            <h5>&#8369;${data.price}</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                          </div>
                          <div class="card-footer">
                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                            <button class="btn btn-info float-right addtocart" id="cart${data.id}">
                              <i class="fas fa-shopping-cart"></i>
                            </button>
                          </div>
                        </div>
                      </div>`;

        });
      }else{

        products += "<div class='noproduct'><center> <i class=\"fab fa-earlybirds bigbird\"></i><br> No Products Available </center></div>";

      }

      $('#products').html(products);


  }

  ajaxCall(controller, data, onsuccess);


}

function loadCart() {

    var controller = "customer/loadcart";
    var data       = "";
    var append     = "";
    var total      = 0;
    var osum       = "";
    var onsuccess  = function(data) {

        if (data.code != 0) {

          data.forEach(function(data) {
              append += `<div class="panel panel-cart">
                            <i class="fas fa-times deletecart" id="del${data.id}"></i>
                            <div class="row">
                              <div class="col-md-4">
                                <img src="${base_url+data.image}" class="img-responsive">
                              </div>
                              <div class="col-md-8">
                                  <h4>${data.name}</h4>
                                  <h5>&#8369; ${data.price}</h5>
                                  <br>
                                  <span>Quantity</span>
                                  <div class="input-group" style="bottom:0;position:absolute">
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="" id="minus${data.id}">
                                            <i class="fas fa-minus"></i>
                                          </button>
                                      </span>
                                      <input type="text" id="quantity${data.id}" name="quantity" class="cartqty input-number" value="${data.quantity}" min="1" max="100" readonly>
                                      <span class="input-group-btn">
                                          <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="" id="plus${data.id}">
                                              <i class="fas fa-plus"></i>
                                          </button>
                                      </span>
                                  </div>
                              </div>
                            </div>
                        </div>`;

              osum += `${data.name} &nbsp; (${data.quantity}) <b class="float-right">&#8369; ${data.quantity*data.price} </b> <br>`;
              total += data.quantity*data.price;

          })

          osum += `<hr><b>Total</b> <span align="right"><b class="float-right">&#8369; ${total}</b></span>`;

          $("#cartproducts").html(append);
          $('#osummary').html(osum);
          $("#porder").removeAttr('disabled');


        }else{
              var haha = "<div class='noproduct'><center> <i class=\"fab fa-earlybirds bigbird\"></i><br> Your cart is empty </center></div>";
              var hahax = "<div><center> <i class=\"fab fa-earlybirds bigbird\"></i><br> Your cart is empty </center></div>";
              $('#cartproducts').html(haha);
              $('#osummary').html(hahax);
        }



    }
    ajaxCall(controller, data, onsuccess);

}

var myvar = "";

function addQty(qty, id) {
  clearTimeout(myvar);

  var controller    = "customer/updateQty";
  var data          = {"item" : id, "qty" : qty};
  var onsuccess     = function() {
    loadCart();
  }

  myvar = setTimeout(function() {
          ajaxCall(controller, data, onsuccess);
  },500);

}
var myvar2 = ""
function minusQty(qty, id) {
  clearTimeout(myvar2);

  var controller    = "customer/updateQty";
  var data          = {"item" : id, "qty" : qty};
  var onsuccess     = function() {
    loadCart();
  }

  myvar2 = setTimeout(function() {
          ajaxCall(controller, data, onsuccess);
  },500);

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
