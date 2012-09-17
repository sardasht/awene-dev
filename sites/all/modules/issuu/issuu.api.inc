<?php

/**
 * @file
 * Define how to interact with issuu.com API
 */

define('ISSUU_URI', 'http://api.issuu.com/1_0');
define('ISSUU_URI_UPLOAD', 'http://upload.issuu.com/1_0');
define('ISSUU_URI_IMAGE', 'http://image.issuu.com/');
define('ISSUU_DOCUMENTS_LIST', 'issuu.documents.list');
define('ISSUU_DOCUMENT_UPLOAD', 'issuu.document.upload');
define('ISSUU_VIEWER', 'http://static.issuu.com/webembed/viewers/style1/v1/IssuuViewer.swf');
define('ISSUU_LAYOUT', 'http://skin.issuu.com/v/light/layout.xml');

/**
 * Generate signatures.
 *
 * @see http://issuu.com/services/api/signingrequests.html
 */
function issuu_sign_parameters(&$parameters) {
  $signature = '';

  //1.  Sort request parameters alphabetically (e.g. foo=1, bar=2, baz=3 sorts to bar=2, baz=3, foo=1)
  ksort($parameters);

  //2. Concatenate in order your API secret key and request name-value pairs (e.g. SECRETbar2baz3foo1)
  $secret = variable_get('issuu_global_apisecret', '');
  $signature = $secret;
  foreach ($parameters as $k => $v) {
    // file is not part of standard parameters, not documented anywhere, but in this way this works!
    if ($k == 'file') continue;
    $signature .= $k . $v;
  }

  //3. Calculate the signature as the MD5 hash of this string
  $signature = md5($signature);

  //4. Include the signature parameter in the request encoded as lowercase HEX
  $signature = drupal_strtolower($signature);

  $parameters['signature'] = $signature;
}

/**
 * Generate the basic uri
 */
function issuu_prepare_uri(&$parameters, $upload=FALSE) {
  $parameters['apiKey'] = variable_get('issuu_global_apikey', '');
  issuu_sign_parameters($parameters);

  $get_array = array();
  foreach ($parameters as $key => $val) {
    $get_array[] = $key . '=' . urlencode($val);
  }
  $get_string = implode('&', $get_array);

  $base = ISSUU_URI;
  if ($upload) {
    return array(ISSUU_URI_UPLOAD, $get_string);
  }

  return sprintf('%s?%s', $base, $get_string);
}

/**
 * Return possible document types.
 *
 * @see http://issuu.com/services/api/documenttypes.html
 */
function issuu_document_types() {
  return array(
    '000000' => 'Unknown',
    '001000' => 'Article or Essay',
    '002000' => 'Book',
    '003000' => 'Catalog',
    '004000' => 'Journal',
    '005000' => 'Magazine',
    '006000' => 'Manual or Resource',
    '007000' => 'Newspaper',
    '008000' => 'Paper',
    '009000' => 'Photo album',
    '010000' => 'Portfolio',
    '011000' => 'Presentation',
    '012000' => 'Report',
    '013000' => 'Other',
    );
}

/**
 * Return possible document categories.
 *
 * @see http://issuu.com/services/api/documentcategories.html
 */
function issuu_document_categories() {
  return array(
    '000000' => 'Unknown',
    '001000' => 'Auto & Vehicles',
    '002000' => 'Business & Marketing',
    '003000' => 'Creative',
    '004000' => 'Film & Music',
    '005000' => 'Fun & Entertainment',
    '006000' => 'Hobby & Home',
    '007000' => 'Knowledge & Resources',
    '008000' => 'Nature & Animals',
    '009000' => 'News & Politics',
    '010000' => 'Nonprofits & Activism',
    '011000' => 'Religon & Philosophy',
    '012000' => 'Sports',
    '013000' => 'Technology & Internet',
    '014000' => 'Travel & Events',
    '015000' => 'Weird & Bizarre',
    '016000' => 'Other'
    );
}

/**
 * Return possible document categories.
 *
 * @see http://issuu.com/services/api/languagecodes.html
 * issuu uses the same standard than drupal(ISO 639-1) so modify a little _locale_prepare_predefined_list() from core
 */
function issuu_get_languages() {
  $predefined = _locale_get_predefined_list();
  foreach ($predefined as $key => $value) {
    // Issuu doesn't support variants (for example pt-br), so skip those.
    if (strlen($key) != 2) {
      unset($predefined[$key]);
      continue;
    }
    // Include native name in output, if possible
    if (count($value) > 1) {
      $tname = t($value[0]);
      $predefined[$key] = ($tname == $value[1]) ? $tname : "$tname ($value[1])";
    }
    else {
      $predefined[$key] = t($value[0]);
    }
  }
  asort($predefined);
  return $predefined;
}

function issuu_api_issuu_documents_list($parameters=NULL) {
  $default_parameters = array(
    'action' => ISSUU_DOCUMENTS_LIST,
  );
  $parameters = array_merge($default_parameters, (array)$parameters);
  $uri = issuu_prepare_uri($parameters);
  $result = drupal_http_request($uri);
  //TODO make some useful output
  var_dump($result);
}

function issuu_api_issuu_document_upload($file_location, $parameters=NULL) {
  //TODO make sure file exist
  $default_parameters = array(
    'action' => 'issuu.document.upload',
    'file' => '@' . $file_location,
  );
  $issuu_parameters = array();
  // remove issuu_ prefix used for avoid form item names collision
  if (is_array($parameters)) {
    foreach ($parameters as $name => $param) {
      $issuu_parameters[substr($name, 6)] = $param;
    }
  }
  $parameters = array_merge($default_parameters, (array)$issuu_parameters);
  list($uri, $data) = issuu_prepare_uri($parameters, TRUE);

  // curl http post send
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $uri);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);

  $response = curl_exec($ch);
  curl_close($ch);

  return $response;
}

function issuu_api_process_response($response, &$doc_metadata) {
  try {
    $rsp = new SimpleXMLElement($response);
  }
  catch (Exception $e) {
    watchdog('issuu', 'Converting xml to array failed. One possible reason is that issuu.com is down now. The convert failed with exception !exception.', array('!exception' => $e), WATCHDOG_ERROR);
    return FALSE;
  }
  if ((string)$rsp['stat'] == 'ok') {
    foreach ($rsp->document as $document) {
      // get doc values
      $attributes = array('username', 'name', 'documentId', 'title', 'access', 'state', 'contentFlag', 'category', 'type', 'orgDocType', 'orgDocName', 'origin', 'language', 'rating', 'ratingsAllowed', 'commentCount', 'bookmarkCount', 'viewCount', 'pageCount', 'ep', 'publishDate');
      foreach ($attributes as $attr) {
        $doc_metadata[$attr] = (string)$document[$attr];
      }
    }
  }
  else { //TODO there's an error, try to log it
    /*<?xml version="1.0" encoding="UTF-8"? ><rsp stat="fail"><error code="009" message="Authentication required"/></rsp>*/
    if ((string)$rsp['stat'] == 'fail') {
      foreach ($rsp->error as $error) {
        $attributes = array('code', 'message');
        $message = '';
        foreach ($attributes as $attr) {
          $message .= sprintf('attribute: (%s) value: (%s)', $attr, (string)$error[$attr]);
        }
        watchdog('issuu', 'error: !message.', array('!message' => $message), WATCHDOG_ERROR);
      }
    }
    else {
      watchdog('issuu', 'Unknown error: @response.', array('@response' => $response), WATCHDOG_ERROR);
    }
    return FALSE;
  }

  return TRUE;
}

