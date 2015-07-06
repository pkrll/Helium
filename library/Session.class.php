<?php
/**
* A class for handling sessions across the app.
*
* @author Ardalan Samimi
*/
final class Session {

    /**
     * Set the session variable. If the
     * '$global' param is set to false
     * the session variable should not
     * be accessible by any other class
     * than the invoking one.
     *
     * @param string $key
     * @param mixed $value
     * @param bool $global (optional)
     */
	public static function set ($key, $value, $global = TRUE) {
		$variableName = self::constructVariableName($key, $global);
		$_SESSION[$variableName] = $value;
	}

    /**
     * Retrieves the session variable.
     *
     * @param string $key
     * @param bool $global (optional)
     * @return mixed
     */
	public static function get ($key, $global = TRUE) {
		$variableName = self::constructVariableName($key, $global);
		return isset($_SESSION[$variableName]) ? $_SESSION[$variableName] : NULL;
	}

    /**
     * Clears the session variable.
     *
     * @param string $key
     * @param bool $global (optional)
     */
	public static function clear ($key, $global = TRUE) {
		$variableName = self::constructVariableName($key, $global);
		unset($_SESSION[$variableName]);
	}

    /**
     * Checks if a session is set.
     *
     * @param string $key
     * @return bool
     */
	public static function check ($key) {
		return isset($_SESSION[$key]) ? TRUE : FALSE;
	}

    /**
     * Generates a name for the session variable. If the
     * global parameter is TRUE the name should have the
     * prefix of the apps short name, otherwise the class.
     *
     * @param string $key
     * @param bool $global
     * @return string
     */
	private static function constructVariableName ($key, $global = TRUE) {
		if ($global)
			return APP_NAME_SHORT . '_' . $key;
		else
			return get_called_class() . '_' . $key;
	}
}

?>
