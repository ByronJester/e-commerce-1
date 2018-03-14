<link rel="stylesheet" href="<?= base_url('assets/datepicker/css/bootstrap-datepicker.min.css')?>">
<script src="<?= base_url('assets/datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?= base_url('assets/js/site/sales.js')?>"></script>
<style media="screen">
.ui-datepicker-trigger {
margin-top:7px;
margin-left: -30px;
margin-bottom:0px;
position:absolute;
z-index:1000;
}
</style>
<div class="row">
  <div class="col-md-3">
    <div class="panel panel-info">
      <div class="panel-heading">
        <span>Sales Reports</span>
      </div>
      <div class="panel-body">
        <div class="input-daterange" id="datepicker">
              <label for=""><b>From</b></label>
              <input type="text" class="input-sm form-control" name="start" placeholder="From" id="from"/>
              <span><b>To</b></span>
              <input type="text" class="input-sm form-control" name="end" placeholder="To" id="to"/>
          </div>
          <br>
          <input type="button" class="btn btn-info" value="Generate" id="genrange">
          <a href="<?= base_url('admin/reports/genall')?>" target="_blank"><input type="button" class="btn btn-info pull-right" value="Generate All"></a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    clearBtn: true,
    orientation: "bottom auto",
    toggleActive: true
});
</script>
