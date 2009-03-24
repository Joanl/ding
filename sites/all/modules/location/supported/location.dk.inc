<?php // $Id: location.dk.inc,v 1.6 2008/01/24 09:00:02 bdragon Exp $

/**
 * @file location.dk.inc
 * Implements country-specific code for the location module
 * for the Kingdom of Denmark.
 */

/**
 * Generate findvej.dk map link.
 *
 * @return string or null
 *    Map link if generation successful, otherwise null.
 */
function location_map_link_dk_findvej($location = array()) {
  if (isset($location['street']) && isset($location['postal_code'])) {
    return sprintf('http://findvej.dk/%s,%s',
      urlencode($location['street']),
      urlencode($location['postal_code'])
    );
  }
  elseif (isset($location['street']) && isset($location['city'])) {
    return sprintf('http://findvej.dk/%s,%s',
      urlencode($location['street']),
      urlencode($location['city'])
    );
  }
  elseif (isset($location['latitude']) && isset($location['longitude'])) {
    return sprintf('http://findvej.dk/?latitude=%s&longitude=%s',
      urlencode($location['latitude']),
      urlencode($location['longitude'])
    );
  }
  else {
    return NULL;
  }
}

/**
 * @return
 *   An array where
 *     -> the key is the word that helps identify the name of function that builds the link.  For example, a key of 'yahoo' means the name of the
 *        the function that builds a link to a map on Yahoo! Maps would be 'location_map_link_us_yahoo'
 *     -> the value is itself an array with 3 key/value pairs:
 *          'name' => points to the name of the mapping service.  For 'yahoo', this would be 'Yahoo! Maps'
 *          'url' => the url of the main page of the mapping service.  For 'yahoo', this would be 'http://maps.yahoo.com'
 *          'tos' => the url of the page that explains the map providers Terms of Service, or Terms of Use. For 'yahoo', this would be
 *                   'http://help.yahoo.com/help/us/maps/maps-24.html'
 */
function location_map_link_dk_providers() {
  return array('findvej' => array(
    'name' => 'findvej.dk',
    'url' => 'http://findvej.dk'
    ),
  );
}

/**
 * @return
 *   An array of values that work as keys to the array returned by location_map_link_us_providers.  The idea is that if the
 *   administrator of the site has not yet had a chance to visit the "Map Links" subtab on the location module's settings page,
 *   that we can provide deep-linking to a relatively safe default.  By 'relatively safe', we mean that the Terms Of Service of
 *   the provider of the maps are flexible enough for most parties.
 *
 *   For the case of the U.S., 'google' has relatively flexible Terms Of Service, whereas Yahoo! Maps and MapQuest have more
 *   restrictive Terms Of Service.
 *
 */
function location_map_link_dk_default_providers() {
  return array('findvej');
}

/**
 * The province list for Denmark.
 *
 * This list is outdated, since the 'Amts' listed here where replaced by
 * larger regions. It is not used in addresses in Denmark and not really
 * important in most cases.
 */
function location_province_list_dk() {
  return array('CC' => "Copenhagen (municipality)",
    'FC' => "Frederiksberg (municipality)",
    'CO' => "Copenhagen",
    'FR' => "Frederiksborg",
    'RO' => "Roskilde",
    'WZ' => "West Zealand",
    'ST' => "Storstrom",
    'FU' => "Funen",
    'SJ' => "South Jutland",
    'RB' => "Ribe",
    'VK' => "Vejle",
    'RK' => "Ringkjobing",
    'VB' => "Viborg",
    'NJ' => "North Jutland",
    'AR' => "Arhus",
    'BH' => "Bornholm",
    'GL' => "Greenland",
    'FO' => "Faroe Islands");
}
