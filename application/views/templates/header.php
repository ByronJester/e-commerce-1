<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="language" content="English">
  <title>Secret Shop</title>

  <!-- Bootstrap core CSS -->
  <link href="<?= base_url('assets/custemplate/') ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<link href="<?= base_url() ?>assets/css/fontawesome-all.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="<?= base_url('assets/custemplate/') ?>css/shop-homepage.css" rel="stylesheet">
	<script type="text/javascript" src="<?= base_url() ?>assets/js/sweetalert2.all.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/js/socket.io.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>assets/js/site/customer.js"></script>
  <input type="text" id="base_url" value="<?= base_url() ?>" hidden>
	<script type="text/javascript"> var base_url = $('#base_url').val();</script>
</head>
<style media="screen">
  .container-fluid{
    margin-top: 20px;
  }
</style>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">Secret Shop</a>
        <div style="max-width:300px;width:300px " style="display:inline">
          <input type="text" id="search" placeholder="Search product"  class="form-control" style="max-width:300px" onclick="$('.searchresult').show();">
            <div class="searchresult"  onmouseleave="$('.searchresult').hide();">
              <div class="resultdivx">
                Search . . .
              </div>
          </div>
        </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url() ?>">Products
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('cart') ?>">Cart <span class="badge" id="cartcount"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Order</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
