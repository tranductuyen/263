<?php
function add_admin_menu()
{
    add_menu_page(
        'Short Link Admin',
        'Short Link',
        'manage_options',
        'short-link-admin',
        'show_table_short_link',
        '',
        '50'
    );
}

function show_table_short_link()
{
    $items_per_page = 20;
    $page = isset($_GET['cpage']) ? abs((int)$_GET['cpage']) : 1;
    $offset = ($page * $items_per_page) - $items_per_page;
    global $wpdb;
    $limit = $items_per_page;
    $table = $wpdb->prefix . 'urls';
    $sql = "SELECT * FROM {$table} LIMIT %d OFFSET %d";
    $rs = $wpdb->get_results($wpdb->prepare($sql, $limit, $offset), ARRAY_A);
    $query = 'SELECT * FROM ' . $table;
    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var($total_query);
    ?>
    <div class="wrap">
        <h2>Danh sách Links</h2>
        <table class="wp-list-table widefat plugins">
            <thread>
                <tr>
                    <th scope="col" class="manage-column column-name column-primary" style="width: 18%"><b>Short Url</b></th>
                    <th scope="col" class="manage-column column-description" style="width: 71%"><b>Long Url</b></th>
                    <th scope="col" class="manage-column column-description" style="width: 11%"><b>Số lượt truy cập</b></th>
                </tr>
            </thread>
            <tbody>
            <?php foreach ($rs as $url) {
                $long_url = $url['url'];
                $short_url = get_home_url() . '/s/?url=' . $url['shorturl'];
                $counter = $url['counter'];
                echo "
                <tr class=\"active is-uninstallable\">
                  <td class=\"column-primary\"><b>$short_url</b></td>
                    <td class=\"column-description\">$long_url</td>
                  
                    <td class=\"column-description\">$counter lượt truy cập</td>
                </tr>
            ";
            } ?>
            </tbody>
        </table>
    </div>
    <?php
    $args = array(
        'base' => add_query_arg('cpage', '%#%'),
        'format' => '',
        'prev_text' => __('&laquo;Preview'),
        'next_text' => __('Next &raquo;'),
        'total' => ceil($total / $items_per_page),
        'current' => $page
    );
    echo paginate_links($args);
}

add_action('admin_menu', 'add_admin_menu');