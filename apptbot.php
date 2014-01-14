<?php

//uncomment and fill out
#$to= 'gbarnes@asianhope.org,lyle@asianhope.org';
#$subject = 'appointments available!';
#$from = 'noreply@services.asianhope.org';
#$headers = "From:$from";


$months = Array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
$month = ltrim(date('m'),'0');

$url = 'https://evisaforms.state.gov/acs/default.asp?PostCode=BNK&CountryCode=THAI++++++&CountryCodeShow=&PostCodeShow=&Submit=Submit';
$url2 = 'https://evisaforms.state.gov/acs/make_default.asp?pc=BNK';
$url3 = "https://evisaforms.state.gov/acs/make_calendar.asp?nMonth=$month&nYear=2014&type=2&servicetype=02B&pc=BNK";

$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
$cookie = 'cookie.txt';
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


curl_setopt($ch, CURLOPT_URL, $url);
curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $url2);
curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, $url3);
$res = curl_exec($ch);

$avail = substr_count($res, 'Available (');

if($avail>0){
   $message = "$avail day(s) available this month! (".$months[$month].")\n\n";
   $message .= "Make a reservation:\n";
   $message .= "$url\n";
   mail($to,$subject,$message,$headers);
}
curl_close($ch);

?>
