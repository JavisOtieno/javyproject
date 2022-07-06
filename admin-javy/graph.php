<?php include 'header.php';


        $query_first_promoter='SELECT * FROM users';
      $query_run=mysqli_query($db_link,$query_first_promoter);
      if($row=mysqli_fetch_assoc($query_run)){
        $upper_limit_time=$row['created_on'];

      }


      $promoters_array=array();
      while( $upper_limit_time<time() ){

      $upper_limit_time=$upper_limit_time+604800;
      $query_number_of_promoters='SELECT * FROM users WHERE created_on<'.$upper_limit_time;
      $query_run=mysqli_query($db_link,$query_number_of_promoters);
      $rows=mysqli_num_rows($query_run);

      array_push($promoters_array, $rows);

      }
      //print_r($promoters_array);


      $query_first_promoter='SELECT * FROM users';
      $query_run=mysqli_query($db_link,$query_first_promoter);
      if($row=mysqli_fetch_assoc($query_run)){
        $upper_limit_time=$row['created_on'];

      }


      $promoters_increase_array=array();
      while( $upper_limit_time<time() ){

      $new_upper_limit=$upper_limit_time+604800;     
      $query_number_of_promoters='SELECT * FROM users WHERE created_on>'.$upper_limit_time.' AND created_on<'.$new_upper_limit;

      $upper_limit_time=$new_upper_limit;

      $query_run=mysqli_query($db_link,$query_number_of_promoters);
      $rows=mysqli_num_rows($query_run);

      array_push($promoters_increase_array, $rows);

      }

      //print_r($promoters_increase_array);
      $query_first_promoter='SELECT * FROM deals WHERE status=1';
      $query_run=mysqli_query($db_link,$query_first_promoter);
      if($row=mysqli_fetch_assoc($query_run)){
        $upper_limit_time=$row['dealDate'];

      }

      $succesful_orders_increase_array=array();
      while( $upper_limit_time<time() ){

      $new_upper_limit=$upper_limit_time+604800;     
      $query_number_of_promoters='SELECT * FROM deals WHERE status=1 AND dealDate>'.$upper_limit_time.' AND dealDate<'.$new_upper_limit;

      $upper_limit_time=$new_upper_limit;

      $query_run=mysqli_query($db_link,$query_number_of_promoters);
      $rows=mysqli_num_rows($query_run);

      array_push($succesful_orders_increase_array, $rows);

      }


      $query_first_promoter='SELECT * FROM deals WHERE status=1';
      $query_run=mysqli_query($db_link,$query_first_promoter);
      if($row=mysqli_fetch_assoc($query_run)){
        $upper_limit_time=$row['dealDate'];

      }


      $earnings_increase_array=array();
      while( $upper_limit_time<time() ){

      $new_upper_limit=$upper_limit_time+604800;     
      $query_earnings='SELECT * FROM deals WHERE status=1 AND dealDate>'.$upper_limit_time.' AND dealDate<'.$new_upper_limit;

      $upper_limit_time=$new_upper_limit;

      $query_run=mysqli_query($db_link,$query_earnings);
      $rows=mysqli_num_rows($query_run);
      

      $commissions=0;

      while($row=mysqli_fetch_assoc($query_run)){
        $commissions+=$row['product_profit'];
      }

      array_push($earnings_increase_array, $commissions);

      }
      //print_r($earnings_increase_array);


       $query_first_promoter='SELECT * FROM deals WHERE status=1';
      $query_run=mysqli_query($db_link,$query_first_promoter);
      if($row=mysqli_fetch_assoc($query_run)){
        $upper_limit_time=$row['dealDate'];

      }


      $profits_increase_array=array();
      while( $upper_limit_time<time() ){

      $new_upper_limit=$upper_limit_time+604800;     
      $query_profits='SELECT * FROM deals WHERE status=1 AND dealDate>'.$upper_limit_time.' AND dealDate<'.$new_upper_limit;

      $upper_limit_time=$new_upper_limit;

      $query_run=mysqli_query($db_link,$query_profits);
      $rows=mysqli_num_rows($query_run);
      

      $profits=0;

      while($row=mysqli_fetch_assoc($query_run)){
        $profits+=$row['product_price']-$row['cost']-$row['product_profit'];
      }


      array_push($profits_increase_array, $profits);

      }
      //print_r($profits_increase_array);




       ?>

  <html>
  <head>

 

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {


      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Weeks');
      data.addColumn('number', 'Number of Promoters');
            data.addRows([
<?php 
$count=0;
foreach ($promoters_array as $value) {
  # code...
  echo '['.$count.',  '.$value.'],';
  $count++;
}

?>
        


      ]);
      //data.addColumn('number', 'The Avengers');
      //data.addColumn('number', 'Transformers: Age of Extinction');

      /*data.addRows([
        [1,  37.8, 80.8, 41.8],
        [2,  30.9, 69.5, 32.4],
        [3,  25.4,   57, 25.7],
        [4,  11.7, 18.8, 10.5],
        [5,  11.9, 17.6, 10.4],
        [6,   8.8, 13.6,  7.7],
        [7,   7.6, 12.3,  9.6],
        [8,  12.3, 29.2, 10.6],
        [9,  16.9, 42.9, 14.8],
        [10, 12.8, 30.9, 11.6],
        [11,  5.3,  7.9,  4.7],
        [12,  6.6,  8.4,  5.2],
        [13,  4.8,  6.3,  3.6],
        [14,  4.2,  6.2,  3.4]
      ]);
      */

      var options = {
        chart: {
          title: 'Total Promoters Number every week',
          subtitle: 'This shows how many users registered on the platform at the end of each week'
        },
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }





  
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {


      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Weeks');
      data.addColumn('number', 'Incremental Number of Promoters');
            data.addRows([
<?php 
$count=0;
foreach ($promoters_increase_array as $value) {
  # code...
  echo '['.$count.',  '.$value.'],';
  $count++;
}

?>
        


      ]);


      var options = {
        chart: {
          title: 'Promoters Increase in number per week',
          subtitle: 'This shows how many users signed up per week'
        },
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material2'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }


     google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart3);

    function drawChart3() {


      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Weeks');
      data.addColumn('number', 'Incremental Number of Complete Orders');
            data.addRows([
<?php 
$count=0;
foreach ($succesful_orders_increase_array as $value) {
  # code...
  echo '['.$count.',  '.$value.'],';
  $count++;
}

?>
        


      ]);


      var options = {
        chart: {
          title: 'Orders Increase in number per week',
          subtitle: 'This shows how many orders made per week'
        },
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material3'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }

    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart4);


    function drawChart4() {


      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Weeks');
      data.addColumn('number', 'Incremental Promoter Earnings');
            data.addRows([
<?php 
$count=0;
foreach ($earnings_increase_array as $value) {
  # code..
  echo '['.$count.',  '.$value.'],';
  $count++;
}

?>
        


      ]);


      var options = {
        chart: {
          title: 'Promoters Earnings Increase per week',
          subtitle: 'This shows promoters earnings per week'
        },
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material4'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }


     google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart5);


    function drawChart5() {


      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Weeks');
      data.addColumn('number', 'Incremental Profit');
            data.addRows([
<?php 
$count=0;
foreach ($profits_increase_array as $value) {
  # code..
  echo '['.$count.',  '.$value.'],';
  $count++;
}

?>
        


      ]);


      var options = {
        chart: {
          title: 'Profit Increase per week',
          subtitle: 'This shows profit per week'
        },
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('linechart_material5'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
    </script>
  </head>
  <body>
    <div id="linechart_material" style="width: 900px; height: 500px"></div>

    <div id="linechart_material2" style="width: 900px; height: 500px"></div>

    <div id="linechart_material3" style="width: 900px; height: 500px"></div>

    <div id="linechart_material4" style="width: 900px; height: 500px"></div>

    <div id="linechart_material5" style="width: 900px; height: 500px"></div>

  </body>
</html>