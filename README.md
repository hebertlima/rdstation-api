Required:
 - curl_init
 - curl_setopt

How to use:

```php
use Hdelima\RDStation\RDStation;

# set .env RDSTATION_PUBLIC_KEY=token_here
$rdStation = new RDStation(env('RDSTATION_PUBLIC_KEY'));

# $rdStation->{verb}(url, $args = [], $timeout = 10);
# verbs: post, get, put, patch, delete

# return array
$rdStation->post('conversions', [
   'event_type' => 'CONVERSION', 	// optional default CONVERSION 
   'event_family' => 'CDP', 		// optional default CDP 
   'payload' => [
      'conversion_identifier' => 'CONVERSÃO TESTE', 	// required default CONVERSION
      'email' => 'email@domain.com', 	 	 	// required
      // oother fields...
   ]
]);
```

Running Test:

```bash
$ phpunit tests
```
