<?php

function mo_openid_discord_add_on_display()
{?>
    <div id="dis_adv_disp" style="display: block">
        <table>
            <tr>
                <td>
                    <h3><?php echo mo_sl('Discord Add On');?>
                        <input type="button" value="<?php echo mo_sl('Purchase');?>"
                               onclick="mosocial_addonform('wp_social_login_discord_addon')"
                               id="mosocial_purchase_dis"
                               class="button button-primary button-large"
                               style="float: right; margin-left: 10px;">
                        <input type="button" value="<?php echo mo_sl('Verify Key');?>"
                               id="mosocial_purchase_dis_verify"
                               class="button button-primary button-large"
                               style="float: right;">
                    </h3>
                    <br>
                    <b><?php echo mo_sl('Discord Integration add-on allows you to restrict the login/registration of user based on whether the user is present in the Discord server');?></b>
                </td>
            </tr>
        </table>
        <table class="mo_openid_display_table table" id="mo_openid_dis_video"></table>

    </div>
    <br>
    <hr>
    <h2 style="font-style: italic;font-size: 1.8em; text-align: center;">Customization Available With Discord Integration</h2>

    <div class="mo_openid_note_style " style="border-left: 6px solid #2196F3;border-radius: 5px" >
        <ul style="list-style: initial;margin-left: 2%; font-weight: bold;" >
            <li>We provide <b>DISCORD ROLE MAPPING</b> based on WordPress role and membership/subscription of the end-user. </li>
            <li>Automate the process of adding users to the discord server when users register to the website.</li>
            <li>Kick the user from the discord server when the user is deleted from the WordPress website.</li>
            <li>Kick the user when the subscription/membership ended.</li>
            <li>Other Use Case as per customers requirement. For more details <a style="cursor: pointer" onclick="mo_openid_support_form()">Contact Us</a></li>
        </ul>
    </div>
   <br>
    <div class="mo_openid_highlight">
        <h3 style="margin-left: 2%;line-height: 210%;color: white;"><?php echo mo_sl('Discord Integration');?></h3>
    </div>

    <div class="mo_openid_table_layout">
        <div>
            <h3 style="margin-left: 1.5%">Instruction to get the Discord Bot Token Key and Guild ID.</h3>
            <ol style="margin-left: 4%">
                <li>Log in to Discord Console & create New Custom Application </li>
                <li>After creating an OAuth Application,go to the Bot section.Click on the Add Bot button.</li>
                <li>Now we need to add Bot to our server with the permission to access roles. You need to check Bot and select the permission and it will generate the URL. You need to copy that URL and paste it into the new tab. After that, you need to select the server where you need to add the Bot.</li>
                <li>After successfully authorization, Go to the Bot section and copy the token and paste it in the Bot Token Key textfield</li>
                <li>To get the Guild ID,In Discord, open your User Settings by clicking the Settings Cog next to your user name on the bottom.</li>
                <li>Go to Appearance and enable Developer Mode under the Advanced section, then close User Settings.</li>
                <li>Open your Discord server, right-click on the server name, then select Copy ID.Paste it in the Guild ID field. </li>
            </ol>
        </div>

        <form>
    
            <input name="option" type="hidden" value="discord_role_creation_settings">
            <table class="form-table" role="presentation">
                <tbody>
                <tr class="form-field form-required">
                    <th scope="row"><label for="">Guild ID\'s <span class="description">(required)</span></label></th>
                    <td><input disabled type="text" placeholder="717473765117323473"><br><br>
                    </td>
                </tr>           
                <tr class="form-field form-required">
                    <th scope="row"><label for="">Bot Token Key <span class="description">(required)</span></label></th>
                    <td><input disabled type="text" placeholder="717473765117323473"/>
                    </td>
                </tr>
            </tbody></table>
            
            <p class="submit"><input type="submit" name="discord_role_creation_submit" id="discord_role_creation_submit" class="button button-primary" disabled value="Save"></p>
        </form>
    </div>
    <td>
        <form style="display:none;" id="mosocial_loginform" action="<?php echo get_option( 'mo_openid_host_name' ) . '/moas/login'; ?>"
              target="_blank" method="post" >
            <input type="email" name="username" value="<?php echo esc_attr(get_option('mo_openid_admin_email')); ?>" />
            <input type="text" name="redirectUrl" value="<?php echo esc_attr(get_option( 'mo_openid_host_name')).'/moas/initializepayment'; ?>" />
            <input type="text" name="requestOrigin" id="requestOrigin"/>
        </form>
        <script>
            function mosocial_addonform(planType) {
                jQuery('#requestOrigin').val(planType);
                jQuery('#mosocial_loginform').submit();
            }
        </script>
    </td>
    <td>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script type="text/javascript">
            //to set heading name
           jQuery(document).ready(function($){
                jQuery("#mosocial_purchase_dis_verify").on("click",function(){
                    mo_verify_add_on_license_key();
                });
            });

            function mo_verify_add_on_license_key() {
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url("admin-ajax.php"); ?>',
                    data: {
                        action:'verify_addon_licience',
                        plan_name: 'WP_SOCIAL_LOGIN_DISCORD_ADDON',
                    },
                    crossDomain :!0, dataType:"html",
                    success: function(data) {
                        var flag=0;
                        jQuery("input").each(function(){
                            if(jQuery(this).val()=="mo_openid_verify_license") flag=1;
                        });
                        if(!flag) {
                            jQuery(data).insertBefore("#mo_openid_dis_video");
                            jQuery("#dis_adv_disp").find(jQuery("#cust_supp")).css("display", "none");
                        }
                    },
                    error: function (data){}
                });
            }
        </script>
    </td>
    <?php
}