<?php
function edit_user() {
global $config;

if (empty($_GET['id'])) {
    return null;
}

$user = SK_getAccount($_GET['id']);

?>
<form class="content-container" method="post" action="?tab1=edit_user&id=<?php echo $_GET['id'] ?>">
    <div class="content-header">Edit User <small>(<?php echo $user['name']; ?>)</small></div>
    <div class="content-wrapper">
        <div class="label float-left">Verified</div>
        <div class="input float-left">
            <select name="verified">
                <option value="0"<?php if ($user['verified'] == 0) echo ' selected'; ?>>No</option>
                <option value="1"<?php if ($user['verified'] == 1) echo ' selected'; ?>>Yes</option>
            </select>
            <div class="info">Verified user or not</div>
        </div>
        <div class="float-clear"></div>
    </div>










    <div class="content-wrapper">
        <div class="label float-left">Username</div>
        <div class="input float-left">
            <input type="text" name="username" value="<?php echo $user['username']; ?>">
            <div class="info">User's unique username</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">E-mail</div>
        <div class="input float-left">
            <input type="text" name="email" value="<?php echo $user['email']; ?>">
            <div class="info">User's email</div>
        </div>
        <div class="float-clear"></div>
    </div>




    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>
    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
    <input type="hidden" name="update_user_information" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>

<form class="content-container" method="post" action="?tab1=edit_user&id=<?php echo $_GET['id'] ?>">
    <div class="content-header">Update Password <small>(<?php echo $user['name']; ?>)</small></div>
    <div class="content-wrapper">
        <div class="label float-left">New password</div>
        <div class="input float-left">
            <input type="text" name="password">
            <div class="info">New password for user</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>
    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
    <input type="hidden" name="update_user_password" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>