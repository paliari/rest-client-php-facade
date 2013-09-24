<?php
require_once __DIR__."/boot.php";
//header('Content-Type: text/plain');

$processo = @$_REQUEST['processo'];

if ($_POST) {
    $uri = "/snx/r/bpm/pmmintegration/paliari/$processo";
    echo "<pre>";
    try {
        $response = $rest->get($uri)
            ->parseWith(function($body) {
                $ret = json_decode($body, true);
                //print_r($ret);
                return $ret;
            })
            ->send();
        print_r(($response->body));
    } catch (Exception $e) {
        print_r($e);
    }
    echo "</pre>";
    exit("<a href='/?processo=$processo'>novo</a>");
}
?>
<form method="post">
    <input type="text" name="processo" value="<?= $processo ?>">
    <button type="submit">Enviar</button>
</form>