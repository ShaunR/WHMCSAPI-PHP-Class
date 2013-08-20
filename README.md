WHMCSAPI-PHP-Class
==================

PHP class to easily access the WHMCS API


EXAMPLE
-----------

```
<?PHP
require_once('./whmcsapi.class.php');

try {
	$whmcsapi = new WHMCSAPI(
		array(
			'url' => 'https://localhost/whmcs/includes/api.php',
			'username' => 'admin.user',
			'password' => md5('admin.pass')
		)
	);

	$result = $whmcsapi->request(
		array(
			'action' => 'getclients'
		)
	);

	if($result === false) die( $whmcsapi->getError() );

	var_dump($result);
} catch( Exception $e ) {
	mail('root', 'Caught exception on ' . date('r'), "<pre>" . print_r($e, true) . "</pre>");
	die('An exception was caught, a report of this exception has been sent to our staff for review');
}
?>
```


IRC
-----------

Server: irc.freenode.net

Channel: #whmcs


Authors
-------

**Shaun Reitan**
