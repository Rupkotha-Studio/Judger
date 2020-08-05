<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CoderOJ - Judger</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Exo 2" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: "Exo 2";
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height {
                height: 95vh;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 100px;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
        	<?php 
				$infoData = json_decode(file_get_contents("info.json"),true);
				$version = $infoData['version'];	
			?>
            <div class="content">
                <div class="title m-b-md">
                    CoderOJ <font size="14px">Judger <span style="font-size:20px"><?php echo "v ".$version; ?></span></font>
                </div>

                <div class="links">
                    <a href="index.php?ide">Ide</a>
                    <a href="index.php?checker">Checker</a>
                    <a href="https://github.com/Coder-Online-Judge/compiler">Github</a>
                </div>
            </div>
        </div>
    </body>
</html>