<?php
	spl_autoload_register(function($class) {
		$filename = 'classes/'.$class.'.php';
		$filename = str_replace('\\', '/', $filename);

		if (file_exists($filename)) {
			include_once $filename;
		}
	});
?>