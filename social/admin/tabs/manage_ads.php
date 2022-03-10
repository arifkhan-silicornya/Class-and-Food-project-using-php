<?php
function manage_ads() {
global $config;
?>
<form class="content-container" method="post" action="?tab1=manage_ads">
    <div class="content-header">Notices</small></div>
    <div class="content-wrapper">
        <label>text, html, pictures are allowed</label>
    </div>
    <div class="content-wrapper">
       
        <div class="input float-left">
            <textarea name="ad_place_home"><?php echo $config['ad_place_home']; ?></textarea>
            
        </div>
        <div class="float-clear"></div>
    </div>







    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>
    <input type="hidden" name="update_ad_codes" value="1">
    <input type="hidden" name="keep_blank" value="">
</form>
<?php } ?>