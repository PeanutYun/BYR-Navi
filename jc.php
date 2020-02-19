<?php
    $time = time();
    $orderno = 'ZF20187190338W796mQ';
    $secret = '682a82794219454d8c71253d04caba71';

    $planText="orderno=".$orderno.",secret=".$secret.",timestamp=".$time;
    $sign = strtoupper(md5($planText));
    $auth = 'sign='.$sign.'&orderno='.$orderno.'&timestamp='.$time;
    $url = 'https://api.m.jd.com/client.action?functionId=vvipclub_home_index&body=%7B%22paramData%22%3A%7B%22clientType%22%3A1%7D%2C%22v%22%3A%225.0%22%2C%22apiType%22%3A%22h5%22%7D&appid=aries_m_h5';
    $ch = curl_init();
    // 设置浏览器的特定header
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Proxy-Authorization:".$auth,
        'Cookie:'.$_GET["Cookie"],
        ));
    
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_PROXY, "forward.xdaili.cn:80"); 
    curl_setopt($ch, CURLOPT_TIMEOUT,240);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,6);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $text = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($text,false);
    if ($text=="")
    {
        echo '讯代理网络错误，请重试';
    }
    elseif ($json->data[1]->dataDetail->vipUserInfo->riskScore==1)
    {
        echo '黑，不能参加活动，不能领卷';
    }
    elseif ($json->data[1]->dataDetail->vipUserInfo->riskScore==2)
    {
        echo '半黑，不能参加活动，能领卷';
    }
    elseif ($json->data[1]->dataDetail->vipUserInfo->riskScore>=3)
    {
        echo '白，能参加活动，能领卷';
    }
    else
    {
        echo 'Cookie无效或国外号，不支持检测';
    }
?>