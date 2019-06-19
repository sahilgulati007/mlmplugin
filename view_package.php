<?php
function view_package()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'mlm_package_detail';
    if(isset($_POST['delsub'])){
        $wpdb->delete( $table_name, array( 'pid' => $_POST['pid'] ) );
    }
    $packages = $wpdb->get_results("SELECT * FROM " . $table_name);
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "<th>Price</th>";
    echo "<th>Description</th>";
    echo "</tr>";
    foreach ($packages as $package) {
        ?>
        <tr>
            <td><?php echo $package->pid ?></td>
            <td><?php echo $package->pnm ?></td>
            <td><?php echo $package->pprice ?></td>
            <td><?php echo $package->pdesc ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="pid" value="<?php echo $package->pid ?>">
                    <input type="submit" name="delsub" value="Delete">
                </form>
            </td>
        </tr>
        <?php
    }
    echo "</table>";
}