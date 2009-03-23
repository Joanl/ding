// $Id: README.txt,v 1.3.4.1 2008/07/15 16:42:07 greenskin Exp $

Keys API
=======
hook_keys_service()
-------------
  This hook allows modules to create one or more services to be used with Keys API module. This is used to help distinguish keys from one another.
/**
 * Implementation of hook_keys_service().
 */
function hook_keys_service() {
  return array(
    'service_name' => array(
      'name' => t('Name'),
      'description' => t('Description of service.')
    )
  );
}



keys_api_get_key($service,$domain)
-------------
  This helper function gets the key stored in a variable by the
service name provided and the hostname. Modules can use
$_SERVER['HTTP_HOST'] for $domain so that the appropriate key is used based on the hostname.



keys_api_set_key($service,$domain,$key)
-------------
  This function allows developers to set a key via their own settings page. The developer then can set the default_value of the form field using the keys_api_get_key() function.