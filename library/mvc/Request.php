<?php

/**
* 
*/
class Request
{
    // POST
    private $post;
    // GET
    private $query;
    // URL
    private $param;

    public function __construct()
    {
        $this->post = new Post();
        $this->query = new QueryString();
        $this->param = new UrlParameter();
    }

    private function _request($request, $key = null)
    {
        if (null == $key) {
            return $request->get();
        }
        if (false == $request->has($key)) {
            return null;
        }
        return $request->get($key);
    }

    public function getPost($key = null) {
        return $this->_request($this->post, $key);
    }
    public function getQuery($key = null) {
        return $this->_request($this->query, $key);
    }
    public function getParam($key = null){
        return $this->_request($this->param, $key);
    }
}