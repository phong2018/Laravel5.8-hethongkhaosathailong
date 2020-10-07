<html>
  <head>
    <meta charset="utf-8">
    <title>Laravel GeoChart Example</title> 
    <style type="text/css">
    #chart{
      width:500px;
    }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Laravel GeoChart Example</h2><br/>
      <div id="chart"></div>
      <?= $lava->render('BarChart', 'Football Fans', 'chart') ?>
   </div>
  </body>
</html>