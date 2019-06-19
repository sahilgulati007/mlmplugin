<?php
function mlm_list(){
    //echo "in";
    global $wpdb;
    $users = get_users();
    $table_name=$wpdb->prefix.'mlm';
    $mylink = $wpdb->get_row( "SELECT * FROM $table_name WHERE uid =".get_current_user_id() );
    if(!$mylink) {
        $packages = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . 'mlm_package_detail');
        ?>
        <form method="post">
            <input type="hidden" name="uid" value="<?php echo get_current_user_id(); ?>">
            <select name="mgid">
                <option value="0">Select your leader</option>
                <?php
                foreach ($users as $user) {
                    if ($user->ID != get_current_user_id())
                        echo "<option value='" . $user->ID . "'>" . $user->display_name . "</option>";
                }
                ?>
            </select>
            <br>
            <input type="text" name="fnm" placeholder="Enter Full Name">
            <br>
            <select name="mplan">
                <?php
                foreach ($packages as $package) {
                    ?>
                    <option value="<?php echo $package->pid?>"><?php echo $package->pnm.' $'.$package->pprice?></option>
                    <?php
                }
                ?>
            </select>
            <br>
            <input type="text" name="country" placeholder="Enter Country">
            <br>
            <input type="text" name="state" placeholder="Enter State">
            <br>
            <input type="text" name="city" placeholder="Enter City">
            <br>
            <input type="text" name="zip" placeholder="Enter Zip">
            <br>
            <input type="submit" name="sub" value="Submit">

        </form>
        <?php
        if (isset($_POST['sub'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'mlm';

            $user_id = $wpdb->insert(
                $table_name,
                array(
                    'uid' => $_POST['uid'],
                    'mgid' => $_POST['mgid'],
                    'mnm' => $_POST['fnm'],
                    'mplan' => $_POST['mplan'],
                    'country' => $_POST['country'],
                    'state' => $_POST['state'],
                    'city' => $_POST['city'],
                    'zip' => $_POST['zip']
                ));
            echo $user_id;
            //wp_redirect($_SERVER['HTTP_REFERER']);
        }
    }
    else{
        //echo "found";
        ?>
            <table>
                <tr>
                    <td colspan="2"><h1>Personal Details</h1></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td><?php echo $mylink->uid?></td>
                </tr>
                <tr>
                    <td>Manager Name</td>
                    <?php
                    if($mylink->mgid==0){
                        echo "<td>NAN</td>";
                    }
                    else {
                        ?>
                        <td><?php echo get_user_by('ID', $mylink->mgid)->data->display_name ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $mylink->mnm?></td>
                </tr>
                <tr>
                    <td>Package</td>
                    <?php $package = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "mlm_package_detail where pid=$mylink->mplan");  ?>
                    <td><?php echo $package->pnm.' $'.$package->pprice?></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td><?php echo $mylink->country?></td>
                </tr>
                <tr>
                    <td>State</td>
                    <td><?php echo $mylink->state?></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><?php echo $mylink->city?></td>
                </tr>
                <tr>
                    <td>ZipCode</td>
                    <td><?php echo $mylink->zip?></td>
                </tr>
            </table>
        <?php
        echo "----------------------<br>";
        echo "<h1>Company Revenew </h1>";
        echo "----------------------<br>";
        $packages = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . 'mlm_package_detail');
        $totalrevenew=0;
        foreach ($packages as $package) {
            $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "mlm where mplan=".$package->pid);
            $rowcount = $wpdb->num_rows;
            echo "Number of ".$package->pnm." packages sold are: <b>".$rowcount."</b><br>";
            echo "Revenew: <b>$".$rowcount*$package->pprice."</b><br>";
            $totalrevenew=$rowcount*$package->pprice;
        }
        echo "Revenew from all Packages: <b>$".$totalrevenew."<br>";
        echo "----------------------<br>";
        echo "<h1>Tree</h1>";
        echo "---------------------- <br>";
        echo $mylink->mnm."<br>";
        $member=$wpdb->get_results("select * from ".$wpdb->prefix . "mlm where mgid=".get_current_user_id());
        foreach ($member as $m){
            echo "-".$m->mnm."<br>";
            rec_mem($m->uid,1);
        }
    }
}
function rec_mem($id,$l){
    global $wpdb;
    $member=$wpdb->get_results("select * from ".$wpdb->prefix . "mlm where mgid=".$id);
    if($member){
        foreach ($member as $m){
            for($i=0;$i<$l;$i++){
                echo "-";
            }
            echo "-".$m->mnm."<br>";
            rec_mem($m->uid,$l+1);
        }
    }
    else{
        return;
    }

}