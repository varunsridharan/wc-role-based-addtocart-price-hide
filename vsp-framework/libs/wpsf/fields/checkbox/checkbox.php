<?php
/*-------------------------------------------------------------------------------------------------
- This file is part of the WPSF package.                                                          -
- This package is Open Source Software. For the full copyright and license                        -
- information, please view the LICENSE file which was distributed with this                       -
- source code.                                                                                    -
-                                                                                                 -
- @package    WPSF                                                                                -
- @author     Varun Sridharan <varunsridharan23@gmail.com>                                        -
 -------------------------------------------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
} // Cannot access pages directly.

/**
 *
 * Field: Checkbox
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 */
class WPSFramework_Option_checkbox extends WPSFramework_Options {
	/**
	 * WPSFramework_Option_checkbox constructor.
	 *
	 * @param        $field
	 * @param string $value
	 * @param string $unique
	 */
	public function __construct( $field, $value = '', $unique = '' ) {
		parent::__construct( $field, $value, $unique );
	}

	public function output() {
		echo $this->element_before();

		if ( isset( $this->field ['options'] ) && is_array( $this->field ['options'] ) && ! empty( $this->field ['options'] ) ) {

			$options = $this->field ['options'];
			$options = ( is_array( $options ) ) ? $options : array_filter( $this->element_data( $options ) );

			if ( ! empty( $options ) ) {

				echo '<ul' . $this->element_class() . '>';
				foreach ( $options as $key => $value ) {
					if ( is_array( $value ) && ! isset( $value['label'] ) ) {
						$values = $this->element_value();
						$gid    = wpsf_sanitize_title( $key );
						$values = isset( $values[ $gid ] ) ? $values[ $gid ] : $values;
						echo '<li><h3>' . $key . '</h3><ul>';
						foreach ( $value as $i => $v ) {
							$data               = $this->element_handle_option( $v, $i );
							$i                  = $data['id'];
							$v                  = $data['value'];
							$attr               = $data['attributes'];
							$attr['data-group'] = $gid;
							echo '<li>' . $this->_element( '[' . $gid . '][]', $i, $v, $values, $attr, $data ) . '</li>';
						}
						echo '</ul></li>';
					} else {
						$data = $this->element_handle_option( $value, $key );
						echo '<li>' . $this->_element( '[]', $data['id'], $data['value'], $this->element_value(), $data['attributes'], $data ) . '</li>';
					}
				}
				echo '</ul>';
			}
		} else {
			$label = ( isset( $this->field ['label'] ) ) ? $this->field ['label'] : '';
			echo '<label><input type="checkbox" name="' . $this->element_name() . '" value="1" ' . $this->element_class() . $this->element_attributes() . checked( $this->element_value(), 1, false ) . '/> ' . $label . '</label>';
		}

		echo $this->element_after();
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @param string $title
	 * @param array  $chboxval
	 * @param string $attributes
	 * @param array  $data
	 *
	 * @return string
	 */
	public function _element( $name = '', $value = '', $title = '', $chboxval = array(), $attributes = '', $data = array() ) {
		if ( isset( $this->field['icon_box'] ) && true === $this->field['icon_box'] ) {
			$attr       = $this->element_attributes( $value, $attributes );
			$is_checked = $this->checked( $chboxval, $value );
			$checkbox   = '<input type="checkbox" name="' . $this->element_name( $name ) . '" value="' . $value . '" ' . $attr . ' ' . $is_checked . '/>';
			$icon       = '<span class="wpsf-icon-preview wpsf-help" data-title="' . $title . '"><i class="' . $data['icon'] . '"></i></span>';
			return ' <label class="with-icon-preview">' . $checkbox . ' ' . $icon . '</label > ';
		}
		return '<label > <input type="checkbox" name="' . $this->element_name( $name ) . '" value="' . $value . '" ' . $this->element_attributes( $value, $attributes ) . $this->checked( $chboxval, $value ) . ' /> ' . $title . ' </label > ';

	}

	/**
	 * @return array
	 */
	protected function field_defaults() {
		return array(
			'icon_box'   => false,
			'label'      => false,
			'options'    => array(),
			'settings'   => array(),
			'query_args' => array(),
		);
	}
}
