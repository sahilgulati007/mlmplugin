<?php
function add_package(){
    ?>
    <form method="post">

        <input type="text" name="pnm" placeholder="Enter Package Name">
        <br>
        <input type="text" name="pprice" placeholder="Enter Package Price">
        <br>
        <textarea name="pdesc" placeholder="Enter Package Description"></textarea>
        <br>
        <input type="submit" name="sub" value="Submit">

    </form>
    <?php
    if(isset($_POST['sub'])){
        global $wpdb;
        $table_name=$wpdb->prefix.'mlm_package_detail';

        $user_id = $wpdb->insert(
            $table_name,
            array(
                'pnm' => $_POST['pnm'],
                'pprice' => $_POST['pprice'],
                'pdesc' => $_POST['pdesc']
            ));
        echo $user_id;
        //echo admin_url( 'admin.php?page=View_Package');
        //wp_redirect(admin_url( 'admin.php?page=View_Package'));
    }
}