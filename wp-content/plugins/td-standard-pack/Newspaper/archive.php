<?php
/*  ----------------------------------------------------------------------------
    the archive(s) template
 */

get_header();


//set the template id, used to get the template specific settings
$template_id = 'archive';

//prepare the loop variables
global $loop_module_id, $loop_sidebar_position, $part_cur_auth_obj;
$loop_module_id = td_util::get_option('tds_' . $template_id . '_page_layout', 1); //module 1 is default
$loop_sidebar_position = td_util::get_option('tds_' . $template_id . '_sidebar_pos'); //sidebar right is default (empty)

// sidebar position used to align the breadcrumb on sidebar left + sidebar first on mobile issue
$td_sidebar_position = '';
if($loop_sidebar_position == 'sidebar_left') {
	$td_sidebar_position = 'td-sidebar-left';
}

//read the current author object - used by here in title and by /parts/author-header.php
$part_cur_auth_obj = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));


//prepare the archives page title
if (is_day()) {
    $td_archive_title = __td('Daily Archives:', TD_THEME_NAME). ' ' . get_the_date();
} elseif (is_month()) {
    $td_archive_title = __td('Monthly Archives:', TD_THEME_NAME) . ' ' . get_the_date('F Y');
} elseif (is_year()) {
    $td_archive_title = __td('Yearly Archives:', TD_THEME_NAME) . ' ' . get_the_date('Y');
} else {
    $td_archive_title = __td('Archives', TD_THEME_NAME);
}
?>
<div class="td-main-content-wrap td-container-wrap">
    <div class="td-container <?php echo esc_attr($td_sidebar_position) ?>">
        <div class="td-crumb-container">
            <?php echo td_page_generator::get_archive_breadcrumbs(); // get the breadcrumbs - /includes/wp_booster/td_page_generator.php ?>
        </div>
        <div class="td-pb-row">
            <?php
            switch ($loop_sidebar_position) {
                default:
                    ?>
                        <div class="td-pb-span8 td-main-content">
                            <div class="td-ss-main-content">
                                <div class="td-page-header">
                                    <h1 class="entry-title td-page-title">
                                        <span><?php printf( '%1$s', $td_archive_title ) ?></span>
                                    </h1>
                                </div>

                                <?php load_template( TDSP_THEME_PATH . '/loop.php', true); ?>

                                <?php echo td_page_generator::get_pagination(); // get the pagination - /includes/wp_booster/td_page_generator.php ?>
                            </div>
                        </div>

                        <div class="td-pb-span4 td-main-sidebar">
                            <div class="td-ss-main-sidebar">
                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                    <?php
                    break;

                case 'sidebar_left':
                    ?>
                    <div class="td-pb-span8 td-main-content <?php echo esc_attr($td_sidebar_position) ?>-content">
                        <div class="td-ss-main-content">
                            <div class="td-page-header">
                                <h1 class="entry-title td-page-title">
                                    <span><?php printf( '%1$s', $td_archive_title ) ?></span>
                                </h1>
                            </div>

                            <?php load_template( TDSP_THEME_PATH . '/loop.php', true); ?>

                            <?php echo td_page_generator::get_pagination(); // get the pagination - /includes/wp_booster/td_page_generator.php ?>
                        </div>
                    </div>
	                <div class="td-pb-span4 td-main-sidebar">
		                <div class="td-ss-main-sidebar">
			                <?php get_sidebar(); ?>
		                </div>
	                </div>
                    <?php
                    break;

                case 'no_sidebar':
                    ?>
                    <div class="td-pb-span12 td-main-content">
                        <div class="td-ss-main-content">
                            <div class="td-page-header">
                                <h1 class="entry-title td-page-title">
                                    <span><?php printf( '%1$s', $td_archive_title ) ?></span>
                                </h1>
                            </div>
                            <?php load_template( TDSP_THEME_PATH . '/loop.php', true); ?>

                            <?php echo td_page_generator::get_pagination(); // get the pagination - /includes/wp_booster/td_page_generator.php ?>
                        </div>
                    </div>
                    <?php
                    break;
            }
            ?>
        </div> <!-- /.td-pb-row -->
</div> <!-- /.td-container -->
</div> <!-- /.td-main-content-wrap -->

<?php
get_footer();