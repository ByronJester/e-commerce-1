<script src="<?= base_url('assets/js/site/products.js')?>"></script>


<div class="row">
  <div class="col-md-12">
    <div class="" align="right">
      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#newproductm">New Product</button>
    </div>
    <br>
    <div id="product-data">

    </div>

  </div>
</div>




<div class="modal" id="newproductm">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="newproduct">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">

            <div class="post-btn files" id="files1">
              <span class="btn-file fas fa-image fa-2x" style="display:inline">
                  <input type="file" name="files1" multiple accept="image/*" />
              </span>
              <b> Add Images </b>&nbsp;
              <ul class="fileList" style="margin-top: 10px"></ul>
            </div>

          </div>
          <div class="col-md-8">
              <label for="pname">Product Name</label>
              <input type="text" name="pname" class="form-control" placeholder="Product Name"> <br>
              <label for="pdesc">Product Description</label>
              <textarea name="pdesc" rows="6" class="form-control" style="resize:none"></textarea> <br>
              <label for="pprice">Product Price</label>
              <input type="number" name="pprice" class="form-control" placeholder="Product Price"> <br>
              <label for="pstock">Product Stock</label>
              <input type="number" name="pstock" class="form-control" placeholder="Product Price"> <br>
              <label for="pstock">Product Category</label>
              <select class="form-control categ" name="pcateg" id="pcateg"></select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">New Product</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="editproductmodal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editproduct">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">

          </div>
          <div class="col-md-8">
              <label for="pname">Product Name</label>
              <input type="text" name="epname" class="form-control" placeholder="Product Name"> <br>
              <label for="epdesc">Product Description</label>
              <textarea name="epdesc" rows="6" class="form-control" style="resize:none"></textarea> <br>
              <label for="pprice">Product Price</label>
              <input type="number" name="epprice" class="form-control" placeholder="Product Price"> <br>
              <label for="pstock">Product Stock</label>
              <input type="number" name="epstock" class="form-control" placeholder="Product Price"> <br>
              <label for="pstock">Product Category</label>
              <select class="form-control categ" name="epcateg" id="epcateg"></select>
              <input type="hidden" id="product_id" value="" name="product">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Edit Product</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>



<div class="modal" id="imagemodal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editproduct">
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4" style="border:1px solid #f2f2f2;padding:10px;">

              <div class="post-btn files" id="files2">
                <span class="btn-file fas fa-image fa-2x" style="display:inline">
                    <input type="file" name="files2" multiple accept="image/*" />
                </span>
                <b> Add Images </b>&nbsp;
                <ul class="fileList" style="margin-top: 10px"></ul>
              </div>

            </div>
            <div class="col-md-8">
              <div class="row" id="image-view" style="border:1px solid #f2f2f2;padding:10px;">

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Edit Product</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>



<style media="screen">
  .modal-backdrop{
    opacity: 0.4 !important;
  }
</style>
