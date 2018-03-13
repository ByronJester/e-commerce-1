<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/4/litera/bootstrap.min.css">
	<link href="<?= base_url() ?>assets/css/fontawesome-all.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/datatables/datatables.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?= base_url() ?>assets/js/sweetalert2.all.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/tether.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/popper.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/js/socket.io.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?= base_url()?>assets/datatables/dataTables.bootstrap4.min.js"></script>
	<input type="text" id="base_url" value="<?= base_url() ?>" hidden>
	<script type="text/javascript"> var base_url = $('#base_url').val(); var userid = $('#user_id').val();</script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">E-Commerce</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
        <li>
          <a class="nav-link" href="<?= base_url('admin/home') ?>">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/products') ?>">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/reports') ?>">Reports</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/about') ?>">About</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

	<div class="container-fluid">
