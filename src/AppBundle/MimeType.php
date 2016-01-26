<?php
namespace AppBundle;

class MimeType {
    
    
    
    public $type;
    
    public function __construct() {
        
        $this->type['TYPE_IMAGE'] = 'image';
        $this->type['TYPE_VIDEO'] = 'video';
    }
    
    
    public function getTypes()
    {
        
        return $this->type;
    }
}