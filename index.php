<?php 

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
            'name' => '视频', 
            'url' => $google.'?q={q}%20site%3Aacfun.tv%20OR%20site%3Abilibili.com'
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
            Search
        </title>
        <link rel="stylesheet" href="//cdnjscn.b0.upaiyun.com/libs/pure/0.5.0/pure-min.css">
        <style>
            *{margin: 0; padding: 0; } 
            body{overflow: hidden; height: 100%;min-width: 1000px;  } 
            #frame { width: 100%; position: fixed; top:60px; border: 0; border:none; z-index: 7; } 
            #top{background: #eee; width: 100%; text-align: center; position: fixed; top: 0px; height: 60px; z-index: 7; line-height: 60px;  <?php if(!$Searching){ echo "background:none;top:40%;"; } ?> } 
            #site{ display: inline-block; }
            #q{ display: inline-block;width:300px; }
            #go{ display: inline-block; }      
            .button-secondary { background: rgb(66, 184, 221); color: white; border-radius: 4px; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2); }
        </style>
    </head>
    
    <body>

        <form class="pure-form" method="get" action="?" id="top" autocomplete="off">
        
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
            <button type="submit" id="go" class="pure-button pure-button-primary">Go</button>

            <?php if($Searching){ ?>
                <a class="pure-button button-secondary" href="/">Back</a>       
            <?php } ?>
            <a class="pure-button" target="_blank" href="https://github.com/rrkelee/search">Github</a> 
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
