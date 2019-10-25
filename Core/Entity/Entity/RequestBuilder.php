<?php

namespace Core\Entity\Entity;

class RequestBuilder
{
    /**
     * Crée un objet Request
     */
    public static function Create($core)
    {
    
        $Request = new Request($core);
        return $Request;
    }
}