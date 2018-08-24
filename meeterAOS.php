<?php
/*******************************************
 * meeterAOS.php
 * 
 * --------------------------------------
 * this is used for the core functionality
 * for the Areas of Service or otherwise
 * known as where you going to server.
 *****************************************/
 

class mAOS{

    function retreiveSetting($key){
        $config = array(
            'setup' => true,
            'tearDown' => true,
            'av' => true,
            'prayer' => true,
            'greeter' => true,
            'transportation' => true,
            'resources' => true,
            'newcomers' => true,
            'worship' => true,
            'meal' => true,
            'chips' => true,
            'specialEvents' => true,
            'smallGroup' => true,
            'stepStudy' => true,
            'youth' => true,
            'children' => true,
            'nursery' => true,
            'cafe' => true,
            'crim' => true,
            'criw' => true,
            'teaching' => true,
            'security' => true,
        );
        echo $config[$key];
        
    }

}
