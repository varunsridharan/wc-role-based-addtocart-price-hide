<?php
/*-------------------------------------------------------------------------------------------------
 - This file is part of the WPSF package.                                                         -
 - This package is Open Source Software. For the full copyright and license                       -
 - information, please view the LICENSE file which was distributed with this                      -
 - source code.                                                                                   -
 -                                                                                                -
 - @package    WPSF                                                                               -
 - @author     Varun Sridharan <varunsridharan23@gmail.com>                                       -
 -------------------------------------------------------------------------------------------------*/

/**
 * Class WPSFramework_Option_links
 */
class WPSFramework_Option_links extends WPSFramework_Options {

    /**
     * WPSFramework_Option_links constructor.
     * @param        $field
     * @param string $value
     * @param string $unique
     */
    public function __construct($field, $value = '', $unique = '') {
        parent::__construct($field, $value, $unique);
        if( ! class_exists("_WP_Editors") ) {
            require_once ABSPATH . "wp-includes/class-wp-editor.php";
            $this->addAction("admin_footer", 'add_links_template', 99);
        }

        wp_enqueue_style('editor-buttons');
        wp_enqueue_script('wplink');
    }


    public function add_links_template() {
        echo _WP_Editors::wp_link_dialog();
    }

    public function output() {
        $default = array(
            'url'    => '',
            'title'  => '',
            'target' => '',
        );
        $data    = empty($this->element_value()) ? array() : $this->element_value();
        $arg     = wp_parse_args($data, $default);

        echo $this->element_before();
        $attributes = $this->element_attributes(array( 'class' => 'wpsf_wp_link_picker_container' ));
        echo '<div ' . $attributes . '>';

        echo '<input type="hidden" value="' . $arg['url'] . '" class="wpsf-url" name="' . $this->element_name('[url]') . '"/>';
        echo '<input type="hidden" value="' . $arg['title'] . '" class="wpsf-title" name="' . $this->element_name('[title]') . '"/>';
        echo '<input type="hidden" value="' . $arg['target'] . '" class="wpsf-target" name="' . $this->element_name('[target]') . '"/>';

        echo '<span class="link"><strong>' . __("URL :", 'wpsf-framework') . '</strong> <span class="url-value">' . $arg['url'] . '</span> </span><br/>';
        echo '<span class="link-title"><strong>' . __("Title :", 'wpsf-framework') . '</strong> <span class="link-title-value">' . $arg['title'] . '</span> </span> <br/> ';
        echo '<span class="target"><strong>' . __("Target :", 'wpsf-framework') . '</strong> <span class="target-value">' . $arg['target'] . '</span> </span> <br/><br/> ';
        echo '<a href="#" class="button wpsf-wp-link">' . __("Select URL", 'wpsf-framework') . '</a>';

        echo '<input id="sample_wplinks" type="hidden" />';
        echo '</div>';
        echo $this->element_after();
    }
}
