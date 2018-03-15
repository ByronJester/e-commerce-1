<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel">
        <?php if($product != 0): ?>
          <div class="hahahaha">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= base_url()?>">Products</a></li>
              <li class="breadcrumb-item"><a href="#"><?= $product['product_categ'] ?></a></li>
              <li class="breadcrumb-item active"><?= $product['product_name'] ?></li>
            </ul>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3">
                  <?php $x = 1; foreach($images as $image): ?>
                  <img src="<?= base_url().$image['image_link']; ?>"  class="prodimg<?= $x; ?>">
                <?php $x +=1; endforeach; ?>
                </div>
                <div class="col-md-9">
                  <h1><?= $product['product_name'] ?></h1>
                  <h4>&#8369; <?= $product['product_price'] ?></h4>
                  <p><?= $product['product_description'] ?></p>
                  <input type="button"  id="cart<?= $product['id']?>" value="Add to cart" class="btn btn-info float-right addtocart">
                </div>
              </div>
            </div>
        </div>
        <?php else: ?>
          <div style="text-align:center;padding:50px 10px 50px 10px;">
            <i class="fab fa-earlybirds fa-7x" style="font-size:300px"></i>
            <h1>No Product Found</h1>
            <span><a href="<?= base_url() ?>" style="text-decoration:none">Return to home</a></span>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
