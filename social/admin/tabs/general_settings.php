<?php
function general_settings() {
global $config, $dbConnect;
?>
<form class="content-container" method="post" action="?tab1=general_settings">
    <div class="content-header">General Settings</div>

    

    
        
        <div style="visibility: hidden;">
            <input type="text" name="site_name" value="dfgdfg">
            <input type="text" name="site_title" value="dfgdg">
            <select name="language">
                <option ></option>
            </select>
            <select name="captcha">
                <option ></option>
             </select>

            <select name="smooth_links">
                <option></option>
            </select>
            <input type="text" name="censored_words" value="">


            <select name="friends">
                <option value="0"</option>
            </select>
       
        </div>
        
    

    <div class="content-wrapper">
        <div class="label float-left">E-mail</div>
        <div class="input float-left">
            <input type="text" name="site_email" value="<?php echo $config['email']; ?>">
            <div class="info">Site's email.</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Email verification</div>
        <div class="input float-left">
            <select name="email_verification">
                <option value="1" <?php if ($config['email_verification'] == 1) echo 'selected'; ?>>On</option>
                <option value="0" <?php if ($config['email_verification'] == 0) echo 'selected'; ?>>Off</option>
            </select>
            <div class="info">Enable email verification
            </div>
        </div>
        <div class="float-clear"></div>
    </div>




            <select name="chat" style="visibility: hidden;">
                <option value="1" <?php if ($config['chat'] == 1) echo 'selected'; ?>>On</option>
                <option value="0" <?php if ($config['chat'] == 0) echo 'selected'; ?>>Off</option>
            </select>





    






    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>

    <input type="hidden" name="keep_blank" value="">
    <input type="hidden" name="update_site_settings" value="1">
</form>
<?php } ?>