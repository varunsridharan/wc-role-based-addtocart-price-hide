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
 * Field: Sub Heading
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 */
class WPSFramework_Option_subheading extends WPSFramework_Options {
	/**
	 * WPSFramework_Option_subheading constructor.
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
		echo $this->field ['content'];
		echo $this->element_after();
	}

	protected function field_defaults() {
		return array(
			'content' => '',
		);
	}
}
