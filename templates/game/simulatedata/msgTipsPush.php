    <?php
      
    $filename  = dirname(__FILE__).'/data.txt';
      
    // store new message in the file
    $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
    if ($msg != '')
    {
      file_put_contents($filename,$msg);
      die();
    }
      
    // infinite loop until the data file is not modified
    $lastmodif    = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
    $currentmodif = filemtime($filename);
    while ($currentmodif <= $lastmodif) // check if the data file has been modified
    {
      usleep(10000); // sleep 10ms to unload the CPU
      clearstatcache();
      $currentmodif = filemtime($filename);
    }
      
    // return a json array
    $response = array();
    $response['code'] = 0;
    $response['data'] = array(
            array(
                'name' => 'messageTips',
                'tplData' => array(
                    array(
                        'html' => '<li><div class="game_logo"><img src="../images/game/n115/tipslogo.png" /></div><div class="content">恭喜在双色球第 2013090 期中奖 <span class="color-red">1,000</span> 元, <a href="#"> 查看详情</a></div><i class="close_btn"></i></li>'
                    ),
                    array(
                        'html' => '<li><div class="game_logo"><img src="../images/game/n115/tipslogo.png" /></div><div class="content">恭喜在时时彩第 2013090 期中奖 <span class="color-red">1,000</span> 元, <a href="#"> 查看详情</a></div><i class="close_btn"></i></li>'
                    )
                )
            )
    	);
    $response['msg']       = file_get_contents($filename);
    $response['timestamp'] = $currentmodif;
    echo json_encode($response);
    flush();
      
    ?>