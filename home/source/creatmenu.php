<?php
/** *     微信操作类 */
class WeixinOp {
    private $AppId;
    private $AppSecret;
    function __construct($AppId ='' ,$AppSecret ='' )
    {
        $this->AppId = $AppId ? $AppId :'';
        $this->AppSecret = $AppSecret ? $AppSecret :'';
    }
    //获取token（创建自定义菜单用）
    function getToken(){
        $url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->AppId}&secret={$this->AppSecret}";
        return $this->get($url);
    }
    //创建自定义菜单
    function creatMenu($menu_ary){
        foreach ($menu_ary['button'] as $key => $value) {
            if (count($value) == 2) {
                $menu_ary['button'][$key]['name'] = urlencode($value['name']);
                foreach ($value['sub_button'] as $key2 => $value2) {
                    $menu_ary['button'][$key]['sub_button'][$key2]['name'] = urlencode($value2['name']) ;
                }
            }
            elseif (count($value) == 3) {
                $menu_ary['button'][$key]['name'] = urlencode($value['name']) ;
            }
        }
        $str = urldecode(json_encode($menu_ary));
        $token_ary = $this->getToken();
        $token = $token_ary['access_token'];
        $url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";
        return $this-> post($url,$str);
    }
    //删除自定义菜单
    function deleteMenu(){
        $token_ary = $this->getToken();
        $token = $token_ary['access_token'];
        $url ="https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$token}";
        return $this-> get($url);
    }
    // get方法，供类内部方法使用
    protected function get($url){
        $curlObj = curl_init();    //初始化curl，
        curl_setopt($curlObj, CURLOPT_URL, $url);   //设置网址
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);  //将curl_exec的结果返回
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);         //是否输出返回头信息
        $response = curl_exec($curlObj);   //执行
        curl_close($curlObj);          //关闭会话
        return json_decode($response,true);
    }
    //post数据
    protected function post($url,$post_data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $response = curl_exec($curl);
        $result = json_decode($response,true);
        $error = curl_error($curl);
        return $error ? $error : $result;
    }
}
?>