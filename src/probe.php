<?php
namespace Rhiaro;

use EasyRdf_Graph;
use Requests;
use phpish\link_header;

/**
 * Endpoint
 * 
 * @param
 * @return
*/
function endpoint($url, $endpoint){
    
    // Look in HTTP headers
    $response = Requests::head($url);
    $ep = from_http_headers($response->headers, $endpoint);
    if(isset($ep) && !empty($ep)){
        // return $ep;
    }
    
    // Look in HTML for <link>

    // Look for JSON key
    $response = Requests::get($url, array('Accept' => 'application/json'));
    $ep = from_json($response->body, $endpoint);
    if(isset($ep) && !empty($ep)){
        return $ep;
    }

    // Parse as RDF and look for predicate
    $response = Requests::get($url, array('Accept' => 'application/ld+json'));
    $ep = from_jsonld($response->body, $url, $endpoint);
    if(isset($ep) && !empty($ep)){
      return $ep;
    }
}

function from_http_headers($headers, $endpoint){
    if(!isset($headers['link'])){
        return false;
    }
    $links = explode(',', $headers['link']);
    $parsed = array();
    foreach($links as $link){
        $res = link_header\parse($link);
        foreach($res as $rel => $value){
            if(!isset($parsed[$rel])){
                $parsed[$rel] = array();
            }
            foreach($value as $uri){
                array_push($parsed[$rel], $uri['uri']);
            }
        }
    }
    return $parsed[$endpoint];
}

function from_html_link(){

}

function from_json($json, $endpoint){
    $json_array = json_decode($json, true);
    if(isset($json_array[$endpoint])){
        return $json_array[$endpoint];
    }
    return false;
}

function from_jsonld($json, $subject, $endpoint){
    $graph = new EasyRdf_Graph($subject);
    $graph->parse($json, 'jsonld', $subject);
    $r = $graph->resource($subject);
    echo $r->dump();
    var_dump($r->get($endpoint));
    // return $ep;
}

function from_rdf(){

}

  


?>