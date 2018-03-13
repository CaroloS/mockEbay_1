        <?php

        	$_SESSION['username'] = "dbassi";

        $button_update = "<form action=\"edit.php?username=";
        $button_update .= "<?php echo {$_SESSION['username']}; ?>\" method=\"get\">";
        $button_update .= "<div class=\"form-group row\" style=\"padding-top: 10px;\">";
        $button_update .= "<label class=\"col-form-label\"></label>";
        $button_update .= "<div class=\"col-sm-3\">";
        $button_update .= "<input class=\"btn btn-block btn-primary\" type=\"submit\" value=\"Edit Account\" >";
        $button_update .= "</div></div></form>";

        echo $button_update;




                        $div = "<div class=\"col-xl-4  box-title \" style=\"border-right: 10px; border-left: 10px; text-align:center;\">";
                        $div .= "<h2><a href=\"item-page.php?saleID=<?php echo {$recommendations['saleID']}; ?>\"><?php echo {$recommendations['productName']}; ?>";
                        $div .= "</a></h2>";
                        $div .= "<img src=\"images/<?php echo {$recommendations['imageURL']}; ?>\">";
                        $div .= "</div>";

                        echo $div;


        ?>



<!--         <form action="<?php #echo "edit.php?username=" . $_SESSION['username']; ?>" method="get">
             <div class="form-group row" style="padding-top: 10px;">
                                        <label class="col-form-label"></label>
                                            <div class="col-sm-3">
                                                 <input class="btn btn-block btn-primary" type="submit" value="Edit Account" >
                                            </div>
                                        </div>
                                </form> -->