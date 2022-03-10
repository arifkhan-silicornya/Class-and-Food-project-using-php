<?php
function admin_login() { ?>
<div align="center" class="welcome-form-div">
    <div class="welcome-form">
        

        

        <form class="login-form" method="post" action="?">
            <div class="form-content">
                <div class="input-wrapper">
                    <input type="text" name="admin_username" placeholder="Admin username">
                </div>
                
                <div class="input-wrapper">
                    <input type="password" name="admin_password" placeholder="Admin password">
                </div>
                
                <button class="submit-btn active"><i class="icon-signin progress-icon"></i> Log In</button>

                <input type="hidden" name="admin_login" value="1">
                <input type="hidden" name="keep_blank" value="">
            </div>
        </form>
    </div>
</div>
<?php }
?>