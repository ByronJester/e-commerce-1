$(document).ready(function() {
  $('#sidenavToggler').trigger('click');
  getProducts();
  loadCateg();

  var filesToUpload = [];
  var files1Uploader = $("#files1").fileUploader(filesToUpload, "files1");
  var files2Uploader = $("#files2").fileUploader(filesToUpload, "files2");

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
		var name    = $(this).closest('tr').find('td:eq(1)').text();
    var desc    = $(this).closest('tr').find('td:eq(2) span').attr('title');
		var stock   = $(this).closest('tr').find('td:eq(3)').text();
		var price   = $(this).closest('tr').find('td:eq(4)').text();
    var categ   = $(this).closest('tr').find('td:eq(5)').text();

    if (desc == undefined) {
        desc    = $(this).closest('tr').find('td:eq(2)').text();
    }

    $('input[name=epname]').val(name);
    $('textarea[name=epdesc]').val(desc);
    $('input[name=epstock]').val(stock);
    $('input[name=epprice]').val(price);
    $('#epcateg').val(categ);
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
    var append     = "";

      console.log(data);
      if (data[0].code != 2) {

        data.forEach(function(img) {
            append += `<div class="col-md-6">
                        <img src="${base_url+img.image_link}" class="img-responsive prodimg0">
                        </div>`;
        })

      }else{
          append  = `<div class="col-md-6"><h1>${data[0].msg}</h1></div>`;
      }

      $('#image-view').html(append);
      $('#imagemodal').modal('show');


    }

    ajaxCall(controller, data, onsuccess);

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

      var append = `<table id="example" class="table table-striped table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th style="width:150px !important;text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>`;

      data.forEach(function(product) {
          append += `<tr>
                      <td><b>${product.product_code}</b></td>
                      <td>${product.product_name}</td>
                      <td value="${product.product_description}">${product.product_description}</td>
                      <td>${product.product_stock}</td>
                      <td>${product.product_price}</td>
                      <td>${product.product_categ}</td>
                      <td style="text-align:center">
                          <button class="btn btn-info viewimage" data-toggle="tooltip" title="View images" id="viewimage${product.id}">
                            <i class="fas fa-image"></i>
                          </button>
                          <button class="btn btn-warning editpro" data-toggle="tooltip" title="Edit Account" id="edit${product.id}">
                            <i class="far fa-edit" style="color:#FFF"></i>
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
              $('#example').DataTable({
                                      "columnDefs": [ {
                                        "targets": 2,
                                        "data": "description",
                                        "render": function ( data, type, row, meta ) {
                                          return type === 'display' && data.length > 40 ?
                                            '<span title="'+data+'">'+data.substr( 0, 38 )+'...</span>' :
                                            data;
                                        }
                                      } ]
                                    }).column( 1 ).data().sort();

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
      $('.categ').append(`<option value="${datax.category_name}">${datax.category_name}</option>`);
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
