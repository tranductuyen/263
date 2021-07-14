<?php

class td_module_6 extends td_module {

    function __construct($post, $module_atts = array()) {
        //run the parrent constructor
        parent::__construct($post, $module_atts);
    }

    function render() {
        ob_start();
        $title_length = $this->get_shortcode_att('m6_tl');
        $modified_date = $this->get_shortcode_att('show_modified_date');
        $time_ago = $this->get_shortcode_att('time_ago');
        $time_ago_add_txt = $this->get_shortcode_att('time_ago_add_txt');
        ?>

        <div class="<?php echo $this->get_module_classes();?>">

        <?php echo $this->get_image('td_100x70');?>

        <div class="item-details">
            <?php echo $this->get_title($title_length);?>
            <div class="td-module-meta-info">
                <?php if (td_util::get_option('tds_category_module_6') == 'yes') { echo $this->get_category(); }?>
                <?php //echo $this->get_author();?>
                <?php echo $this->get_date($modified_date, false, $time_ago, $time_ago_add_txt);?>
                <?php //echo $this->get_comments();?>
            </div>
        </div>

        </div>

        <?php return ob_get_clean();
    }
}