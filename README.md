WHMCSAPI-PHP-Class
==================

PHP class to easily access the WHMCS API


EXAMPLE
-----------

```
<?PHP
require_once('./whmcsapi.class.php');

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
?>
```


IRC
-----------

Server: irc.freenode.net

Channel: #whmcs


Authors
-------

**Shaun Reitan**
