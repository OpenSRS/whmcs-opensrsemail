<?php
class openSRS_mail {
	
	protected $username;
	
	protected $password;
	
	protected $domain;
	
	protected $cluster;
	
	protected $mode;

	public function createDomain($domain, $create = true,$timezone = null, $language = null, $filtermx = null, $spamTag = null, $spamFolder = null, $spamLevel = null) {
        
        /* 16/05/2015 : Array object to create domain (For new api) */
        $compile = array("attributes"=>new ArrayObject(),"domain"=>$domain,"create_only"=>$create,"credentials"=>array("user"=>$this->username,"password"=>$this->password));
        
        /* Check if domain already exists */
        $getParams = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"domain"=>$domain);   
        $result =  $this->_processRequest ("get_domain", $getParams);  
        if(!$result["is_success"])
        {
		    return $this->_processRequest ("change_domain", $compile);
        }
        else
        {
            $result=Array(
            "is_success" => "0",
            "response_code" => "7",
            "response_text" => "This domain already exists."
            );
            return $result;
        }
        /* END */
	}

	public function disableDomain($domain) {        
        /* 16/05/2015 : Array object to suspend domain (For new api) */
        $compile = array("attributes"=>array("disabled"=>true),"domain"=>$domain,"credentials"=>array("user"=>$this->username,"password"=>$this->password));
		
		return $this->_processRequest ("change_domain", $compile);
        /* END */
	}
	
	public function enableDomain($domain) {       
        /* 16/05/2015 : Array object to unsuspend domain (For new api) */
        $compile = array("attributes"=>array("disabled"=>false),"domain"=>$domain,"credentials"=>array("user"=>$this->username,"password"=>$this->password));
		
		return $this->_processRequest ("change_domain", $compile);
        /* END */
	}

	public function deleteDomain($domain) {       
        /* 16/05/2015 : Array object to delete domain (For new api) */
		$compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"domain"=>$domain);
		return $this->_processRequest ("delete_domain", $compile);
        /* END */
	}

	public function getDomainMailboxes($domain) {       
        /* 27/05/2015 : Array object to Get Mailbox (For new api) */
		$compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"criteria"=>array("domain"=>$domain));
        $response = $this->_processRequest ("search_users", $compile);
        $result["is_success"]    =  $response["is_success"];
        $result["response_code"] =  $response["response_code"];
        $result["response_text"] =  $response["response_text"];
        
        $users =  json_decode(json_encode($response['response']['users']), true);
        for($j=0;$j<count($users);$j++)
        {    
            $user = array("mailbox"=>$users[$j]['user'],"type"=>$users[$j]['type'],"workgroup"=>$users[$j]['workgroup']);
            $result["attributes"]["list"][] = $user;
        }
       
        return $result;
        /* END */
	}

	public function getNumDomainMailboxes($domain) {
         /* 27/05/2015 : Array object to Get Mailbox Count (For new api) */
        $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"criteria"=>array("domain"=>$domain));
        
		$response = $this->_processRequest ("search_users", $compile);
        $result["is_success"]    =  $response["is_success"];
        $result["response_code"] =  $response["response_code"];
        $result["response_text"] =  $response["response_text"];
        
        $users =  json_decode(json_encode($response['response']['users']), true);
        
        $result["attributes"]["mailbox"] = 0;
        $result["attributes"]["forward"] = 0;
        $result["attributes"]["filter"]  = 0;
        for($j=0;$j<count($users);$j++)
        {    
            if($users[$j]['type'] == 'mailbox')
               $result["attributes"]["mailbox"] += 1;
            elseif($users[$j]['type'] == 'forward')
               $result["attributes"]["forward"] += 1;
            elseif($users[$j]['type'] == 'filter')
               $result["attributes"]["filter"] += 1;
        }
       
        return $result;
	}

	public function getDomainWorkgroups($domain) {        
         /* 26/05/2015 - Get Workgroups by Domain name */
        $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"criteria"=>array("domain"=>$domain)); 
      
        
		$response = $this->_processRequest ("search_workgroups", $compile);
        $result["is_success"]    =  $response["is_success"];
        $result["response_code"] =  $response["response_code"];
        $result["response_text"] =  $response["response_text"];
        $result["attributes"]["list"] =  array();
        
        $workgroups =  json_decode(json_encode($response['response']['workgroups']), true);

        for($j=0;$j<$response['response']['total_count'];$j++)
        {    
            $counts = array("workgroup"=>$workgroups[$j]['workgroup'],"mailbox_count"=>$workgroups[$j]['counts']['mailbox'],"forward_count"=>$workgroups[$j]['counts']['forward'],"alias_count"=>$workgroups[$j]['counts']['filter']);
            $result["attributes"]["list"][] = $counts;
        }
        return $result;
        /* END */
	}
	
	public function getMailbox($domain, $mailbox) {	
		 /* 26/05/2015 - Get Workgroups by Domain name */
        $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"user"=>$mailbox); 
        $response = $this->_processRequest ("get_user", $compile);
        
        $result["is_success"]    =  $response["is_success"];
        $result["response_code"] =  $response["response_code"];
        $result["response_text"] =  $response["response_text"];
        
        $user = json_decode(json_encode($response["response"]["attributes"]), true);
        $result["attributes"]    =  array("mailbox"=>$user["account"],"first_name"=>strtok($user["name"]," "),"title"=>$user["title"],"last_name"=>substr($user["name"], strpos($user["name"], " ") + 1),"phone"=>$user["phone"],"fax"=>$user["fax"]);
        
        return $result;
        /* END */
	}
	
	public function createMailbox($domain, $mailbox, $password, $firstName, $lastName, $title, $phone, $fax, $type) {
       $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"create_only"=>true,"user"=>$mailbox,"attributes"=>array("fax"=>$fax,"name"=>$firstName." ".$lastName,"password"=>$password,"phone"=>$phone,"type"=>$type,"title"=>$title));  
       return $this->_processRequest("change_user", $compile); 
	}
	
	public function changeMailbox($domain, $mailbox,$password, $firstName, $lastName, $title, $phone, $fax, $type) {
       if(!empty($password))
         $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"user"=>$mailbox,"attributes"=>array("fax"=>$fax,"name"=>$firstName." ".$lastName,"password"=>$password,"phone"=>$phone,"type"=>$type,"title"=>$title));  
       else
         $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"user"=>$mailbox,"attributes"=>array("fax"=>$fax,"name"=>$firstName." ".$lastName,"phone"=>$phone,"type"=>$type,"title"=>$title));    
       return $this->_processRequest("change_user", $compile); 
	}
	
	public function getMailboxForwardOnly($domain, $mailbox) {
		$compile = " domain=\"".$domain."\"";
		$compile .= " mailbox=\"".$mailbox."\"";
		
		return $this->_processRequest("get_mailbox_forward_only", $compile);
	}
	
	public function createMailboxForwardOnly($domain, $mailbox, $forwardEmails, $type) {
       $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"create_only"=>true,"user"=>$mailbox,"attributes"=>array("delivery_forward"=>true,"type"=>$type,"forward_recipients"=>$forwardEmails));  
       return $this->_processRequest("change_user", $compile); 
	}
	
	public function changeMailboxForwardOnly($domain, $mailbox, $forwardEmails, $type) {

       $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"user"=>$mailbox,"attributes"=>array("delivery_forward"=>true,"type"=>$type,"forward_recipients"=>$forwardEmails));  
       return $this->_processRequest("change_user", $compile); 
	}
	
	public function createAliasMailbox($domain, $alias, $mailbox) {
        $aliasEmails = explode(',',$alias); 
        $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"user"=>$mailbox,"attributes"=>array("aliases"=>$aliasEmails));  
        return $this->_processRequest("change_user", $compile);
	}
	
	public function deleteMailboxAny($domain, $mailbox) {
        $compile = array("credentials"=>array("user"=>$this->username,"password"=>$this->password),"user"=>$mailbox);
        return $this->_processRequest("delete_user", $compile);
	}
	
	public function createWorkgroup($domain, $workgroup) {
        
         $result=Array(
            "is_success" => "0",
            "response_code" => "2",
            "response_text" => "Managing Workgroups is not supported with this module.",
        );
        return $result;
	}
	
	public function deleteWorkgroup($domain, $workgroup) {        
         $result=Array(
            "is_success" => "0",
            "response_code" => "2",
            "response_text" => "Managing Workgroups is not supported with this module.",
        );
        return $result;
	}

	// Post validation functions
	private function _processRequest($method, $command = ""){       
        /* 16/05/2015 - Added one array element to pass array for spcific methods*/
        $sequence = array (
            0 => "ver ver=\"3.5\"",
            1 => "login user=\"". $this->username ."\" domain=\"". $this->domain ."\" password=\"". $this->password ."\"",
            2 => $method,
            3 => $command,
            4 => "quit"
        );
        /* END */	

		$tucRes = $this->makeCall($sequence);
		return $this->parseResults35($tucRes);
	}
	
	// Class constructor
    /*public function __construct ($username, $password, $domain, $cluster, $mode) {*/
	public function __construct ($username, $password, $cluster) {
		$this->username = $username;
		$this->password = $password;
        
        if (($pos = strpos($username, "@")) !== FALSE) { 
            $domain = substr($username, $pos+1); 
            $this->domain   = $domain; 
        } 
		$this->cluster  = strtolower($cluster);
		/*$this->mode   = strtolower($mode); */
	}

	// Class destructor
	public function __destruct () {
	}

	// Class functions
	protected function makeCall ($sequence){
        /* 16/05/2015 - New API Calls */
		$result = '';
        $url = 'https://admin.'.$this->cluster.'.hostedemail.com/api/'.$sequence[2];

        $data_string = json_encode($sequence[3]) ;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string))); 
 
        $response = curl_exec($ch);
        $getInfo = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($getInfo >= '200' && $getInfo <= '206' )
        {
            $result = $response;
        }
        else
        {
            throw new Exception("Error connecting to OpenSRS");
        }
        
        /* END */
		return $result;
	}

	protected function parseResults35 ($resString) {
		// Raw tucows result
		$resArray = (array) json_decode($resString);
        $result=Array(
            "is_success" => "1",
            "response_code" => "200",
            "response_text" => "Command completed successfully",
            "response" => $resArray
        );
        
        if ($resArray['success']=="0" && isset($resArray['success']))
        {
            $result['response_text']=$resArray['error'];    
            $result['response_code']=$resArray['error_number'];
            $result['is_success']='0';
        }
		return $result;
	}
}
?>