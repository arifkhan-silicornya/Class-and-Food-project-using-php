<?php
function edit_page() {
global $config, $dbConnect, $lang;

if (empty($_GET['id'])) {
    return null;
}

$page = SK_getAccount($_GET['id']);

?>
<form class="content-container" method="post" action="?tab1=edit_page&id=<?php echo $_GET['id'] ?>">
    <div class="content-header">Edit Page <small>(<?php echo $page['name']; ?>)</small></div>
    <div class="content-wrapper">
        <div class="label float-left">Verified</div>
        <div class="input float-left">
            <select name="verified">
                <option value="0"<?php if ($page['verified'] == 0) echo ' selected'; ?>>No</option>
                <option value="1"<?php if ($page['verified'] == 1) echo ' selected'; ?>>Yes</option>
            </select>
            <div class="info">Verified page or not</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">Name</div>
        <div class="input float-left">
            <input type="text" name="name" value="<?php echo $page['name']; ?>">
            <div class="info">Page's name</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">Username</div>
        <div class="input float-left">
            <input type="text" name="username" value="<?php echo $page['username']; ?>">
            <div class="info">Page's unique username</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">E-mail</div>
        <div class="input float-left">
            <input type="text" name="email" value="<?php echo $page['email']; ?>">
            <div class="info">Page's email</div>
        </div>
        <div class="float-clear"></div>
    </div>


    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>
    <input type="hidden" name="page_id" value="<?php echo $page['id']; ?>">
    <input type="hidden" name="update_page_information" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>