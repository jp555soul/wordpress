<?php

if ( ! class_exists( 'RWMB_Radio_Field' ) ) 
{
	class RWMB_Radio_Field 
	{
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field ) 
		{
			$html = '';
			foreach ( $field['options'] as $key => $value ) 
			{
				$checked = checked( $meta, $key, false );
				$id		 = strstr( $field['id'], '[]' ) ? str_replace( '[]', "-{$key}[]", $field['id'] ) : $field['id'];
				$id		 = " id='{$id}'";
				$name = "name='{$field['field_name']}'";
				$val     = " value='{$key}'";
				$html   .= "<input type='radio' class='rwmb-radio'{$name}{$id}{$val}{$checked} /> {$value}";
			}

			return $html;
		}
	}
}