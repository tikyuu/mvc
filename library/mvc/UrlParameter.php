<?php
/**
* 
*/
class UrlParameter extends RequestVariables
{
    protected function setValues()
    {
        /*
         * ?のget削除。先頭の/と末尾の/削除
        */
        $param = mb_substr($_SERVER['REQUEST_URI'], 0, strcspn($_SERVER['REQUEST_URI'], '?'));
        $param = ereg_replace('/?$', '', $param);
        $param = ereg_replace('^/', '', $param);
        // $param = ereg_replace('/?$', '', $_GET['param']);
        
        $params = array();
        if ('' != $param) {
            // パラメータを / で分割
            $params = explode('/', $param);
        }

        // 2番目以降のパラメータを順に_valuesに格納
        $len = count($params);
        if (2 < $len) {
            for ($i = 0, $l = $len - 2; $i < $l; ++$i)
            {
                $this->_values[$i] = $params[$i + 2];
            }
        }

    }
}

