<?php

class Browser implements arrayaccess {
    protected static $instances = array();

	protected $browser;
	protected $userAgent;

	protected $browserRegExp = array(
		'/(opr)[\/]([\w.]+)/',
  		'/(chrome)[ \/]([\w.]+)/',
  		'/(version)[ \/]([\w.]+).*(safari)[ \/]([\w.]+)/',
  		'/(webkit)[ \/]([\w.]+)/', 
  		'/(opera)(?:.*version|)[ \/]([\w.]+)/',
  		'/(msie) ([\w.]+)/', 
  		'/trident.*(rv)(?::| )([\w.]+)/',
		'/(?:(?!compatible))(mozilla)(?:.*? rv:([\w.]+)|)/'
	);

  	protected $platformRegExp = array(
		'/(ipad)/',
  		'/(iphone)/',
  		'/(android)/',
  		'/(windows phone)/',
  		'/(win)/',
  		'/(mac)/',
  		'/(linux)/',
  		'/(cros)/'
	);

	public static function get($userAgent = null) {
		return isset(self::$instances[$userAgent]) ? self::$instances[$userAgent] : new Browser($userAgent);
	}

	public function __construct($userAgent = null) {
		if (!empty($userAgent)) {
			$this->userAgent = mb_strtolower($userAgent);
		} else {
			$this->userAgent = mb_strtolower(
				isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''
			);
		}
		$this->_match();
	}
	
	
	public function _match() {
		$matched = array(
			'browser' 	=> null,
			'version'	=> null,
			'platform'	=> null
		);
		
		foreach ($this->browserRegExp as $regExp) {
			$matches = array();
			if (preg_match($regExp, $this->userAgent, $matches)) {
				$matched['browser'] = isset($matches[3]) ? $matches[3] : (isset($matches[1]) ? $matches[1] : '');
				$matched['version'] = isset($matches[2]) ? $matches[2] : 0;
				break;
			}
		}
		
		foreach ($this->platformRegExp as $regExp) {
			$matches = array();
			if (preg_match($regExp, $this->userAgent, $matches)) {
				$matched['platform'] = isset($matches[0]) ? $matches[0] : '';
				break;
			}
		}
		
		$browser = array();

		if ($matched['browser']) {
			$browser[ $matched['browser'] ] = true;
			$browser['version'] 			= $matched['version'];
			$browser['versionNumber'] 		= intval($matched['version']);
		}

		if ($matched['platform']) {
			$browser[ $matched['platform'] ] = true;
		}

		// These are all considered mobile platforms, meaning they run a mobile browser
		if (isset($browser['android']) || isset($browser['ipad']) || isset($browser['iphone']) || isset($browser['windows phone'])) {
			$browser['mobile'] = true;
		}

		// These are all considered desktop platforms, meaning they run a desktop browser
		if (isset($browser['cros']) || isset($browser['mac']) || isset($browser['linux']) || isset($browser['win'])) {
			$browser['desktop'] = true;
		}

		// Chrome, Opera 15+ and Safari are webkit based browsers
		if (isset($browser['chrome']) || isset($browser['opr']) || isset($browser['safari'])) {
			$browser['webkit'] = true;
		}

		// IE11 has a new token so we will assign it msie to avoid breaking changes
		if (isset($browser['rv'])) {
			$matched['browser'] = 'msie';
			$browser['msie'] 	= true;
		}

		// Opera 15+ are identified as opr
		if (isset($browser['opr'])) {
			$matched['browser'] = 'opera';
			$browser['opera'] 	= true;
		}

		// Stock Android browsers are marked as Safari on Android.
		if (isset($browser['safari']) && isset($browser['android'])) {
			$matched['browser'] = 'android';
			$browser['android'] = true;
		}

		// Assign the name and platform variable
		$browser['name'] 		= $matched['browser'];
		$browser['platform'] 	= $matched['platform'];

		$this->browser = $browser;
	}

	public function __get($property) {
		return array_key_exists($property, $this->browser) ? $this->browser[$property] : false;
	}

	public function offsetSet($offset, $value) {
        throw new Exception('Method not allowed');
    }

    public function offsetExists($offset) {
        return isset($this->browser[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->browser[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->browser[$offset]) ? $this->browser[$offset] : null;
    }
}

$b = new Browser();
echo "Name: " . $b->name . "<br>";
echo "Version: " . $b->version . "<br>";
echo "OS: " . $b->platform . "<br>";
echo "Mobile: " . var_export($b->mobile, true) . "<br>";
echo "MS IE " . var_export(Browser::get()->msie, true) . "<br>";
echo "Mozilla " . var_export(Browser::get()->mozilla, true) . "<br>";
echo "Win Phone " . var_export(Browser::get()['windows phone'], true) . "<br>";