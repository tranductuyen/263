<?php

class td_module_19 extends td_module {

    function __construct($post, $module_atts = array()) {
        //run the parrent constructor
        parent::__construct($post, $module_atts);
    }

    function render() {
        ob_start();
        $title_length = $this->get_shortcode_att('m19_tl');
        $excerpt_length = $this->get_shortcode_att('m19_el');
        $modified_date = $this->get_shortcode_att('show_modified_date');
        $time_ago = $this->get_shortcode_att('time_ago');
        $time_ago_add_txt = $this->get_shortcode_att('time_ago_add_txt');
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <div class="meta-info-container">
                <div class="td-module-image">
                    <?php echo $this->get_image('td_534x462');?>
                    <?php if (td_util::get_option('tds_category_module_19') == 'yes') { echo $this->get_category(); }?>
                </div>

                <div class="td-item-details">
                    <div class="td-module-meta-info">
                        <?php echo $this->get_title($title_length);?>
                        <?php echo $this->get_author();?>
                        <?php echo $this->get_date($modified_date, false, $time_ago, $time_ago_add_txt);?>
                        <?php echo $this->get_comments();?>
                    </div>

                    <div class="td-excerpt">
                        <?php echo $this->get_excerpt($excerpt_length);?>
                    </div>

                    <div class="td-read-more">
                        <a href="<?php echo $this->href;?>"><?php echo __td('Read more', TD_THEME_NAME);?></a>
                    </div>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}