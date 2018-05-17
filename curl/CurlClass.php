<?php

class Curl
{
	function https_get($url)//自定义函数,访问url返回结果
	{
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($curl,  CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $data = curl_exec($curl);
	    if ($data === FALSE){
	        return 'ERROR: '.curl_error($curl);
	    }
	    curl_close($curl);
	    return $data;
	}

    function https_post($url, $post_data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        if ($output === FALSE){
            return 'ERROR: '.curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }

	function  https_request($url,$method='GET',$data=array()){
		$ch = curl_init();	 //1.初始化
		curl_setopt($ch,CURLOPT_URL, $url); //2.请求地址
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);//3.请求方式
		//4.参数如下	
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		
		if($method == "POST"){//5.post方式的时候添加数据	
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($ch);
		
		if ($output === FALSE) {
			return curl_error($ch);
		}
		curl_close($ch);
		return $output;
	}

	function curl_request($api, $method = 'GET', $params = array(), $headers = [])
    {
        $curl = curl_init();

        switch (strtoupper($method)) {
        case 'GET' :
            if (!empty($params)) {
                $api .= (strpos($api, '?') ? '&' : '?') . http_build_query($params);
            }
            curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
            break;
        case 'POST' :
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
        case 'PUT' :
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
        case 'DELETE' :
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
        }

        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, 0);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        if ($response === FALSE) {
            $error = curl_error($curl);
            curl_close($curl);
            return FALSE;
        }else{
            $response = json_decode($response, true);
        }

        curl_close($curl);

        return $response;
    }
}

//get请求
// $curl = new Curl();
// $url="http://192.168.188.193/curl_return.php";
// // $str=$curl->https_post($url, array('name' => 'name'));
// $str=$curl->https_request($url, 'POST', array('name' => 'name'));
// // echo file_get_contents($url);
// echo $str;