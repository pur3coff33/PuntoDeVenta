<div class="row">
    <div id="login_div" class="offset-lg-4 col-lg-4" style="text-align:center;color:white">
        <h1>SETUP</h1>
        <br>
        <form method="post">
            <label style="font-size:14px">Hardware Code:</label>
            <input type="text" class="form-control" name="hardware_code" required maxlength="3">
            <label style="font-size:14px">Hardware Name:</label>
            <input type="text" class="form-control" name="hardware_name" required >
            <br>
            <label style="font-size:14px">Hardware Address:</label>
            <div class="row">
                <div class="col-lg-6">
                    <select class="form-control" disabled>
                        <?php
                        $sql = 'SELECT * FROM tb_city ORDER BY city_name';
                        foreach($pdo->query($sql) as $row){
                            echo '<option>'.$row['city_name'].'</option>';
                        }

                        ?>

                    </select>
                    <input type="hidden" name="city" value="Naga City">
                </div>
                <div class="col-lg-6">
                    <select class="form-control" name="barangay">
                        <?php
                        $sql = 'SELECT * FROM tb_barangay ORDER BY barangay_name';
                        foreach($pdo->query($sql) as $row){
                            echo '<option>'.$row['barangay_name'].'</option>';
                        }

                        ?>

                    </select>
                </div>
            </div>
            <br>
            <input type="text" class="form-control" name="street" required placeholder="Street">
            <br>
            <label style="font-size:14px">TAX RATE (0-100 only):</label>
            <input type="number" min="0" max="100" step="1" class="form-control" name="tax" value="0" required >
            <br>
            <label style="font-size:14px">Owner Name:</label>
            <input type="text" class="form-control" name="lastname" required placeholder="Last Name" >
            <br>
            <input type="text" class="form-control" name="firstname" required placeholder="First Name">
            <br>
            <input type="text" class="form-control" name="middlename" required placeholder="Middle Name (Optional)">
            <br>
            <input type="text" class="form-control" name="setup_username" required placeholder="USERNAME">
            <br>
            <div class="row">
                <div class="col-lg-6">
                    <input type="password" class="form-control" name="setup_password" required placeholder="PASSWORD">

                </div>
                <div class="col-lg-6">
                    <input type="password" class="form-control" name="setup_confirm_pass" required placeholder="CONFIRM PASSWORD">

                </div>
            </div>
            <br>


            <div class="row">
                <div class="offset-lg-3 col-lg-6">
                    <button type="submit" name="setup_btn" class="btn btn-primary form-control" disabled>I'm Finish</button>
                </div>

            </div>
        </form>

    </div>


</div>