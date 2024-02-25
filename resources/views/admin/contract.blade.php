<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .contract-content {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        #exportBtn {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="contract-content">
            <h1>Bazaar</h1>
            <h2>Zakelijk Adverteerder Contract</h2>

            <h3>Partijen</h3>
            <p>Dit contract wordt gesloten tussen {{$user->name." ".$user->lastname}},
                hierna aangeduid als " Zakelijke adverteerder", en Bazaar.</p>

            <h3>Doel</h3>
            <p>Het doel van dit contract is om de voorwaarden en overeenkomsten vast te leggen met betrekking tot de advertentiediensten die door de Adverteerder worden afgenomen van Bazaar.</p>

            <h3>Ondertekening</h3>
            <p>Dit contract treedt in werking op {{ date('d-m-Y')}}. Beide partijen verklaren dat zij de inhoud van dit contract hebben begrepen en ermee akkoord gaan.</p>

            <p>Getekend voor en namens Adverteerder:</p>
            <p>[Naam van de vertegenwoordiger van de Adverteerder]</p>
            <p>Handtekening: ___________________________</p>
            <p>Datum: ___________________________</p>

            <p>Getekend voor en namens Bazaar:</p>
            <p>[Naam van de vertegenwoordiger van Bazaar]</p>
            <p>Handtekening: ___________________________</p>
            <p>Datum: ___________________________</p>
        </div>
    </div>
</body>
</html>
