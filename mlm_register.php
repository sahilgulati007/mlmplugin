<?php
function mlm_register(){
    if(isset($_POST['register'])){
        $userdata = array(
            'user_login'  =>  $_POST['nm'],
            'user_email'    =>  $_POST['em'],
            'user_pass'   =>  $_POST['pas']  // When creating a new user, `user_pass` is expected.
        );

        $user_id = wp_insert_user( $userdata ) ;
        echo $user_id;
    }
    ob_start();
    ?>
        <h3>Register</h3>
        <form name="" method="post" action="">
            <input type="text" required name="nm" placeholder="Enter Name">
            <input type="email" required name="em" placeholder="Enter Email">
            <input type="password" required name="pas" placeholder="Enter Password">
            <input type="submit" name="register" value="Register">
        </form>
    <?php
    return ob_get_clean();
}
add_shortcode('mlm_reg_shortcode','mlm_register');

