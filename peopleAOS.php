<?php
/*=============================================
 * peopleAOS.php
 * --------------------------------------------
 * leveraged from mtrAOS which is used for the
 * system settings. This is used to manage the
 * areas a person serves/volunteers in.
 * 
 * configururation string is stored in people 
 * table in column AOS
 */

class mConfig{
    public $AOS = array();      //user values
    public $systemAOS = array(); // system AOS values;
    public $displayAOS = array();
    
    public function getConfig($setting){
        if(array_key_exists($setting, $this->AOS)){
            return $this->AOS[$setting];
        }else{
//             echo "NO, we don\'t have " . $setting . "<br/>";
            return false;
        }
    }
    public function showConfig(){
        var_dump($this->AOS);
    }

    public function doesSettingExist($s){
        if(array_key_exists($s, $this->AOS)){
            return true;
        }else{
            return false;
        }
    }
    
    public function setConfigToFalse($s){
        $this->AOS[$s] = "false";
    }
    
    public function setConfigToTrue($s){
        $this->AOS[$s] = "true";
    }
    
    public function addConfig($s, $v){
        $this->AOS[$s] = $v;
    }
    
    public function loadSystemConfigFromDB(){
        //===========================================================================
        // this routine opens up the meeter system table and gets the AOS value, 
        // which is the confurationo of the current application.
        //===========================================================================
        $newAOS = "";     
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
                $newAOS =  $row["AOS"];
            }
        } else {
            echo "0 results";
        }
        $connection->close();
        unset($this->systemAOS);
        $this->systemAOS = array();
 
        $ref = explode("|", $newAOS);
        for($il = 0; $il< sizeof($ref); $il++){
            $pair = explode(":", $ref[$il]);
            $this->systemAOS[$pair[0]] = $pair[1];
        }
    }
    public function loadConfigFromDB($PID){
        //===========================================================================
        // this routine opens up the people table and gets the AOS value,
        // which is the settings for the user.
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
        
        $sql = "SELECT AOS FROM people WHERE ID = " . $PID;
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

    public function saveConfigToDB($PID){
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
        
            $stmt = $connection->prepare("UPDATE people SET AOS = ? WHERE ID = ?");
            $stmt->bind_param("ss", $newConfig, $PID);
            $stmt->execute();
            $stmt->close();
        } catch (PDOException $e) {
            echo "Error: [mtrAOS.php_saveConfigToDB()] " . $e->getMessage();
        }
        $connection = null;
    }
    public function showAllAOSValues($PID){
        // load system and people AOS, display both
        //================================================
//         $this->loadConfigFromDB($PID);
//         $this->loadSystemConfigFromDB();
        echo "<br/>\$PID: $PID";
        echo "<br/>\$AOS:<br/>";
        echo "==========================<br/>";
        if(count($this->AOS)>0){
            foreach($this->AOS as $key => $value){
//                 $newConfig = $newConfig . $key . ":" . $value . "|";
                echo "$key : $value <br/>";
            }
        }else{
            echo "no settings for user<br/>";
        }
        //now show both AOS arrays:
        echo "<br/>\$systemAOS:<br/>";
        echo "==========================<br/>";
        if(count($this->systemAOS)>0){
            foreach($this->systemAOS as $key => $value){
                //                 $newConfig = $newConfig . $key . ":" . $value . "|";
                echo "$key : $value <br/>";
            }
        }else{
            echo "no settings for system<br/>";
        }
        //now show displayAOS
        echo "<br/>\$displayAOS:<br/>";
        echo "==========================<br/>";
        if(count($this->displayAOS)>0){
            foreach($this->displayAOS as $key => $value){
                //                 $newConfig = $newConfig . $key . ":" . $value . "|";
                echo "$key : $value <br/>";
            }
        }else{
            echo "no settings for system<br/>";
        }
        
    }
    public function loadDisplayAOS($PID){
        //get the latest AOS for the user...
        $this->loadConfigFromDB($PID);
        //get the lastest syste AOS
        $this->loadSystemConfigFromDB();
        if(count($this->AOS)<1){
            //just load the display with the system AOS and set values ot false
            foreach($this->systemAOS as $key => $value){
                if($value == "true"){
                    //the admin wants to manage this value
                    $this->displayAOS[$key] = "false";
                }
            }
        }else{
            //there is personal AOS information. For each personal AOS
            //value in the system AOS, set the display value to true
            foreach($this->systemAOS as $key => $value){
                //all values in personal AOS indicate true, so if the
                //system AOS is in the personal AOS, set the displayAOS
                //to true
                if($value == "true"){
                    if ($this->doesSettingExist($key)){
                        $this->displayAOS[$key] = "true";
                    }else{
                            $this->displayAOS[$key] = "false";
                    }
                }
            }
        }
    }
}
$aosPeepConfig = new mConfig();