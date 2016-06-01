<?php

/**
* 
*/
class Request
{
    private $post;
    private $query;

    public function __construct()
    {
        $this->post = new Post();
        $this->query = new QueryString();
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
}