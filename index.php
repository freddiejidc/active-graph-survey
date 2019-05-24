<?php 
//index.php
$connect = mysqli_connect("localhost", "donut", "", "root");
$sub_query = "
   SELECT framework, count(*) as no_of_like FROM like_table 
   GROUP BY framework 
   ORDER BY id ASC";
$result = mysqli_query($connect, $sub_query);
$data = array();
while($row = mysqli_fetch_array($result))
{
 $data[] = array(
  'label'  => $row["framework"],
  'value'  => $row["no_of_like"]
 );
}
$data = json_encode($data);
?>



<!DOCTYPE html>
<html>
 <head>
  <title>Restaurant Poll</title>  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <link rel="stylesheet" href="css/boot.css" />
  <link rel="stylesheet" href="css/main.css" />  
 </head>
 
<body>
<div class="jack">
    <img src="img.png" alt="Zaxbys" class="responsive">

</div>
  <br /><br />
  <h2 align="center">Make Zaxby's your choice for NBA Finals</h2>
  <div class="container" style="width:900px;">
   
   <form method="post" id="like_form">
    <div class="form-group"width="100%" >
    <br /><br />
     <label>Take our survey and win BIG!!!</label>
     <div class="radio">
      <label><input type="radio" name="framework" value="McDonalds" /> McDonalds</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="Wendys" /> Wendys</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="Chik-Fila" /> Chik-Fila</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="Burger King" /> Burger King</label>
     </div>
     <div class="radio">
      <label><input type="radio" name="framework" value="Zaxbys" /> Zaxbys</label>
     </div>
    </div>
    <div class="form-group">
     <input type="submit" name="like" class="btn btn-info" value="Vote" />
    </div>
   </form>
   <div id="chart"></div>
  </div>
 </body>
</html>

<script>

$(document).ready(function(){
 
 var donut_chart = Morris.Donut({
     element: 'chart',
     data: <?php echo $data; ?>
    });
  
 $('#like_form').on('submit', function(event){
  event.preventDefault();
  var checked = $('input[name=framework]:checked', '#like_form').val();
  if(checked == undefined)
  {
   alert("Please Like any Framework");
   return false;
  }
  else
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"includes/action.php",
    method:"POST",
    data:form_data,
    dataType:"json",
    success:function(data)
    {
     $('#like_form')[0].reset();
     donut_chart.setData(data);
    }
   });
  }
 });
});
</script>
<br /><br />
<img src="bimg.png" alt="Zaxbys" class="responsive">
