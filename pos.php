<div class="col-sm-12" style="background-color:rgba(0,0,0,0.6);height:88vh;padding:15px 25px 15px 25px">
    <div class="row">

        <div class="col-sm-12" style="background-color:rgba(255,255,255,0.3);height:15vh;padding:20px">
            <div class="row">
                <div class="col-sm-2">
                    <label style="font-size:15px">CASHIER: </label><br>
                    <label style="font-size:15px">ACCESS_TYPE: </label><br>
                    <label style="font-size:15px">TRANSACTION NO: </label>

                </div>

                <div class="col-sm-3">
                    <label style="font-size:15px"><?php echo $user['user_lastname'].', '.$user['user_firstname']; ?></label><br>
                    <label style="font-size:15px"><?php echo $user['access_type']; ?></label><br>
                    <?php if(isset($_COOKIE['transaction_no'])){ ?>
                    <label style="font-size:15px"><?php echo $_COOKIE['transaction_no']; ?></label>
                    <?php } ?>
                </div>
                <div class="offset-sm-5 col-sm-2" style="text-align:center">
                    <label style="font-size:25px">SALE TOTAL:</label>
                    <?php 

                    if(isset($_COOKIE['transaction_no'])){
                        $sql ='SELECT * FROM invoice_rl WHERE transaction_no="'.$_COOKIE['transaction_no'].'"';
                        $total_sale = 0;
                        foreach($pdo->query($sql) as $transaction){
                            $total_sale += $transaction['total_product_price'];

                        } 
                        echo '<h1>&#8369;<span id="total_sale_span">'.number_format($total_sale,2,'.',',').'<span></h1>';

                    }


                    ?>
                </div>

            </div>


        </div>

        <div class="col-sm-12" style="margin-top:5px;height:60vh">
            <div class="row">
                <div class="col-sm-4" style="height:60vh;padding:0px 5px 0px 0px">
                    <div class="col-sm-12" style="background-color:rgba(255,255,255,0.3);height:100%;text-align:center">
                        <form method="post">
                            <label style="color:white">BARCODE</label>
                            <input id="pos_product" list="product" class="form-control user_form" name="prcode" placeholder="Search product barcode" autocomplete="off" disabled>
                            <datalist id="product">
                                <?php
                                $sql = 'SELECT * FROM product_tb';
                                foreach($pdo->query($sql) as $row){
                                    echo '<option value="'.$row['barcode'].'">'.$row['product_category'].' - '.$row['product_name'].'</option>';
                                }
                                ?>
                            </datalist>

                            <label style="color:white">QUANTITY:</label>
                            <input id="pos_quantity" type="number" max="999999" min="1" class="form-control user_form" name="quantity" step="1" value="1" disabled>
                            <br>
                            <button type="submit" id="addtocart" name="addtocart" class="col-sm-5" disabled>ADD</button>
                            <button type="submit" id="removetocart"name="removetocart" class="col-sm-5" disabled>REMOVE</button>
                        </form>


                    </div>
                </div>
                <div class="col-sm-8" style="height:60vh;padding:0px 0px 0px 0px">
                    <div class="col-sm-12" style="background-color:rgba(255,255,255,0.3);height:100%;overflow-y:scroll">
                        <table class="table table-sm table-bordered" style="font-size:12px">

                            <tr class="bg-dark" style="color:whitesmoke;">
                                <th>Barcode</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Selling Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>

                            </tr>   

                            <?php

                            if(isset($_COOKIE['transaction_no'])){
                                $sql = 'SELECT * FROM invoice_rl join transaction_rl, product_tb WHERE transaction_rl.transaction_no = invoice_rl.transaction_no and product_tb.barcode=invoice_rl.barcode and invoice_rl.transaction_no = "'.$_COOKIE['transaction_no'].'" ORDER BY invoice_rl.transaction_no';

                                foreach($pdo->query($sql) as $row){

                                    echo '<tr class="bg-light">';
                                    echo '<td>'.$row['barcode'].'</td>';
                                    echo '<td>'.$row['product_category'].'</td>';
                                    echo '<td>'.$row['product_name'].'</td>';
                                    echo '<td>&#8369;'.number_format($row['product_selling_price'],2,'.',',').'</td>';
                                    echo '<td>'.$row['quantity'].'</td>';
                                    echo '<td>&#8369;'.number_format($row['total_product_price'],2,'.',',').'</td>';
                                    echo '</tr>';   


                                }
                            }
                            ?>

                        </table>


                    </div>
                </div>

            </div>

        </div>

        <div class="col-sm-12" style="margin-top:5px;background-color:rgba(255,255,255,0.3);height:9vh;padding:20px">
            <div class="row">
                <div class="col-sm-2">
                    <button id="payment" type="button" class="btn btn-lg btn-success form-control" data-toggle="modal" data-target="#pay" disabled>PAYMENT</button>
                </div>

                <div class="col-sm-2">
                    <form method="post">
                        <button id="void" name="void" type="submit" class="btn btn-lg btn-danger form-control" disabled>VOID</button>
                    </form>
                </div>

                <div class="col-sm-2">
                    <form method="post">
                        <input type="hidden" name="hidden_user_no" value="<?php echo $user['user_no']; ?>">
                        <button name="new_transaction" type="submit" class="btn btn-lg btn-primary form-control">NEW TRANSACTION</button>
                    </form>
                </div>

                <div class="col-sm-2">
                    <button data-toggle="modal" data-target="#my_sales"type="button" class="btn btn-lg btn-primary form-control">SALES REPORT</button>
                </div>

                <div class="offset-sm-2 col-sm-2">
                    <form method="post">
                        <?php if($user['access_type'] == 'Administrator'){


    echo '<button type="submit" name="back_transaction" class="btn btn-lg btn-danger form-control">BACK</button>';
}else{
    echo '<button type="submit" name="logout_btn" class="btn btn-lg btn-danger form-control">LOG OUT</button>';

}
                        ?>
                    </form>
                </div>



            </div>
        </div>


    </div>

</div>

<form method="post">
    <div class="modal" id="pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">PAYMENTS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center">

                    <br>
                    <h1><?php echo $hardware['hardware_name']; ?></h1>
                    <br>
                  

                    <label>Customer:</label>
                    <input list="customer" class="form-control user_form" name="customer" value="CT000000001" autocomplete="off"> 
                    <datalist id="customer" >
                        <?php
                        $sql = 'SELECT * FROM customer_tb WHERE customer_status != "removed"';
                        foreach($pdo->query($sql) as $row){
                            echo '<option value="'.$row['customer_no'].'">'.$row['customer_lastname'].', '.$row['customer_firstname'].'</option>';
                        }
                        ?>
                    </datalist>

                    <label>DISCOUNT CODE:</label>
                    <input list="discounts" class="form-control user_form" name="discount_code" value="NONE" autocomplete="off"> 
                    <datalist id="discounts" >
                        <?php
                        $sql = 'SELECT * FROM discount_tb WHERE discount_status != "removed"';
                        foreach($pdo->query($sql) as $row){
                            echo '<option value="'.$row['discount_code'].'">'.$row['discounted_price'].'</option>';
                        }
                        ?>
                    </datalist>
                    <label>TOTAL PAYMENTS:</label>
                    <input type="number" readonly name="total_payment"  class="form-control user_form" value="<?php echo $total_sale; ?>">
                    <label>CASH TENDERED:</label>
                    <input type="number" step="0.01" name="cash" class="form-control user_form" name="customer" placeholder="Enter customer cash">
                    <label>CHANGE:</label>
                    <input type="number" readonly name="change" class="form-control user_form" value="0.00">



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="done_transaction" class="btn btn-success" disabled>Done</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal" id="my_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MY SALES REPORT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">
                <button type="button" id="my_sales_today" class="btn btn-success">TODAY</button>
                <button type="button" id="my_sales_all" class="btn btn-success">ALL</button>

                <div id="my_sale_today_div">
                    <h1>MY TODAY SALES</h1>
                    <?php echo date('F d, Y'); ?>
                    <div style="height:350px;overflow-y:scroll;margin-top:15px">
                        <table class="table">
                            <tr>
                                <th>Transaction#</th>
                                <th>Customer</th>
                                <th>Total Price</th>   
                                <th>Status</th>
                            </tr>

                            <?php

                            $sql1 = 'SELECT * FROM transaction_rl join customer_tb WHERE customer_tb.customer_no=transaction_rl.customer_no AND user_no = "'.$user['user_no'].'" AND transaction_date = "'.date('Y-m-d').'" ORDER BY transaction_date DESC, transaction_no DESC';

                            $t_void_count = 0;
                            $t_success_count=0;
                            $t_total = 0;
                            $t_networth = 0;

                            foreach($pdo->query($sql1) as $today_row){

                                echo '<tr>';
                                echo '<td>'.$today_row['transaction_no'].'</td>';
                                echo '<td>'.$today_row['customer_lastname'].', '.$today_row['customer_firstname'].'</td>';
                                echo '<td>&#8369;'.number_format($today_row['total_price'],2,'.',',').'</td>';
                                if($today_row['transaction_status'] == 'SUCCESS'){
                                    $transaction_status='GREEN';
                                }else{
                                    $transaction_status='MAROON';
                                }
                                echo '<td style="font-style:italic;font-weight:bold;color:'.$transaction_status.'">'.$today_row['transaction_status'].'</td>';

                                echo '</tr>';

                                if($today_row['transaction_status'] == 'SUCCESS'){
                                    $t_success_count++;
                                    $t_networth += $today_row['total_price'];


                                }else if($today_row['transaction_status'] == 'VOIDED'){
                                    $t_void_count++;
                                }

                                $t_total++;


                            }


                            ?>


                        </table>
                    </div>
                    <div style="margin-top:15px">
                        <label>VOIDED: <?php echo $t_void_count; ?> | </label>
                        <label>SUCCESS: <?php echo $t_success_count; ?> | </label>
                        <label>TOTAL SALES: <?php echo $t_total; ?> | </label>
                        <label>TOTAL INCOME:&#8369;<?php echo number_format($t_networth,2,'.',','); ?></label>
                    </div>

                </div>

                <div id="my_sale_all_div" style="display:none">
                    <h1>MY OVERALL SALES</h1>
                    <div style="height:350px;overflow-y:scroll;margin-top:15px">
                        <table class="table">
                            <tr>
                                <th>Transaction#</th>
                                <th>Customer</th>
                                <th>Total Price</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>

                            <?php

                            $sql2 = 'SELECT * FROM transaction_rl join customer_tb WHERE customer_tb.customer_no=transaction_rl.customer_no AND user_no = "'.$user['user_no'].'" AND transaction_date != "0000-00-00" ORDER BY transaction_date DESC, transaction_no DESC';

                            $a_void_count = 0;
                            $a_success_count=0;
                            $a_total = 0;
                            $a_networth = 0;

                            foreach($pdo->query($sql2) as $all_row){

                                echo '<tr>';
                                echo '<td>'.$all_row['transaction_no'].'</td>';
                                echo '<td>'.$all_row['customer_lastname'].', '.$all_row['customer_firstname'].'</td>';
                                echo '<td>&#8369;'.number_format($all_row['total_price'],2,'.',',').'</td>';
                                echo '<td>'.date('F d, Y', strtotime($all_row['transaction_date'])).'</td>';
                                if($all_row['transaction_status'] == 'SUCCESS'){
                                    $transaction_status='GREEN';
                                }else{
                                    $transaction_status='MAROON';
                                }
                                echo '<td style="font-style:italic;font-weight:bold;color:'.$transaction_status.'">'.$all_row['transaction_status'].'</td>';

                                echo '</tr>';

                                if($all_row['transaction_status'] == 'SUCCESS'){
                                    $a_success_count++;
                                    $a_networth += $all_row['total_price'];


                                }else if($all_row['transaction_status'] == 'VOIDED'){
                                    $a_void_count++;
                                }

                                $a_total++;


                            }


                            ?>


                        </table>
                    </div>

                    <div style="margin-top:15px">
                        <label>VOIDED: <?php echo $a_void_count; ?> | </label>
                        <label>SUCCESS: <?php echo $a_success_count; ?> | </label>
                        <label>TOTAL SALES: <?php echo $a_total; ?> | </label>
                        <label>TOTAL INCOME:&#8369;<?php echo number_format($a_networth,2,'.',','); ?></label>

                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary form-control" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

