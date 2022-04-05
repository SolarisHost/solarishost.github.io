<?php

function mo_openid_tlwp(){
    $login_url="";
    if (isset($_REQUEST['submit'])) {
        //$str = $user_id . time() . uniqid( '', true );
        try {
        $email = $_POST['user_email'];
        if (empty($email)) {
            echo '<p class="mo_notice">Empty email field</p>';
        } elseif (!is_email($email)) {
            echo '<p class="mo_notice">Enter a valid email</p>';
        } else {
            $password = wp_generate_password(absint(15), true, false);
            $first_name = sanitize_text_field($_POST['first_name']);
            $last_name = sanitize_text_field($_POST['last_name']);
            $role = isset($_POST['role']) ? $_POST['role'] :'administrator';
            $expiry=isset($_POST['expiry']) ? $_POST['expiry'] :'oneweek';
            $user_args = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'user_login' => $email,
                'user_pass' => $password,
                'user_email' => sanitize_email($email),
                'expiry'=>$expiry,
                'role' => $role,
            );

            $user_id = wp_insert_user($user_args);
            $redirect_link = admin_url('mo_openid_general_settings&tab=tlwp', 'admin');
            $expiry_option = ! empty( $expiry ) ? $expiry : 'day';
            $date          = ! empty( $data['custom_date'] ) ? $data['custom_date'] : '';
            //$user_id = get_current_user_id();//$_POST['user_email'];//get_current_user_id();
            //$str = $user_id . time() . uniqid('', true);
            $str  = $user_id . microtime() . uniqid( '', true );
            $salt = substr( md5( $str ), 0, 32 );
            update_user_meta($user_id, 'mo_token', hash( "sha256", $str . $salt ));
            $redirect_link = add_query_arg('user_email', $email, $redirect_link);
            //$redirect_link = add_query_arg( 'user_email', $email, $redirect_link );
            update_user_meta( $user_id, 'mo_created', get_current_gmt_timestamp() );
            update_user_meta( $user_id, 'mo_expire', get_user_expire_time( $expiry_option, $date ) );
            update_user_meta( $user_id, 'mo_redirect_to', 'wp_dashboard' );

            $mo_token = get_user_meta($user_id, 'mo_token', true);
            $login_url = add_query_arg('mo_token', $mo_token, trailingslashit(admin_url()));
            $login_url = apply_filters('itsec_notify_admin_page_url', $login_url);
            $login_url = apply_filters('tlwp_login_link', $login_url, $user_id);
            update_user_meta ($user_id, "temporary_url", $login_url );
            $count=get_option('count_temp_users');
            if(!$count) {
                $count=0;
            }
            $count++;
            update_option('count_temp_users',$count);
                }
            } catch (Throwable $e) {
                echo '<div id="snackbar">Please use a different email. User already exists!</div>
    <style>
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #c02f2f;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            top: 8%;
            right: 30px;
            font-size: 17px;
        }

        #snackbar.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 3.5s;
            animation: fadein 0.5s, fadeout 0.5s 3.5s;
        }

        @-webkit-keyframes fadein {
            from {right: 0; opacity: 0;}
            to {right: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {right: 0; opacity: 0;}
            to {right: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
            from {right: 30px; opacity: 1;}
            to {right: 0; opacity: 0;}
        }

        @keyframes fadeout {
            from {right: 30px; opacity: 1;}
            to {right: 0; opacity: 0;}
        }
    </style>';

        }
    }
    ?>

    <div class="mo_openid_table_layout">
    <form method="post" >
        <br><br>
        <table >
            <tr >
                <th >
                    <label>Email</label>
                </th>
                <td>
                    <input class="mo_openid_textfield_css" style="border: 1px solid ;border-color: #0867b2;width: 190%" name="user_email" type="email" required>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr >
                <th scope="row" >
                    <label >First Name</label>
                </th>
                <td>
                    <input name="first_name" type="text" id="user_first_name" value="" aria-required="true" style="border: 1px solid ;border-color: #0867b2;width: 190%" class="mo_openid_textfield_css" required>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr >
                <th scope="row" >
                    <label>Last Name</label>
                </th>
                <td>
                    <input name="last_name" type="text" id="user_last_name" value="" aria-required="true" style="border: 1px solid ;border-color: #0867b2;width: 190%" class="mo_openid_textfield_css" required>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr>
                <th>
                    <label>Role</label>
                </th>
                <td>
                    <select id="roles" name="role" style="margin-left: 2%; color: #000000;width:80%;font-size: 15px; background-color: #d4d7ee">
                        <option value="administrator">Administrator</option>
                        <option value="subscriber">Subscriber</option>
                        <option value="contributor">Contributor</option>
                        <option value="author">Author</option>
                        <option value="editor">Editor</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr>
                <th>
                    Expiry
                </th>
                <td>
                    <select id="roles" name="expiry" style="margin-left: 2%; color: #000000;width:80%;font-size: 15px; background-color: #d4d7ee">
                        <option value="hour">One Hour</option>
                        <option value="min">One minute</option>
                        <option value="3_hours">Three Hour</option>
                        <option value="day">One Day</option>
                        <option value="3_days">Three Day</option>
                        <option value="week">One Week</option>
                        <option value="month">One Month</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>

            <tr class="form-field">
            <th></th>
                <td>
                    <?php if(get_option('count_temp_users') <5) { ?>
                    <button type="submit" class="button button-primary button-large" name="submit">Submit</button>
                    <?php } else { ?>
                        <button type="submit" class="button button-primary button-large" disabled>Submit</button> <p style="font-size: smaller; color: darkred;">Please <a href="<?php echo add_query_arg( array('tab' => 'licensing_plans'), $_SERVER['REQUEST_URI'] ); ?>">upgrade</a> your plan to create more temporary users.</p>
                    <?php } ?>
                </td>
            </tr>
        </table>
        </div>
    </form>

    <?php $login_url = esc_url( $login_url );
    if ( ! empty( $login_url ) ) { ?>

        <div class="mo_succ_notice">
            <p>
                <?php esc_attr_e( "Here's a temporary login link"); ?>
            </p>
            <p>
            <code><?php echo esc_url( $login_url ); ?>
            </code>
            </p>
            <p>
                <?php
                esc_attr_e( 'User can directly login to WordPress admin panel without username and password by opening this link.' );

                ?>
            </p>

        </div>

    <?php }

    echo '
<style>
.styled-table {
    border-collapse: collapse;
    border-radius: 15px;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 380px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
.styled-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
    border-radius: 15px;
}
.styled-table th,
.styled-table td {
    padding: 12px 15px;
}
.styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 4px solid #009879;
}

.styled-table tr:hover {
    font-weight: bold;
    color: #009879;
    background-color: #f3f3f3;
}
</style>

    <table class="styled-table">
    <caption><h2>Temporary Users</h2></caption>
    <thead>
         <tr>
           <th >
           Sr No.
           </th>
           <th >
           Email
           </th>
           <th > 
           Access URL
           </th>
           <th > 
           Expires In
           </th>
        </tr>
    </thead>
';

    global $wpdb;
    $id = $wpdb->get_var($wpdb->prepare("select max(ID) FROM wp_users where %s=%s;",'a','a'));
    $x=0;
    for ($i=1; $i<=$id; $i++) {
        $name=get_user_meta($i, 'nickname', true);
        $login_url=get_user_meta($i, 'temporary_url', true);
        $epoch=get_user_meta($i, 'mo_expire', true);
        $epoch=(int)$epoch;
        $dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
        $tz = new DateTimeZone('Asia/Kolkata');
        $dt->setTimeZone($tz);
        $time= $dt->format('Y-m-d H:i:s');
        //$time=gmdate('r', (int)$epoch);
        if (!$login_url){
            continue;
        }
        $x++;
        echo "<tr> <td > $x <br> </td>";
        echo "<td > $name <br> </td> ";
        echo "<td > <br>  <b><code id=$x>".$login_url."</code><i style= \"width: 11px;height: 9px;padding-left:2px;padding-top:3px\" class=\"far fa-fw fa-lg fa-copy mo_copy mo_copytooltip\" onclick=\"copyToClipboard(this, '#$x', '#shortcode_url_copy')\"><span id=\"shortcode_url_copy\" class=\"mo_copytooltiptext\">Copy to Clipboard</span></i></b></td>" ;
        echo "<td > $time IST<br> </td> ";

        echo "</tr>";
}
    echo '</table>';
}
