<?php

class Route {

	public static function post($route, $kls) {
		if(count($_POST) > 0)
			self::router($route, $kls);
	}

	public static function get($route, $kls) {
		if(count($_POST) == 0) {
			self::router($route, $kls);
		}
	}

	private static function router($route, $kls) {
		//Get and set uri
		$uri = isset($_GET['uri']) ? $_GET['uri']: '/';
		
		//Seleksi pertama
		if($route == '/' && $uri == '/') {
			self::createObj($kls);
		}

		//Seleksi kedua
		else if(strpos($route, ':') === false && $route != '/') {
			$route2 = substr($route, 1);
			$uri = preg_replace('/\/$/', '', $uri);

			if($route2 == $uri) {
				self::createObj($kls);
			}
		}

		//Seleksi ketiga
		else if($route != '/') {
			$arg = [];
			$route2 = substr($route, 1);
			$exRoute = explode('/', $route2);
			$exUri = explode('/', $uri);
			$uri = preg_replace('/\/$/', '', $uri);

			if(count($exUri) == count($exRoute)) {
				//Check the uri and route
				foreach($exRoute as $key => $value) {
					if(strpos($value, ':') === 0) {
						$arg[] = $exUri[$key];
					}
					else if($value != $exUri[$key]) {
						return;
					}
				}
				self::createObj($kls, $arg);
			}
		}
		
	}

	private static function createObj($kls, $arg = []) {
		$kls = explode('@', $kls);
		$fileController = 'controllers/' . $kls[0] . '.php';

		if(file_exists($fileController)) {
			require $fileController;

			if(class_exists($kls[0])) {

				$object = new $kls[0];
				if(method_exists($object, $kls[1])) {
					call_user_func_array(array($object, $kls[1]), $arg);

					exit();
				}
				else {
					echo 'method not exists';
				}

			}
			else {
				echo 'class not exists';
			}
		}
		else {
			echo 'file not exists';
		}
	}

}