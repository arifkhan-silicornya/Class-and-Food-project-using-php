<?php
function manage_admin_login() {
global $config;
?>
<form class="content-container" method="post" action="?tab1=manage_admin_login">
    <div class="content-header">Manage Admin Login</div>
  
    <div class="content-wrapper">
        <div class="label float-left">Username</div>
        <div class="input float-left">
            <input type="text" name="admin_username" value="<?php echo $config['admin_username']; ?>">
            <div class="info">Admin's username.</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">Password</div>
        <div class="input float-left">
            <input type="text" name="admin_password">
            <div class="info">Admin's password</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>
    <input type="hidden" name="keep_blank" value="">
    <input type="hidden" name="update_admin_login" value="1">
</form>
<?php } ?>