<?php
$to= 'you@yourdomain.com';
$from = 'noreply@yourdomain.com';

$subject = 'appointments available!';
$headers = "From:$from";


$months = Array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
$month = ltrim(date('m'),'0');

$url = 'https://evisaforms.state.gov/acs/default.asp?PostCode=BNK&CountryCode=THAI++++++&CountryCodeShow=&PostCodeShow=&Submit=Submit';
$url2 = 'https://evisaforms.state.gov/acs/make_default.asp?pc=BNK';
$url3 = "https://evisaforms.state.gov/acs/make_calendar.asp?nMonth=$month&nYear=2021&type=2&servicetype=02B&pc=BNK";

$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
$cookie = 'cookie.txt';
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


//establish a session
curl_setopt($ch, CURLOPT_URL, $url);
curl_exec($ch);

//make Bangkok the default embassy
curl_setopt($ch, CURLOPT_URL, $url2);
curl_exec($ch);

//check the appointments!
curl_setopt($ch, CURLOPT_URL, $url3);
$res = curl_exec($ch);

//count the number of Available slots
$avail = substr_count($res, 'Available (');

//only send an email if there are some appointments
if($avail>0){
   $message = "$avail day(s) available this month! (".$months[$month].")\n\n";
   $message .= "Make a reservation:\n";
   $message .= "$url\n";
   mail($to,$subject,$message,$headers);
}
curl_close($ch);

?>
