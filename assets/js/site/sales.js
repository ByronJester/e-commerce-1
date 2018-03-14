

$(document).ready(function() {
  $('#sidenavToggler').trigger('click');



  $(document).on('click', '#genrange', function() {

    var from    = $("#from").val();
    var to      = $("#to").val();

    if (from != '' && to != '') {
      window.open(base_url+'admin/reports/genrange/'+from+'/'+to,'_blank');
    }

  })
})
