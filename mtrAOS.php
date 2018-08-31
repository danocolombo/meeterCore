<?php
/* ------------------------------------------------
 *  mtrAOS.php
 *  
 *  1.0 read from database table Meeter the AOS value
 *       this was merely key:value definition
 *       
 *   1.1 this update gets the data as before, but now the
 *        values are extended to provide display info
 *        key:value#displayValue
 *  
 */

class mConfig{
    public $AOS = array();      //system values
    public $peepAOS = array();  //user values
    
//     public function getConfig($setting){
//         if(array_key_exists($setting, $this->AOS)){
//             return $this->AOS[$setting];
//         }else{
//             echo "NO, we don\'t have " . $setting . "<br/>";
//             return false;
//         }
//     }
    public function showConfig(){
        foreach($this->AOS as $key => $value){
            echo "$value : $value<br/>";
        }
    }

    public function doesSettingExist($s){
        if(array_key_exists($s, $this->AOS)){
            return true;
        }else{
            return false;
        }
    }
//     public function doesPeepSettingExist($s){
//         if(array_key_exists($s, $this->peepAOS)){
//             return true;
//         }else{
//             return false;
//         }
//     }
    
    public function setConfigToFalse($s){
        // get current value
        $parts = explode("#", $this->AOS[$s]);
        $newValue = "false#" . $parts[1];
        $this->AOS[$s] = $newValue;
    }
    public function setConfigToTrue($s){
        // get current value
        $parts = explode("#", $this->AOS[$s]);
        $newValue = "true#" . $parts[1]; 
        $this->AOS[$s] = $newValue;
    }
    public function canVolunteer($k){
        // we have the special feature that if displayvalue is NOSHOW return false
        $parts = explode("#", $this->AOS[$k]);
        if($parts[1] == "NOSHOW"){
            return false;
        }else{
            return true;
        }
        
        
    }
    
//     public function addConfig($s, $v){
//         $this->AOS[$s] = $v;
//     }
    
    public function setDisplayString($k, $s){
        //get the current config setting
        $parts = explode("#", $this->AOS[$k]);
        $newValue = $parts[0] . "#$s";
        $this->AOS[$k] = $newValue;
    }
    
    public function getConfig($k){
        //this will return the display string from the array...
        // xxxx:yyyy#zzz
        // xxx = key
        // yyy = value
        // zzz = display string
        $tmp = explode("#", $this->AOS[$k]);
        // =====
        // 0 = value
        // 1 = display value
//         echo "\$tmp[0] = $tmp[0]<br/>";
//         echo "\$tmp[1] = $tmp[1]<br/>";
        return $tmp[0];
    }
    public function getDisplayString($k){
        //this will return the display string from the array...
        // xxxx:yyyy#zzz
        // xxx = key
        // yyy = value
        // zzz = display string
        
        $tmp = explode("#", $this->AOS[$k]);
        // ===== 
        // 0 = value
        // 1 = display value
//         echo "\$tmp[0] = $tmp[0]<br/>";
//         echo "\$tmp[1] = $tmp[1]<br/>";
        return $tmp[1];
    }
    public function loadConfigFromDB(){
        //===========================================================================
        // this routine opens up the meeter system table and gets the AOS value, 
        // which is the confurationo of the current application.
        //===========================================================================
        $systemAOS = "";     
        if ( isset( $connection ) ) return;
        
        mysqli_report(MYSQLI_REPORT_STRICT);
        
        define('DB_HOST', 'localhost');
        define('DB_USER', 'dcolombo_muat');
        define('DB_PASSWORD', 'MR0mans1212!');
        define('DB_NAME', 'dcolombo_muat');
        $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        
        $sql = "SELECT AOS FROM Meeter";
        $result = $connection->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $systemAOS =  $row["AOS"];
            }
        } else {
            echo "0 results";
        }
        $connection->close();
        unset($this->AOS);
        $this->AOS = array();
 
        $ref = explode("|", $systemAOS);
        for($il = 0; $il< sizeof($ref); $il++){
            $pair = explode(":", $ref[$il]);
            $this->AOS[$pair[0]] = $pair[1];
        }
    }

    

    public function saveConfigToDB(){
        $newConfig = "";
        foreach($this->AOS as $key => $value){
            $newConfig = $newConfig . $key . ":" . $value . "|";
        }
        $newConfig = chop($newConfig,"|");
        try {
            define('DB_HOST', 'localhost');
            define('DB_USER', 'dcolombo_muat');
            define('DB_PASSWORD', 'MR0mans1212!');
            define('DB_NAME', 'dcolombo_muat');
            $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            $stmt = $connection->prepare("UPDATE Meeter SET AOS = ?");
            $stmt->bind_param("s", $newConfig);
            $stmt->execute();
            $stmt->close();
        } catch (PDOException $e) {
            echo "Error: [mtrAOS.php_saveConfigToDB()] " . $e->getMessage();
        }
        $connection = null;
    }
}
$aosConfig = new mConfig();