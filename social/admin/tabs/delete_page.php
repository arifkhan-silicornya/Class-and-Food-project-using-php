<?php
function delete_page() {
global $config;

if (empty($_GET['id'])) {
    return null;
}

$page = SK_getAccount($_GET['id']);

?>
<form class="content-container" method="post" action="?tab1=manage_pages">
    <div class="content-header">Delete Page <small>(<?php echo $page['name']; ?>)</small></div>
    <div class="content-wrapper">
        Are you sure?
    </div>
    <div class="button-wrapper">
        <input type="submit" name="cancel_btn" value="Cancel"> <input class="not-recommended" type="submit" name="delete_btn" value="Yes, Delete">
    </div>
    <input type="hidden" name="page_id" value="<?php echo $page['id']; ?>">
    <input type="hidden" name="delete_page" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>