<?php 

 require_once('../../config.php');
require_login();
if(!isloggedin()){

  return redirect(new moodle_url('/login'));
}

echo  $OUTPUT->header();
$no_array=[3,5,10,15,20];
$option = "";




if (isset($_COOKIE['pageno_C'])) {

  foreach ($no_array as $key => $value) {
    if ($_COOKIE['pageno_C'] == $value) {
      $selected = "selected";
    }
    else{

      $selected = "";
    }
    $option .= "<option id={$value} {$selected} >{$value}</option>";
  }

}
else{

  foreach ($no_array as $key => $value) {
    $option.="<option id={$value}>{$value}</option>";
  }
}

$html = '
 <div class="main-containt">
    <div class="page-center">
      <div class="title-main">
        <h3>Total users:<span class="user-number">16</span></h3>
      </div>
      <div class="user-main-box">
        <div class="top-user">
          <form action="">
            <div class="left-content">
            <input id="p_id" type="hidden">
              <div class="contains">
                <select class="select custom-select cal_courses_flt" id="cars">
                  
                '.$option.'
                </select>
              </div>
              <div class="userinput-main">
                <label for="username">Username</label>
                <input type="text" id="username">
              </div>
              <button type="button" class="cst-btn primary-color">Filter</button>
              <a href="javascript:void(0);" class="anchor-cst filter-adv">Advanced Filter...</a>
            </div>
          </form>
          <div class="right-content">
            <div class="main-btn add-user">
              <a href="javascript:void();"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg><span>Add User</span></a>
            </div>
          </div>
        </div>
         

          <div class="cst-maintable">
            <table class="table">
              <thead>
                <tr>
                  <th>First name / Surname</th>
                  <th>Email address</th>
                  <th>City / Town</th>
                  <th>Country</th>
                  <th>Last access</th>
                  <th class="edit-th">Edit</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="tbody" >
               
                <div id="htmlpagination">
                </div>
              </tbody>
            </table>
          </div>
          
      </div>
    </div>
  </div>

';
echo $html;

echo $OUTPUT->footer();
?>


<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript">
function filter(){

   $.ajax({
      url: "ajax_data.php",
      type: "GET",
      dataType: "json",
      async: true,
      success: function (json) {
        if (json) {
            $("#tbody").html(json.html);
            $("#htmlpagination").html(json.htmlpagination);
        }
        else{
          $("#tbody").html("");
        }

      }
    });

}

$(document).ready(function() {

  
    function loadTable(page,pageno){
     // var pageno = $("#cars").val();
    //  $("#p_id").val(pageno)
      
      $.ajax({
      url: "ajax_data.php",
      type: "POST",
      dataType: "json",
      data:{page_no:page,pageno:pageno},
      async: true,
      success: function (json) {
            $("#tbody").html(json.html);
            $("#htmlpagination").html(json.htmlpagination);
      }
    });
    }
    loadTable();


   //Pagination Code
   $(document).on("click","#pagination a",function(e) {
      e.preventDefault();
      var page_id = $(this).attr("value");

loadTable(page_id);
    })

    $( "#cars" ).change(function() {
      var pageno = $("#cars").find(":selected").val();
     
      loadTable(1,pageno);
    
    })

    $('th').each(function (col) {
                    $(this).hover(
                            function () {
                                $(this).addClass('focus');
                            },
                            function () {
                                $(this).removeClass('focus');
                            }
                    );
                    $(this).click(function () {
                        if ($(this).is('.asc')) {
                            $(this).removeClass('asc');
                            $(this).addClass('desc selected');
                            sortOrder = -1;
                        } else {
                            $(this).addClass('asc selected');
                            $(this).removeClass('desc');
                            sortOrder = 1;
                        }
                        $(this).siblings().removeClass('asc selected');
                        $(this).siblings().removeClass('desc selected');
                        var arrData = $('table').find('tbody >tr:has(td)').get();
                        arrData.sort(function (a, b) {
                            var val1 = $(a).children('td').eq(col).text().toUpperCase();
                            var val2 = $(b).children('td').eq(col).text().toUpperCase();
                            if ($.isNumeric(val1) && $.isNumeric(val2))
                                return sortOrder == 1 ? val1 - val2 : val2 - val1;
                            else
                                return (val1 < val2) ? -sortOrder : (val1 > val2) ? sortOrder : 0;
                        });
                        $.each(arrData, function (index, row) {
                            $('tbody').append(row);
                        });
                    });
                });


                
  });


</script>


