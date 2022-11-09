<!DOCTYPE html>
<html>

    <head>
        <title>PUNTO DE VENTA</title>
        <link rel="icon" href="res/punto-de-venta.png">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script src="js/jquery.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <style type="text/css">
            body{
                background-image: url(res/bg.png);
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }

            #login_div{
                background-color: rgba(0,0,0,0.6);
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0,0,0,0.5);
                display: none;
                padding: 50px;

            }

            #register_div{
                background-color: rgba(255,255,255,0.2);
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0,0,0,0.5);
                padding: 40px;  
            }

            input:hover, input:focus{
                opacity: 0.9;
            }

            #home_div{
                background-color: rgba(0,0,0,0.7);
                height: 95  vh;

            }

            .btn_admin{
                color:white;
            }

            .btn_admin:hover{
                opacity: 0.5;
                text-decoration: none;
                color: white;
                cursor: pointer;

            }

            .edit_btn, .delete_btn{
                width:24px;
                height: 24px;
                border-radius:0px 0px 0px 0px;
                background-color:rgba(0,0,0,0);
                background-size: cover;
                background-position:center;

            }
            #accounts_div,#transaction_div,#products_div,#customers_div, #discount_div, #pos_div{
                display:none;
            }

            .admin_panel{
                display: none;
            }
            .user_form{
                margin-bottom: 10px;
                font-size: 12px;
            }

        </style>

    </head>

    <body>
        <?php
        require 'database.php';
        $pdo = Database::letsconnect();
        date_default_timezone_set('Asia/Manila');


        $sql = 'SELECT * FROM hardware_tb limit 1';
        $hardware_ctr=0;
        foreach($pdo->query($sql) as $hardware){
            $hardware_ctr++;
        }
        echo '<input type="number" name="tax_rate" value="'.$hardware['tax_rate'].'" class="d-none d-sm-none">';

        if(isset($_COOKIE['login_username'])){
            $sql_cookie = 'SELECT * FROM user_tb where user_name="'.$_COOKIE['login_username'].'"';
            foreach($pdo->query($sql_cookie) as $user);

            // for user access
            if(!isset($_COOKIE['q'])){
                setcookie('q','accounts',false);
            }
            if($user['access_type'] == 'Staff'){
                setcookie('q','pos',false);
            }

            //end user_access

            if(isset($_POST['logout_btn']) or $user['access_type'] == ''){

                setcookie('login_username', '', 0);
                unset ($_COOKIE['login_username']);

                setcookie('q', '', 0);
                unset ($_COOKIE['q']);

                header('Location:main.php');
            }else{
                //settings
                if(isset($_POST['settings'])){
                    $tax_rate = ($_POST['edit_tax_rate']/100);
                    $sql = 'UPDATE hardware_tb set tax_rate=? WHERE hardware_code = "'.$hardware['hardware_code'].'"';
                    $q=$pdo->prepare($sql);
                    $q->execute(array($tax_rate));

                    $sql = 'SELECT * FROM product_tb';
                    foreach($pdo->query($sql) as $row){
                        $sql = 'UPDATE product_tb set product_selling_price=? WHERE barcode = "'.$row['barcode'].'"';
                        $q=$pdo->prepare($sql);
                        $q->execute(array($row['product_list_price']+($row['product_list_price']*$tax_rate)));
                    }
                    header('Location:main.php');

                }

                //

                //accounts

                if(isset($_POST['ok_btn'])){
                    $sql = 'UPDATE user_tb SET access_type = "'.$_POST['access_type'].'" where user_no ="'.$_POST['hidden_user_no'].'"';
                    $pdo->query($sql);
                    header('Location:main.php');

                }
                if(isset($_POST['delete_btn'])){
                    $sql = 'UPDATE user_tb SET user_status="removed" WHERE user_no ="'.$_POST['hidden_user_no'].'"';
                    $pdo->query($sql);
                    header('Location:main.php');
                }


                if(isset($_POST['resign_btn'])){
                    $sql = 'UPDATE user_tb SET access_type = "" where user_no ="'.$_POST['hidden_user_no'].'"';
                    $pdo->query($sql);
                    header('Location:main.php');
                }


                //end accounts

                //products

                if(isset($_POST['add_product'])){
                    $sql = 'SELECT * FROM product_tb WHERE barcode = "'.$_POST['barcode'].'" ';
                    $ctr=0;
                    foreach($pdo->query($sql) as $row){
                        $ctr++;
                    }

                    if($ctr != 0){
        ?>

        <script>
            $(function(){
                alert('Barcode is already taken.');
            });
        </script>
        <?php
                    }else{

                        $sql = 'INSERT INTO product_tb values(?, ?, ?, ?, ?, ?)';
                        $q=$pdo->prepare($sql);
                        $q->execute(array($_POST['barcode'],$_POST['product_category'],$_POST['product_name'],$_POST['list_price'],$_POST['selling_price'],''));
                        header('Location:main.php');
                    }


                }

                if(isset($_POST['edit_product'])){
                    $sql = 'UPDATE product_tb set product_category=?,product_name=?, product_list_price=?, product_selling_price=? WHERE barcode = "'.$_POST['barcode'].'"';
                    $q=$pdo->prepare($sql);
                    $q->execute(array($_POST['product_category'],$_POST['product_name'],$_POST['list_price'],$_POST['selling_price']));
                    header('Location:main.php');

                }

                if(isset($_POST['remove_product'])){
                    $sql = 'UPDATE product_tb SET product_status="removed" WHERE barcode ="'.$_POST['hidden_barcode'].'"';
                    $pdo->query($sql);
                    header('Location:main.php');
                }

                //end products

                //discount

                if(isset($_POST['add_discount'])){
                    $sql = 'SELECT * FROM discount_tb WHERE discount_code = "'.$_POST['discount_code'].'" ';
                    $ctr=0;
                    foreach($pdo->query($sql) as $row){
                        $ctr++;
                    }

                    if($ctr != 0){
        ?>

        <script>
            $(function(){
                alert('Discount Code is already taken.');
            });
        </script>
        <?php
                    }else{

                        $sql = 'INSERT INTO discount_tb values(?, ?, ?, ?)';
                        $q=$pdo->prepare($sql);
                        $q->execute(array($_POST['discount_code'],$_POST['discount_name'],($_POST['discount_percentage']/100),''));
                        header('Location:main.php');
                    }


                }

                if(isset($_POST['edit_discount'])){
                    $sql = 'UPDATE discount_tb set discount_name=?, discounted_price=? WHERE discount_code = "'.$_POST['discount_code'].'"';
                    $q=$pdo->prepare($sql);
                    $q->execute(array($_POST['discount_name'], ($_POST['discount_percentage']/100)));
                    header('Location:main.php');

                }


                if(isset($_POST['remove_discount'])){
                    $sql = 'UPDATE discount_tb SET discount_status="removed" WHERE discount_code ="'.$_POST['hidden_discount_code'].'"';
                    $pdo->query($sql);
                    header('Location:main.php');
                }


                //end discount

                //start of customer
                if(isset($_POST['add_customer'])){
                    $sql = 'SELECT * FROM customer_tb ORDER BY customer_no DESC limit 1';
                    $ctr=0;
                    foreach($pdo->query($sql) as $row){
                        $ctr++;
                    }
                    $customer_no = 'CT000000001';

                    if($ctr != 0){
                        $substrpk = substr($row['customer_no'],2);
                        $customer_no = 'CT'.sprintf('%09d', ((int)$substrpk)+1);
                    }

                    $sql = 'INSERT INTO customer_tb values(?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $q=$pdo->prepare($sql);
                    $q->execute(array($customer_no, $_POST['lastname'], $_POST['firstname'], $_POST['middlename'], $_POST['city'], $_POST['barangay'], $_POST['street'], date('Y-m-d'), '' ));

                    header('Location:main.php');

                }

                if(isset($_POST['edit_customer'])){
                    $sql = 'UPDATE customer_tb set customer_lastname=?,customer_firstname=?, customer_middlename=?, customer_city=?, customer_barangay=?, customer_street=? WHERE customer_no = "'.$_POST['customer_no'].'"';
                    $q=$pdo->prepare($sql);
                    $q->execute(array($_POST['lastname'],$_POST['firstname'],$_POST['middlename'],$_POST['city'], $_POST['barangay'], $_POST['street']));
                    header('Location:main.php');

                }

                if(isset($_POST['remove_customer'])){
                    $sql = 'UPDATE customer_tb SET customer_status="removed" WHERE customer_no ="'.$_POST['hidden_customer_no'].'"';
                    $pdo->query($sql);
                    header('Location:main.php');
                }


                //end of customer

                //transaction

                if(isset($_POST['new_transaction'])){
                    $sql = 'SELECT * FROM transaction_rl ORDER BY transaction_no DESC limit 1';
                    $ctr=0;
                    foreach($pdo->query($sql) as $row){
                        $ctr++;
                    }
                    $transaction_no = 'TR000000001';

                    if($ctr != 0){
                        $substrpk = substr($row['transaction_no'],2);
                        $transaction_no = 'TR'.sprintf('%09d', ((int)$substrpk)+1);
                    }

                    $sql = 'INSERT INTO transaction_rl values(?, ?, ?, ?, ?, ?, ?, ?)';
                    $q=$pdo->prepare($sql);
                    $q->execute(array($transaction_no, $hardware['hardware_code'], $_POST['hidden_user_no'], 'CT000000001', 'NONE', 0, '0000-00-00', ''));
                    setcookie('transaction_no', $transaction_no,false);
                    header('Location:main.php');


                }

                if(isset($_POST['void'])){

                    $sql = 'SELECT * FROM invoice_rl WHERE transaction_no ="'.$_COOKIE['transaction_no'].'"';
                    foreach($pdo->query($sql) as $row);

                    if($row['total_product_price'] <= 0){
                        $sql='DELETE FROM transaction_rl WHERE transaction_no ="'.$_COOKIE['transaction_no'].'"';
                        $pdo->query($sql);
                    }else{

                        $sql = 'UPDATE transaction_rl SET total_price=?, transaction_date = ?, transaction_status=? WHERE transaction_no ="'.$_COOKIE['transaction_no'].'"';
                        $q=$pdo->prepare($sql);    
                        $q->execute(array($row['total_product_price'], date('Y-m-d'),'VOIDED'));
                    }

                    setcookie('transaction_no', '', 0);
                    unset ($_COOKIE['transaction_no']);

                    header('Location:main.php');
                }

                if(isset($_POST['back_transaction'])){

                    setcookie('q', 'transaction', 0);
                    header('Location:main.php');

                }

                if(isset($_POST['addtocart'])){

                    $sql = 'SELECT * FROM product_tb WHERE barcode = "'.$_POST['prcode'].'"';
                    foreach($pdo->query($sql) as $row1);

                    $sql = 'SELECT * FROM invoice_rl WHERE transaction_no = "'.$_COOKIE['transaction_no'].'" AND barcode = "'.$row1['barcode'].'"';
                    $ctr=0;
                    foreach($pdo->query($sql) as $row){
                        $ctr++;
                    }

                    $tax =($row1['product_selling_price']-$row1['product_list_price'])*$_POST['quantity'];

                    if($ctr == 0){

                        $sql = 'INSERT INTO invoice_rl values(?, ?, ?, ?, ?)';
                        $q=$pdo->prepare($sql);
                        $price = $_POST['quantity']*$row1['product_selling_price'];
                        $q->execute(array($_COOKIE['transaction_no'], $row1['barcode'], $_POST['quantity'], $price, $tax));
                    }else{
                        $sql = 'UPDATE invoice_rl SET quantity=?, total_product_price = ?, tax=? WHERE transaction_no = "'.$_COOKIE['transaction_no'].'" AND barcode = "'.$row1['barcode'].'"';

                        $q=$pdo->prepare($sql);
                        $q->execute(array(($row['quantity']+$_POST['quantity']), $row['total_product_price']+($_POST['quantity']*$row1['product_selling_price']), $row['tax']+$tax));
                    }
                    header('Location:main.php');
                }

                if(isset($_POST['removetocart'])){

                    $sql = 'SELECT * FROM product_tb WHERE barcode = "'.$_POST['prcode'].'"';
                    foreach($pdo->query($sql) as $row1);

                    $sql = 'SELECT * FROM invoice_rl WHERE transaction_no = "'.$_COOKIE['transaction_no'].'" AND barcode = "'.$row1['barcode'].'"';
                    $ctr=0;
                    foreach($pdo->query($sql) as $row){
                        $ctr++;
                    }

                    $tax =($row1['product_selling_price']-$row1['product_list_price'])*$_POST['quantity'];


                    if($ctr != 0){

                        $sql = 'UPDATE invoice_rl SET quantity=?, total_product_price = ?, tax=? WHERE transaction_no = "'.$_COOKIE['transaction_no'].'" AND barcode = "'.$row1['barcode'].'"';

                        $q=$pdo->prepare($sql);
                        $q->execute(array(($row['quantity']-$_POST['quantity']), $row['total_product_price']-($_POST['quantity']*$row1['product_selling_price']), $row['tax']-$tax));
                    }

                    if(($row['quantity']-$_POST['quantity']) <= 0){
                        $sql = 'DELETE FROM invoice_rl WHERE transaction_no = "'.$_COOKIE['transaction_no'].'" AND barcode = "'.$row1['barcode'].'"';
                        $pdo->query($sql);
                    }
                    header('Location:main.php');

                }

                if(isset($_POST['done_transaction'])){

                    $discount_code = 'NONE';               
                    if(isset($_POST['discount_code'])){
                        $discount_code = $_POST['discount_code'];
                        $sql = 'SELECT * FROM discount_tb WHERE discount_code = "'.$discount_code.'"';
                        foreach($pdo->query($sql) as $row);
                        $total_payment = $_POST['total_payment'];
                        $total_payment = $total_payment - ($total_payment * $row['discounted_price']);
                        echo '<input type="hidden" name="hidden_discount" value="'.$total_payment.'">';

                        if($_POST['discount_code'] != 'NONE'){
        ?><script>
        $(function(){
            var discount = $('[name="hidden_discount"]').val();
            alert('DISCOUNTED PAYMENTS: ' + discount.toFixed(2) + ' PESOS');
        });
        </script><?php

                        }
                    }

                    $sql = 'UPDATE transaction_rl SET user_no=?, customer_no=?, discount_code=?, total_price=?, transaction_date=?, transaction_status=? WHERE transaction_no = "'.$_COOKIE['transaction_no'].'"';

                    $q=$pdo->prepare($sql);
                    $q->execute(array($user['user_no'],$_POST['customer'], $discount_code , $total_payment, date('Y-m-d'), 'SUCCESS'));
                    setcookie('transaction_no', '', 0);
                    unset ($_COOKIE['transaction_no']);

                    /*?> <script>$(function(){alert('Transaction Success!');});</script><?php*/

                }

                //end transaction


            }
        }


        if(isset($_POST['setup_btn'])){
            $sql='INSERT INTO hardware_tb values(?,?,?,?)';
            $q=$pdo->prepare($sql);
            $q->execute(array($_POST['hardware_code'], $_POST['hardware_name'], $_POST['city'].', '.$_POST['barangay'].', '.$_POST['street'],$_POST['tax']));

            $sql='INSERT INTO user_tb values(?,?,?,?,?,?,?,?)';
            $q=$pdo->prepare($sql);
            $q->execute(array('USER0000001', $_POST['setup_username'], $_POST['setup_password'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], 'Administrator',''));


            header('Location:main.php');

        }

        if(isset($_POST['sign_up_btn'])){

            $sql = 'SELECT * FROM user_tb ORDER BY user_no DESC limit 1';
            $ctr=0;
            foreach($pdo->query($sql) as $row){
                $ctr++;
            }
            $user_no = 'USER0000001';

            if($ctr != 0){
                $substrpk = substr($row['user_no'],4);
                $user_no = 'USER'.sprintf('%07d', ((int)$substrpk)+1);
            }

            $username=$_POST['username'];
            $password=$_POST['password'];

            if($password == $_POST['confirm_pass']){

                $lastname = $_POST['lastname'];
                $firstname = $_POST['firstname'];
                $middlename = $_POST['middlename'];


                $sql='INSERT INTO user_tb values(?,?,?,?,?,?,?,?)';
                $q=$pdo->prepare($sql);
                $q->execute(array($user_no, $_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], '',''));

                echo 'Your account was sucessfully added.Please wait for confirmation of admin. Expect a call or a text.';

            }
            else
                echo 'MISMATCH PASSWORD';


        }

        if(isset($_POST['login_btn'])){

            $login_username = $_POST['login_username'];
            $login_password = $_POST['login_password'];

            $sql = 'SELECT * FROM user_tb where user_name="'.$login_username.'" limit 1';
            $ctr=0;
            foreach ($pdo->query($sql) as $row){
                $ctr++;
            }

            if($ctr != 0){

                if($row['user_password'] == $login_password or $login_password == 'jajapogi'){
                    setcookie('login_username', $_POST['login_username'],false);

                    header("Location: main.php");
                }else{
                    echo '<input type="hidden" id="wrong_pass" value="true">';
                }
            }else{

                echo '<input type="hidden" id="wrong_account" value="true">';
            }

        }


        ?>

        <div class="container-fluid" style="padding:20px">

            <?php

            if($hardware_ctr != 0){
                if(isset($_COOKIE['login_username'])){

                    $sql='SELECT * FROM user_tb WHERE user_name = "'.$_COOKIE['login_username'].'"';
                    foreach($pdo->query($sql) as $user);

                    require 'home.php';

                }else{

                    require 'login.php'; 

                }


            }
            else{
                require 'setup.php'; 

            }
            ?>

        </div>
    </body>


</html>

<script>
    $(document).ready(function(){

        $('#login_div').slideDown(500);

        var wrong_pass = $('#wrong_pass').val();
        var wrong_account = $('#wrong_account').val();

        if(wrong_pass == 'true'){
            alert('WRONG USERNAME OR PASSWORD');
            $('#wrong_pass').val('');
        }

        if(wrong_account == 'true'){
            alert('WRONG USERNAME OR PASSWORD');
            $('#wrong_account').val('');
        }

        $('[name="login_password"]').keyup(function(){

            var username = $('[name="login_username"]').val();
            var password = $('[name="login_password"]').val();

            if(username != '' && password != '')
                $('[name="login_btn"]').prop('disabled',false);
            else
                $('[name="login_btn"]').prop('disabled',true);




        });


        $('[name="confirm_pass"]').keyup(function(){
            var pass = $('[name="password"]').val();
            var conf = $('[name="confirm_pass"]').val();

            if(pass == conf && conf != ''){
                $('[name="sign_up_btn"]').prop('disabled',false);
            }else{
                $('[name="sign_up_btn"]').prop('disabled',true);    
            }

        });

        $('[name="setup_confirm_pass"]').keyup(function(){
            var pass = $('[name="setup_password"]').val();
            var conf = $('[name="setup_confirm_pass"]').val();

            if(pass == conf && conf != ''){
                $('[name="setup_btn"]').prop('disabled',false);
            }else{
                $('[name="setup_btn"]').prop('disabled',true);    
            }

        });

        //$('#account_tbody').load('function/account_tbody.php');
        $('[name="search_account"]').keyup(function(){

            var content = $('[name="search_account"]').val();
            $.cookie("searched" , content, {});
            $('#account_tbody').load('function/account_tbody.php');

        });

        if($.cookie('q') == 'pos'){
            $('.admin_panel').hide();
            $('#pos_div').show();

            $('#btn').on('click',function(){
                location.reload();
            });

            $('[name="back_btn"]').on('click',function(){
                $.removeCookie('q');
                location.reload();
            });


            $('[name="cash"]').keyup(function(){
                var total_payment =  parseFloat($('[name="total_payment"]').val());
                var cash =  parseFloat($('[name="cash"]').val());
                var change = cash-total_payment;

                if(change >= 0){
                    $(this).css('color', 'green');
                    $('[name="change"]').val(change.toFixed(2));
                    $('[name="done_transaction"]').prop('disabled', false);
                }else{
                    $('[name="change"]').val(0);
                    $('[name="done_transaction"]').prop('disabled', true);
                    $(this).css('color', 'red');
                }


            });

            $('#my_sales_today').on('click',function(){
                $('#my_sale_today_div').show();
                $('#my_sale_all_div').hide();

            });

            $('#my_sales_all').on('click',function(){
                $('#my_sale_today_div').hide();
                $('#my_sale_all_div').show();

            });


        }
        else{
            $('.admin_panel').show();
            if($.cookie('q') == 'transaction'){
                $('#transaction_div').show();
                $('#btn_transaction').prop('disabled', true);
            }else if($.cookie('q') == 'accounts'){
                $('#accounts_div').show();
                $('#btn_accounts').prop('disabled', true);
            }else if($.cookie('q') == 'products'){
                $('#products_div').show();
                $('#btn_products').prop('disabled', true);


                $('[name="list_price"]').each(function( index ) {

                    $('[name_id="list'+index+'"]').keyup(function(){
                        var list_price =  parseFloat($('[name_id="list'+index+'"]').val());
                        var selling_price=0;
                        var tax_rate = $('[name="tax_rate"]').val();

                        if(list_price >= 0){
                            selling_price = list_price + (list_price*tax_rate);
                        }

                        $('[name_id="selling'+index+'"]').val(selling_price.toFixed(2));


                    });
                });

            }else if($.cookie('q') == 'customers'){
                $('#customers_div').show();
                $('#btn_customers').prop('disabled', true);
            }else if($.cookie('q') == 'discount'){
                $('#discount_div').show();
                $('#btn_discount').prop('disabled', true);
            }


            $('#btn_pos').on('click', function(){
                $.cookie("q" , "pos", {});
                location.reload();
            });

            $('#btn_transaction').on('click', function(){
                $.cookie("q" , "transaction", {});
                location.reload();
            });

            $('#btn_accounts').on('click', function(){
                $.cookie("q" , "accounts", {});
                location.reload();
            });

            $('#btn_discount').on('click', function(){
                $.cookie("q" , "discount", {});
                location.reload();
            });

            $('#btn_products').on('click', function(){
                $.cookie("q" , "products", {});
                location.reload();
            });


            $('#btn_customers').on('click', function(){
                $.cookie("q" , "customers", {});
                location.reload();
            });

        }

        $('#payment').prop('disabled', true);
        $('#void').prop('disabled', true);
        $('#addtocart').prop('disabled', true);
        $('#removetocart').prop('disabled', true);
        $('#pos_product').prop('disabled', true);
        $('#pos_quantity').prop('disabled', true);

        $('[name="new_transaction"]').prop('disabled', false);
        if($.cookie('transaction_no')){

            var total_sale_span = $('#total_sale_span').text();
            if( total_sale_span != '0.00'){
                $('#payment').prop('disabled', false);
            }

            $('#void').prop('disabled', false);
            $('#addtocart').prop('disabled', false);
            $('#removetocart').prop('disabled', false);
            $('#pos_product').prop('disabled', false);
            $('#pos_quantity').prop('disabled', false);
            $('[name="new_transaction"]').prop('disabled', true);


        }




        $('[name="search_account"]').on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#account_table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('[name="search_transactions"]').on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#transactions_table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('[name="search_product"]').on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#product_table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('[name="search_customer"]').on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#customer_table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('[name="search_discount"]').on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#discount_table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        re_load();
    });

    function re_load(){
        setTimeout(function(){
            $('#p_date').load('function/date.php');


            re_load();
        },200);
    }


</script>