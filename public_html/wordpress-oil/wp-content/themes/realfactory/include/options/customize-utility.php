<?php

	// use to clear an option for customize page
	if( !function_exists('realfactory_clear_option') ){
		function realfactory_clear_option(){
			$options = array('general', 'typography', 'color', 'plugin');

			foreach( $options as $option ){
				unset($GLOBALS['rftr_' . $option]);
			}
			
		}
	}