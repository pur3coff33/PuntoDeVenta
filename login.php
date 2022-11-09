<div class="row">
    <div id="login_div" class="offset-lg-4 col-lg-4" style="text-align:center;color:white">
        <h1><?php echo $hardware['hardware_name']; ?></h1>
        <form method="post">
            <label style="font-size:14px">USERNAME:</label>
            <input type="text" class="form-control" name="login_username" required>
            <label style="font-size:14px">PASSWORD:</label>
            <input type="password" class="form-control" name="login_password" required>
            <br>
            <div class="row">
                <div class="offset-lg-3 col-lg-6">
                    <button type="submit" name="login_btn" class="btn btn-success form-control" disabled>LOG IN</button>
                </div>

            </div>
        </form>

        <br>
        <p>--OR--</p>

        <form method="post">
            <div id="register_div">
                <label style="font-size:14px">LAST NAME:</label>
                <input type="text"  name="lastname" class="form-control" required>
                <label style="font-size:14px">FIRST NAME:</label>
                <input type="text"  name="firstname" class="form-control" required>
                <label style="font-size:14px">MIDDLE NAME:</label>
                <input type="text"  name="middlename" class="form-control" required>
                <label style="font-size:14px">USERNAME:</label>
                <input type="text"  name="username" class="form-control" required>
                <label style="font-size:14px">PASSWORD:</label>
                <input type="password"  name="password" class="form-control" required>
                <label style="font-size:14px">CONFIRM PASSWORD:</label>
                <input type="password"  name="confirm_pass" class="form-control" required>
                <br>

                <div class="row">
                    <div class="offset-lg-3 col-lg-6">
                        <button type="submit" name="sign_up_btn" class="btn btn-primary form-control" disabled>SIGN UP</button>
                    </div>

                </div>
            </div>

        </form>

    </div>


</div>