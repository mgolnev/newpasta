<script src="//vk.com/js/api/xd_connection.js?2"  type="text/javascript">
</script>

<?php



$acces_token = "808167532edd3f3fee7edbde30a15e0cbfdff109872b389aad2a234839c17748921812788e953fd25894e";


$method = "board.getComments";

$params = array(
                "group_id" =>49624358,
                "topic_id" =>28047973,
                "sort"=>'desc',
                "extended"=> 1
                
                );



$url = "https://api.vk.com/method/$method?";

foreach ($params as $a=>$b) {
    
    $url.= "$a=".urlencode($b)."&";
}

$url.= "access_token=$acces_token";


$answer = file_get_contents($url);

echo $answer;

function file_get_contents_curl($url){
    
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
     
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );

    curl_close( $ch );


    return $content;
}
