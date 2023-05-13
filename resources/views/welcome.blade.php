<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>


    </head>


    
<body>
    <div id="qrcode"></div>
</body>
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

<script>
    const qrcode = new QRCode(document.getElementById('qrcode'), {
text: 'http://localhost:8000/',
width: 128,
height: 128,
colorDark : '#000',
colorLight : '#fff',
correctLevel : QRCode.CorrectLevel.H
});
    </script>

</html>
