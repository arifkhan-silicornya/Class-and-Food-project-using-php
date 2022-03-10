<?php
function edit_group() {
global $config;

if (empty($_GET['id'])) {
    return null;
}

$group = SK_getAccount($_GET['id']);

?>
<form class="content-container" method="post" action="?tab1=edit_group&id=<?php echo $_GET['id'] ?>">
    <div class="content-header">Edit Group <small>(<?php echo $group['name']; ?>)</small></div>
    <div class="content-wrapper">
        <div class="label float-left">Name</div>
        <div class="input float-left">
            <input type="text" name="name" value="<?php echo $group['name']; ?>">
            <div class="info">Group's name</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">Username</div>
        <div class="input float-left">
            <input type="text" name="username" value="<?php echo $group['username']; ?>">
            <div class="info">Group's unique username</div>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="content-wrapper">
        <div class="label float-left">E-mail</div>
        <div class="input float-left">
            <input type="text" name="email" value="<?php echo $group['email']; ?>">
            <div class="info">Group's email</div>
        </div>
        <div class="float-clear"></div>
    </div>

 


    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>
    <input type="hidden" name="group_id" value="<?php echo $group['id']; ?>">
    <input type="hidden" name="update_group_information" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>