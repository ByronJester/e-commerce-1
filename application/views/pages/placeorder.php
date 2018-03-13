<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="panel">
        <div class="panel-body">
          <form id="userform">
            <div class="row">
              <div class="col-md-6">
                <label for="">First Name</label>
                <input type="text" name="fname" class="form-control" placeholder="First name" required> <br>
                <label for="">Middle Name</label>
                <input type="text" name="mname" class="form-control" placeholder="Middle Name" required> <br>
                <label for="">Last Name</label>
                <input type="text" name="lname" class="form-control" placeholder="Last name" required> <br>
              </div>
              <div class="col-md-6">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required> <br>
                <label for="">Address</label>
                <textarea name="address" rows="8" class="form-control nores" placeholder="Brgy. Town, City, Province" required></textarea>
              </div>
            </div>
            <input type="submit" id="gogo" style="display:none">
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel">
        <div class="panel-body">
          <h3><center>Order Summary</center></h3>
          <hr>
          <div id="osummary">

          </div>
          <hr>
          <input type="button" onclick="$('#gogo').trigger('click');" class="form-control btn btn-info" value="Order">
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  loadCart();
</script>
