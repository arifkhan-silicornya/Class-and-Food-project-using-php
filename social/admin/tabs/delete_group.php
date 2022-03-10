<?php
function delete_group() {
global $config;

if (empty($_GET['id'])) {
    return null;
}

$group = SK_getAccount($_GET['id']);

?>
<form class="content-container" method="post" action="?tab1=manage_groups">
    <div class="content-header">Delete Group <small>(<?php echo $group['name']; ?>)</small></div>
    <div class="content-wrapper">
        Are you sure?
    </div>
    <div class="button-wrapper">
        <input type="submit" name="cancel_btn" value="Cancel"> <input class="not-recommended" type="submit" name="delete_btn" value="Yes, Delete">
    </div>
    <input type="hidden" name="group_id" value="<?php echo $group['id']; ?>">
    <input type="hidden" name="delete_group" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>