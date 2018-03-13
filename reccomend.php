<?php 

$saleID=1002;

$sql= '
SELECT buyerID 
FROM watchedsales
WHERE saleID= $saleID;
'
?> 



<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
  <div class="col-xl-12 content-box" style=" width: 58%; margin-left: 165px;">
    <div class="row row-featured">
        <div class="col-xl-12  box-title ">
            <div class="inner"><h2>Others who saved this item also liked... </h2>


            </div>
        </div>


        <div class="col-xl-4  box-title " style="border-right: 10px; border-left: 10px; text-align:center;">
            <h2><a href="#">Title</a></h2>
            <img src="images/pokemon.jpg">
        </div>

        <div class="col-xl-4  box-title " style="border-right: 10px; border-left: 10px; text-align:center;">
            <h2><a href="#">Title</a></h2>
            <img src="images/hat.jpg">
        </div>

        <div class="col-xl-4  box-title " style="border-right: 10px; border-left: 10px; text-align:center;">
            <h2><a href="#">Title</a></h2>
            <img src="images/yoga-mat.png">
        </div>
    </div>
</div>

</body>
</html>

