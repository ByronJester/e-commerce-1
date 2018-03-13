$(document).ready(function() {
  loadProducts();


  var quantitiy=0;

    $(document).on('click', '.quantity-right-plus', function(e) {
        e.preventDefault();
        var id = $(this).attr('id').substr(4);
        var quantity = parseInt($('#quantity'+id).val());
        $('#quantity'+id).val(quantity + 1);
    });

     $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());

        // If is not undefined

            // Increment
            if(quantity>0){
            $('#quantity').val(quantity - 1);
            }
    });


        $(document).on('click', '.quantity-left-minus', function(e) {
            e.preventDefault();
            var id = $(this).attr('id').substr(5);
            var quantity = parseInt($('#quantity'+id).val());
            if(quantity>0){
            $('#quantity'+id).val(quantity - 1);
            }
        });








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

})

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

          products += `<div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                          <a href="#"><img class="card-img-top" src="${base_url+data.image}" alt=""></a>
                          <div class="card-body">
                            <h4 class="card-title">
                              <a href="#">${data.name}</a>
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
    var onsuccess  = function(data) {

        data.forEach(function(data) {
            append += `<div class="panel panel-cart">
                          <i class="fas fa-times deletecart"></i>
                          <div class="row">
                            <div class="col-md-4">
                              <img src="${base_url+'assets/images/product-default.jpg'}" class="img-responsive">
                            </div>
                            <div class="col-md-8">
                                <h4>${data.name}</h4>
                                <h5>&#8369; ${data.price}</h5>
                                <br>
                                <span>Quantity</span>
                                <div class="input-group">
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
        })

        $("#cartproducts").html(append);

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
