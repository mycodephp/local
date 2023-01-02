
<?php
 require_once('../../config.php');
require_login();
if(!isloggedin()){

  return redirect(new moodle_url('/login'));
}
global $DB;

$limit_per_page = "";
if (isset($_POST['pageno'])) {
  $limit_per_page = $_POST['pageno'];
  setcookie("pageno_C", $limit_per_page);

  

} 
else {

  if (isset($_COOKIE['pageno_C'])) {
    $limit_per_page = $_COOKIE['pageno_C'];
  
  }
  else{
  $limit_per_page = 3;
}
}


  $page = "";
  if(isset($_POST["page_no"])){
    $page = $_POST["page_no"];
  setcookie("page_co", $page);

  //$_SESSION['page_no_c'] = $page;
  }else{

  // if (isset($_SESSION['page_no_c'])) {
  //   $page = $_SESSION['page_no_c'];
  // }

  if (isset($_COOKIE['page_co'])) {
     $page = $_COOKIE['page_co'];
     }

  else{

    $page = 1;
  }
  }

  $offset = ($page - 1) * $limit_per_page;

$sql = "select * from {user} LIMIT {$offset},{$limit_per_page}";

//$sql = "select * from {user} LIMIT {$offset},1";

$user = $DB->get_records_sql($sql);
  foreach ($user as $key => $user_value) {

  	  $table .= '<tr>
              <td><a href="http://localhost/moodle/user/editadvanced.php?id='.$user_value->id.'">'.$user_value->username.'</a></td>
              <td>'.$user_value->email.'</td>
              <td>'.$branchname->fullname.'</td>
            </tr>';

  }

 $sql_total = "select id FROM {user}";
 $total_record = $DB->count_records('user');
 $total_pages = ceil($total_record/$limit_per_page);
 $output .="<div class='main-pagination' id='pagination'>
 <nav aria-label='Page navigation example'>
   <ul class='pagination'>";
//  if($page>1){
//      $i = $page - 1;
//    $output .= "<a class='' id='{$i}' href='{$i}'>old</a>";
//  }
 $j=2;
     for($i=1; $i <= $total_pages; $i++){
       if($i == $page){
        
        
         $class_name = 'style="background-color: #666;
         color: white;"';
       }else{
         $class_name = "";
       }
 
   $output .= " <li class='page-item'><a {$class_name} class='page-link pclass' value='{$i}' href='{$i}'>{$i}</a></li>";
     
     }
  //    if(1){
  //      $i = $page + 1;
  //    $output .= "<a class='' id='{$i}' href='{$i}'>next</a>";
  //  }
     $output .=" <li class='page-item'>
     <a class='page-link' href='#' aria-label='Next'>
       <span aria-hidden='true'>&raquo;</span>
       <span class='sr-only'>Next</span>
     </a>
   </li>
 </ul>
</nav>
</div>";







  $json["html"]=$table;
  $json["htmlpagination"]=$output;


echo json_encode($json);

?>