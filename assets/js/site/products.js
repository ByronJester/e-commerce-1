$(document).ready(function() {

  getProducts();
  loadCateg();

  var filesToUpload = [];
  var files1Uploader = $("#files1").fileUploader(filesToUpload, "files1");

  function uploadImg(code) {


      var formData = new FormData();

      for (var i = 0, len = filesToUpload.length; i < len; i++) {
          formData.append("userfilex[]", filesToUpload[i].file);
      }

      $.ajax({
          url: base_url + "functions/multiple_upload/"+code,
          data: formData,
          processData: false,
          contentType: false,
          type: "POST",
          success: function (data) {
              files1Uploader.clear();
          },
          error: function (data) {
              alert("ERROR - " + data.responseText);
          }
      });


  }

  $(document).on('submit', '#newproduct', function(e) {

    e.preventDefault();

      var controller = "functions/newproduct";
      var data       = $(this).serialize();
      var onsuccess  = function(data) {

          if (data.code == 1) {
              swal('Error', data.reply, 'error');
          }else{
            getProducts();
            swal(
              'Success!',
              'Product Added',
              'success'
            )
            $('#newproduct')[0].reset();
            $('#newproductm').modal('hide');
            uploadImg(data.product);
          }

      };

      ajaxCall(controller, data, onsuccess);

  })

  $(document).on('click', '.deletepro', function() {
    var id = $(this).attr('id').substr(6);

      swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Pullout Product'
          }).then((result) => {
          if (result.value) {
                pullOut(id);
          }
          })
  })

  $(document).on('click', '.editpro', function() {

    var product = $(this).attr('id').substr(4);
		var name = $(this).closest('tr').find('td:eq(2)').text();
		var stock = $(this).closest('tr').find('td:eq(3)').text();
		var price = $(this).closest('tr').find('td:eq(4)').text();

    $('input[name=epname]').val(name);
    $('input[name=epstock]').val(stock);
    $('input[name=epprice]').val(price);
    $('#product_id').val(product);

    $('#editproductmodal').modal('show');


  })


  $(document).on('submit', '#editproduct', function(e) {
      e.preventDefault();
      var controller = "functions/editProduct";
      var data       = $(this).serialize();
      var onsuccess  = function(data) {

          if (data.code == 1) {
              swal('Error', data.reply, 'error');
          }else{
            getProducts();
            swal(
              'Success!',
              'Product Edited',
              'success'
            )
            $('#editproduct')[0].reset();
            $('#editproductmodal').modal('hide');
          }

      };

      ajaxCall(controller, data, onsuccess);
  })

  $(document).on('click', '.viewimage', function(){

    var product    = $(this).attr('id').substr(9);
    var controller = "functions/loadImages";
    var data       = {"product" : product};
    var onsuccess  = function(data){




    }
    $('#imagemodal').modal('show');



  });

})// document rady


function pullOut(id) {

  var controller = "functions/pulloutProduct";
  var data       = {"product" : id};
  var onsuccess  = function() {
    swal(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
    getProducts();
  };

  ajaxCall(controller, data, onsuccess);

}


function getProducts() {

  var controller = "functions/getProducts";
  var data       = '';
  var onsuccess  = function(data) {

      var append = `<table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th width="20%" style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>`;

      data.forEach(function(product) {
          append += `<tr>
                      <td></td>
                      <td>${product.product_code}</td>
                      <td>${product.product_name}</td>
                      <td>${product.product_stock}</td>
                      <td>${product.product_price}</td>
                      <td style="text-align:center">
                          <button class="btn btn-info viewimage" data-toggle="tooltip" title="View images" id="viewimage${product.id}">
                            <i class="fas fa-image"></i>
                          </button>
                          <button class="btn btn-warning editpro" data-toggle="tooltip" title="Edit Account" id="edit${product.id}">
                            <i class="far fa-edit"></i>
                          </button>
                          <button class="btn btn-danger deletepro" data-toggle="tooltip" title="Pull out Product" id="delete${product.id}">
                            <i class="fas fa-trash"></i>
                          </button>

                      </td>
                      </tr>`;
      })
      append += `</tbody>
              </table>`;

              $('#product-data').html(append);
      $('#example').DataTable();
  };

  var onerror = function() {

  }

  ajaxCall(controller, data, onsuccess, onerror);

}

function loadCateg() {
  var controller = "functions/loadCateg";
  var data       = "";
  var onsuccess  = function(data) {
    data['categories'].forEach(function(datax) {
      $('.categ').append(`<option>${datax.category_name}</option>`);
    })
  };

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


///////////////////////////////




$.fn.fileUploader = function (filesToUpload, sectionIdentifier) {
    var fileIdCounter = 0;

    this.closest(".files").change(function (evt) {
        var output = [];

        for (var i = 0; i < evt.target.files.length; i++) {
            fileIdCounter++;
            var file = evt.target.files[i];
            var fileId = sectionIdentifier + fileIdCounter;

            filesToUpload.push({
                id: fileId,
                file: file
            });

            var removeLink = "<a class=\"removeFile float-right\" href=\"#\" data-fileid=\"" + fileId + "\"><i class=\"fas fa-times\"></i></a>";

            output.push("<li><strong>", escape(file.name).substr(0,20), "</strong>  ", removeLink, "</li> ");
        };

        $(this).children(".fileList")
            .append(output.join(""));

        //reset the input to null - nice little chrome bug!
        evt.target.value = null;
    });

    $(this).on("click", ".removeFile", function (e) {
        e.preventDefault();

        var fileId = $(this).parent().children("a").data("fileid");

        // loop through the files array and check if the name of that file matches FileName
        // and get the index of the match
        for (var i = 0; i < filesToUpload.length; ++i) {
            if (filesToUpload[i].id === fileId)
                filesToUpload.splice(i, 1);
        }

        $(this).parent().remove();
    });

    this.clear = function () {
        for (var i = 0; i < filesToUpload.length; ++i) {
            if (filesToUpload[i].id.indexOf(sectionIdentifier) >= 0)
                filesToUpload.splice(i, 1);
        }

        $(this).children(".fileList").empty();
    }

    return this;
};
