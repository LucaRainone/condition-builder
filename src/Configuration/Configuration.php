<?php

namespace rain1\ConditionBuilder\Configuration;

class Configuration implements ConfigurationInterface {
    
    private $_placeholder = "?";

    public function getPlaceholder(): string
    {
        return $this->_placeholder;
    }

    public function setPlaceholder(string $placeholder)
    {
        $this->_placeholder = $placeholder;
    }

}