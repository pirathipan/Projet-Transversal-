<style media="screen">
        @import url(https://fonts.googleapis.com/css?family=Roboto:400,900italic,900,700italic,700,500italic,500,400italic,300italic,100italic,300,100);
        body{
            margin: 0;
        }
        .debug {
            height: 40px;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-family: 'Roboto';
            font-weight: 300;
            background-color: #2B2B2B;
        }
        span{

            line-height: 40px;
            padding-left: 10px;
            padding-right: 10px;
        }
        span:not(:last-of-type){
            border-right: solid 1px lightgrey;
        }
        .debug_title{
            background-color: #c0392b;
            border-right: none!important;
            line-height: 40px;
            height: 40px;
            display: inline-block;
            width: 75px;
        }
        </style>

        <div class="debug">
            <span class="debug_title">Debug Bar</span>
            <span>Route : <?= $request_url ?></span>

            <?php if(empty($url_composants[1])){

                $url_composants[1] = 'default';

            }?>
            <span>Controller : <?= $url_composants[1] . 'Controller' ?></span>
            <?php if(empty($url_composants[2])){

                $url_composants[2] = 'index';

            }?>
            <span>Action : <?= $url_composants[2] . 'Action' ?></span>
            <span>ID : <?= $id ?></span>
            <span>Request Method : <?= $_SERVER['REQUEST_METHOD'] ?></span>
            <span>PHP Version : <?= phpversion(); ?></span>
            <span>Time : <?= date('H:i')?></span>
            <span>Port : <?=$_SERVER['SERVER_PORT']?></span>
        </div>
