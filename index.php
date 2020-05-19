
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>generate pdf</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
     <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style>
 .btn{
   background-color: orange;
   color:green;
   border-radius: 5px;
   padding:5px 7px;

 }
    </style>
  </head>
  <body>
    <h1>Generate PDF from database using Tcpdf</h1>
    <form method="post" target="blank" action="generate.php">
     <label>From Date</label>
     <input type="text" name="fDate" id="fDate" placeholder="dd-mm-yy">
     <label>Secretary ID</label>
     <input type="text" name="secid" id="secid" placeholder="2351">
     <button type="submit" id="pdf" name="pdf" class="btn">Generate Pdf</button>
    </form>
  </body>
  <script>
  $("#fDate")datepicker({
    dateFormat:'dd-mm-yy'
  });
   </script>

</html>
