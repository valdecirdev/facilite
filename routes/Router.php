<?php

namespace routes;

class Router
{
    private $path = __DIR__.DS.'..'.DS.'resources'.DS.'view'.DS;
    private $prefix = array();
    private $route = array();

    public function set($prefix, $name)
    {
        array_push($this->prefix, $prefix);
        array_push($this->route, $name);
    }

    public function getView($name)
    {
        foreach ($this->prefix as $key => $value) {
            if($name == $this->prefix[$key]){
                $uri = $this->path.$this->route[$key];
                return $uri;
            }
        }

        $uri = $this->path.'profile.php';
        return $uri;

    }
}