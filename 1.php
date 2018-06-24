<?php
// https://www.cnblogs.com/lz2017/p/8046816.html
    function des_ecb_encrypt($data, $key){
        return openssl_encrypt ($data, 'des-ecb', $key);
    }

    /**
     * des-ecb解密
     * @param string  $data 加密数据
     * @param string  $key 加密密钥
     */
    function des_ecb_decrypt ($data, $key){
        return openssl_decrypt ($data, 'des-ecb', $key);
    }

    $key = 112233;
    $data = 'dcs2018';
    $res1 =  des_ecb_encrypt($data,$key);
    var_dump($res1);

    $res = des_ecb_decrypt($res1,$key);
    var_dump($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CryptoJS</title>
    <script src="./crypto-js/crypto-js.js"></script>
    <script src="./crypto-js/tripledes.js"></script>
    <!--<script src="/crypto-js/mode-ecb.js"></script>-->
</head>
<body>
<div id="content">ASDFASDFASFA</div>
<script>

    var keyHex = CryptoJS.enc.Utf8.parse('<?php echo $key?>');
    var encrypted = CryptoJS.DES.encrypt('<?php echo $data?>', keyHex, {
        mode: CryptoJS.mode.ECB,
        padding: CryptoJS.pad.Pkcs7
    });
    console.log(encrypted.toString());
    
    // direct decrypt ciphertext
    var decrypted = CryptoJS.DES.decrypt('<?php echo $res1?>', keyHex, {
        mode: CryptoJS.mode.ECB,
        padding: CryptoJS.pad.Pkcs7
    });
    console.log(decrypted.toString(CryptoJS.enc.Utf8));
</script>
</body>
</html>
