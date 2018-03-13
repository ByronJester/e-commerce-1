<input type="hidden" id="base_url" value="<?= base_url() ?>">
<link rel="stylesheet" href="<?= base_url('assets/logintemp/style.css') ?>">
<script src="<?= base_url('assets/js/jquery.min.js') ?>" charset="utf-8"></script>
<script src="<?= base_url('assets/logintemp/script.js');?>"></script>


<div class="wrapper">
	<div class="container">
		<h1>Welcome</h1>

		<form class="form">
			<input type="text" placeholder="Username" name="username">
			<input type="password" placeholder="Password" name="password">
			<button type="submit" id="login-button">Login</button>
      <br><br>
      <div class="error">

      </div>
		</form>
	</div>

	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
