<?php
function delete_user() {
global $config;

if (empty($_GET['id'])) {
    return null;
}

$user = SK_getAccount($_GET['id']);

?>
<form class="content-container" method="post" action="?tab1=manage_users">
    <div class="content-header">Delete User <small>(<?php echo $user['name']; ?>)</small></div>
    <div class="content-wrapper">
        Are you sure?
    </div>
    <div class="button-wrapper">
        <input type="submit" name="cancel_btn" value="Cancel"> <input class="not-recommended" type="submit" name="delete_btn" value="Yes, Delete">
    </div>
    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
    <input type="hidden" name="delete_user" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>