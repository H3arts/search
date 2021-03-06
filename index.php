<?php 
    
    // google 镜像域名
    $google = 'https://www.googto.com/' ; 

    $sites=array( 
        array( 
            'name' => '谷歌', 
            'url' => $google.'?q={q}' 
        ), 
        array( 
            'name' => '百度', 
            'url' => 'https://www.baidu.com/s?ie=utf-8&wd={q}'
        ), 
        array( 
            'name' => 'A站', 
            'url' => 'http://www.acfun.tv/search/#query={q};page=1;channel=7'
        ), 
        array( 
            'name' => 'B站', 
            'url' => 'http://www.bilibili.com/search?keyword={q}&tids=23'
        ),
        array( 
            'name' => '知乎', 
            'url' => $google.'?q={q}%20site%3Azhihu.com'
        ), 
        array( 
            'name' => 'v2ex', 
            'url' => $google.'?q={q}%20site%3Av2ex.com'
        ), 
        array( 
            'name' => '词典', 
            'url' => 'http://dict.youdao.com/app/baidu/search?q={q}'
        ), 
        array( 
            'name' => '百度云', 
            'url' => $google.'?q={q}%20site%3Apan.baidu.com' 
        ), 
        array( 
            'name' => '谷歌图片', 
            'url' => 'https://www.googto.com/?tab=image&q={q}'
        )
    );

    $q = isset( $_GET[ 'q'] ) ? $_GET[ 'q'] : '' ; 

    $siteid = isset( $_GET['siteid'] ) && isset( $sites[intval($_GET[ 'siteid'])] ) ? intval($_GET[ 'siteid']) : 0 ;

    $url = $q ? str_replace("{q}", $q, $sites[$siteid]['url']) : 'about:blank';

    $Searching = !!$q;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
        <link rel="bookmark" type="image/x-icon" href="/favicon.ico" />
        <title>
            <?php if($q){
                echo $q .' - '. $sites[$siteid]['name'] . ' - ';
            } ?>search
        </title>
        <style>
            *{margin: 0; padding: 0; font:14px "Menlo", "Luxi Sans", "DejaVu Sans", Tahoma, "Hiragino Sans GB", "Microsoft Yahei", sans-serif; outline: none !important; } 
            body{overflow: hidden; height: 100%;min-width: 1000px;  } 
            #frame { width: 100%; position: fixed; top:0; border: 0; border:none; z-index: 7; } 
            #top{background: #eee; width: 100%; text-align: center; position: fixed; bottom: 0px; height: 59px; z-index: 7; line-height: 59px; box-shadow: 0 0 5px #888;border-top: 1px solid #ccc; 
                <?php if(!$Searching){ ?>
                background: none;bottom: 60%;box-shadow: none;border: none;
                <?php } ?> 
            } 
            #site{ display: inline-block; border: 1px solid #d9d9d9;height: 38px;line-height: 38px; box-sizing: content-box;text-align: center;transition:all .5s ease-in-out; }
            #q{ display: inline-block;width:300px;border: 1px solid #d9d9d9; height: 38px;line-height: 38px; text-indent: 6px;box-sizing: content-box; transition:all .5s ease-in-out; }
            #site:focus,#q:focus{ border: 1px solid #4d90fe; }
            #go{ display: inline-block;color:white;background-color: #4d90fe; }      
            .button { display: inline-block; border: 1px solid #4d90fe; height: 38px;line-height: 38px;text-align: center;background: none;box-sizing: content-box;width:60px;cursor: pointer; }
            a.button { color:white;background-color: #4d90fe;text-decoration: none; }
        </style>
    </head>
    <body>
        <form method="get" action="?" id="top" autocomplete="off">
        
            <select name="siteid" id="site">
                <!-- 选项开始 -->
                <?php 
                foreach ($sites as $key=> $value) { 

                    $selected = $key == $siteid ? 'selected' : ''; 
                    echo '<option '.$selected.' value="'.$key.'">'.$value['name'].'</option>'; 

                } 
                ?>
                <!-- 选项结束 -->
            </select>
            <input type="text" id="q" name="q" autocomplete="off" value="<?php echo $q; ?>">
            <button type="submit" id="go" class="button">Go</button>

            <?php if($Searching){ ?>
                <a class="button" href="/">Back</a>       
            <?php } ?>
            <a class="button" target="_blank" href="https://github.com/rrkelee/search">Github</a> 
        </form>

        <?php if($Searching){ ?>
            <iframe id="frame" src="<?php echo $url; ?>"></iframe>
        <?php } ?>

        <script src="//cdnjscn.b0.upaiyun.com/libs/jquery/2.1.1/jquery.min.js">
        </script>
        <script>
            $(document).ready(function() {

                var go = function() {
                    if( $('#q').val() ){
                        $('#top').submit();
                    }
                }
                $('#top').submit(function(){
                    if( !$('#q').val() ){
                        return false;
                    }
                });
                $('#go').click(go);
                $('#site').change(go);
                $(document).keyup(function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        go();
                    }
                    if ( e.which === 27 ) {
                        location.href = "/";
                    }
                });

                <?php if($Searching){ ?>
                var _resize = function() {
                    var h = $(window).height() - 60;
                    $("#frame").css({
                        height: h
                    });
                }
                _resize();
                $(window).resize(_resize);
                <?php } ?>

            });
        </script>
    </body>
</html>
