<?php
if ( ! function_exists('mopr_check_empty_table'))
{
	/**
	 * Checks if the MobilePress table is empty
	 *
	 * @package MobilePress
	 * @since 1.0
	 * @return BOOL True or false
	 */
	function mopr_check_empty_table()
	{
		global $wpdb;
		
		if ($wpdb->get_var("SELECT COUNT(*) FROM " . MOPR_TABLE) == 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

if ( ! function_exists('mopr_check_table_exists'))
{
	/**
	 * Checks if the MobilePress table exists in the WordPress database
	 *
	 * @package MobilePress
	 * @since 1.0
	 * @return BOOL True or false
	 */
	function mopr_check_table_exists()
	{
		global $wpdb;
		
		if ($wpdb->get_var("SHOW TABLES LIKE '" . MOPR_TABLE . "'") == MOPR_TABLE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
}

if ( ! function_exists('mopr_display_notice'))
{
	/**
	 * Displays an admin area notice
	 *
	 * @package MobilePress
	 * @since 1.0
	 * @param STRING $notice The message you want to be displayed
	 */
	function mopr_display_notice($notice)
	{
		echo '<div id="message" class="updated fade">' . $notice . '</div>';
	}
}

if ( ! function_exists('mopr_get_option'))
{
	/**
	 * Fetches the specified option from the MobilePress database table
	 *
	 * @package MobilePress
	 * @since 1.0
	 * @param STRING $option_name The name of the option that must be fetched
	 * @param INT $number The first or second option value
	 * @return STRING Returns the option value
	 */
	function mopr_get_option($option_name, $number = NULL)
	{
		global $wpdb;
		
		if ($number == NULL)
		{
			$number = 0;
		}
		else
		{
			$number -= 1;
		}
		
		// Select the option from the mobilepress table
		$sql	= "SELECT option_value, option_value_2 FROM " . MOPR_TABLE . " WHERE option_name='" . $wpdb->escape($option_name) . "'";
		$result	= $wpdb->get_row($sql, ARRAY_N);
		
		if (isset($result[$number]))
		{
			return $result[$number];
		}
		
		return NULL;
	}
}

if ( ! function_exists('mopr_get_version'))
{
	/**
	 * Fetches and returns the current version of the plugin
	 *
	 * @package MobilePress
	 * @since 1.0
	 * @return INT Version number of the plugin 
	 */
	function mopr_get_version()
	{
		if ( ! function_exists('get_plugin_data'))
		{
			if (file_exists(ABSPATH . 'wp-admin/includes/plugin.php'))
			{
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			else
			{
				return "Error!";
			}
		}
		
		$data = get_plugin_data(dirname(dirname(dirname(__FILE__))) . '/mobilepress.php');
		return $data['Version'];
	}
}

if ( ! function_exists('mopr_load_view'))
{
	/**
	 * Loads a view
	 *
	 * @package MobilePress
	 * @since 1.1
	 */
	function mopr_load_view($view, $vars = NULL)
	{
		if ($vars != NULL)
		{
			foreach ($vars as $name => $value)
			{
				// Assign definied variables sent to function with the name they set
				$$name = $value;
			}
		}
		
		if (($_view = include(MOPR_PATH . 'views/' . $view . '.php')) !== FALSE)
		{
			echo trim($_view, '1');
		}
	}
}

if ( ! function_exists('mopr_load_json_library'))
{
	/**
	 * Loads the JSON library
	 *
	 * @package MobilePress
	 * @since 1.1
	 */
	function mopr_load_json_library()
	{
		require_once(MOPR_PATH . 'libraries/json.php');
		return new Services_JSON();
	}
}

if ( ! function_exists('mopr_load_aduity_api_library'))
{
	/**
	 * Loads the Aduity Library
	 *
	 * @package MobilePress
	 * @since 1.1
	 */
	function mopr_load_aduity_api_library($apk, $ask)
	{
		require_once(MOPR_PATH . 'libraries/aduity_api.php');
		return new Aduity_api_request($apk, $ask);
	}
}
?>