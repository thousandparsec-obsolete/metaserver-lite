<?php

/**
 * FIXME: Need a comment please..
 *
 */

class Games {
	/* Required parameters */
	public static var $required = array('name', 'tp', 'server', 'sertype', 'rule', 'rulever');
	/* Optional parameters */
	public static var $optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');

	public static function optional_index($key) {
		if (!in_array($Games::optional, $key))
			// Raise an exception
			throw new Exception("$key is not a valid optional parameter.");
		return array_search($key, $Games::optional)+1;
	}

}

