<?php

class Rcon
{
                //var $challenge_number;
                var $connected;
                var $server_ip;
                var $server_password;
                var $server_port;
                var $socket;

                //Constructor
                function __construct()
                {
                                //$this->challenge_number = 0;
                                $this->connected       = true;
                                $this->server_ip       = "";
                                $this->server_port     = "";
                                $this->server_password = "";
                }
                //Open socket to gameserver

                function Connect($server_ip, $server_port, $server_password = "")
                {
                                //store server data
                                $this->server_ip       = gethostbyname($server_ip);
                                $this->server_port     = $server_port;
                                $this->server_password = $server_password;
                                //open connection to gameserver
                                $fp                    = fsockopen("udp://" . $this->server_ip, $this->server_port, $errno, $errstr, 2);
                                stream_set_timeout($fp, 2);
                                if ($fp)
                                                $this->connected = true;
                                else {
                                                $this->connected = false;
                                                return false;
                                }
                                //store socket
                                $this->socket = $fp;
                                //return success
                                return true;
                } //function Connect($server_ip, $server_port, $server_password = "")

                //Close socket to gameserver
                function Disconnect()
                {
                                //close socket
                                @fclose($this->socket);
                                $connected = false;
                } //function Disconnect()

                //Is there an open connection
                function IsConnected()
                {
                                return $this->connected;
                } //function IsConnected()

                public function GetCvar($cvarname)
                {
                                if (!$this->connected)
                                                return $this->connected;
                                if ($cvarname == "")
                                                return ""; // Cvar adı boş ise boş yanıt döndür.
                                $response    = $this->RconCommand($cvarname);
                                $originalcvar = substr($response, 0, (stripos($response, ":") +2));
                                $value    = str_replace($originalcvar, '', $response);

                                if (strpos($value, '(')) {
                                        return substr($value, 0, strpos($value, '('));;
                                }
                                else {
                                        return $value;
                                }

                }

                //Get detailed player info via rcon
                function ServerInfo()
                {
                                $command  = "\xff\xff\xff\xffnetinfo 49 0 4";
                                $buffer   = $this->Communicate($command);
                                //If there is no open connection return false
                                if (!$this->connected)
                                                return $this->connected;

                                if (trim($buffer) == "") {
                                                $this->connected = false;
                                                return false;
                                }
                                //get server information on netinfo
                                $serverinfo         = explode("\x5c", substr(substr(trim($buffer), 14), 8));
				$result       = [];

				switch($serverinfo['2']) {

					case "cstrike":
						// $game = "Counter-Strike";
                                                $game = "反恐精英";
						break;

                        	        case "valve":
                                	        // $game = "Half-Life";
                                                $game = "半条命";
                                        	break;

                                	case "dmc":
                                        	$game = "Deatmatch Classic";
                                        	break;

                                	case "tfc":
                                        	$game = "Team Fortress: Classic";
                                        	break;

	                                case "ricochet":
        	                                $game = "Ricochet";
                	                        break;
					}
                                //服务器状态存入变量
                                $result["ip"]            = $this->server_ip;
                                $result["port"]          = $this->server_port;
                                $result["name"]          = $serverinfo['0'];
                                $result["map"]           = $serverinfo['8'];
                                $result["mod"]           = $serverinfo['2'];
                                $result["game"]          = $game;
                                $result["activeplayers"] = $serverinfo['4'];
                                $result["maxplayers"]    = $serverinfo['6'];
                                $result["password"]      = $serverinfo['10'];
                                // 发送json格式数据
                                echo json_encode($result);
                                //return formatted result
                                return $result;
                } //function ServerInfo()


                //Get all maps in all directories
                function ServerMaps($pagenumber = 0)
                {
                                //If there is no open connection return false
                                if (!$this->connected)
                                                return $this->connected;
                                //Get list of maps
                                $maps = $this->RconCommand("maps *");
                                //If there is no open connection return false
                                //If there is bad rcon password return "Bad rcon_password."
                                if (!$maps || trim($maps) == "Bad rcon_password.")
                                                return $maps;
                                //Split Maplist in rows
                                $line  = explode("\n", $maps);
                                $count = sizeof($line) - 4;

                                //format maps
                                for ($i = 0; $i <= $count; $i++) {
					$text = $line[$i];
					if (substr($text, -4, 4) == ".bsp") {
						$result[$i] = str_replace(".bsp", "", $text);
					}
                                } //for($i = 1; $i <= $count; $i++)
                                //return formatted result
                                return $result;
                } //function ServerMaps()
                //通过信息协议获取服务器信息

                function Info()
                {
                                //If there is no open connection return false
                                if (!$this->connected)
                                                return $this->connected;
                                //send info command
                                $command = "\xff\xff\xff\xffTSource";
                                $buffer  = $this->Communicate($command);
                                //If no connection is open
                                if (trim($buffer) == "") {
                                                $this->connected = false;
                                                return false;
                                }
                                //build info array
				$result			 = [];
                                $pos                     = 0;
                                $result["type"]          = $this->parse_buffer($buffer, $pos, "bytestr");
                                $result["version"]       = $this->parse_buffer($buffer, $pos, "byte");
                                $result["name"]          = $this->parse_buffer($buffer, $pos, "string");
                                $result["map"]           = $this->parse_buffer($buffer, $pos, "string");
                                $result["mod"]           = $this->parse_buffer($buffer, $pos, "string");
                                $result["game"]          = $this->parse_buffer($buffer, $pos, "string");
                                $result["appid"]         = $this->parse_buffer($buffer, $pos, "short");
                                $result["activeplayers"] = $this->parse_buffer($buffer, $pos, "byte");
                                $result["maxplayers"]    = $this->parse_buffer($buffer, $pos, "byte");
                                $result["botplayers"]    = $this->parse_buffer($buffer, $pos, "byte");
                                $result["dedicated"]     = $this->parse_buffer($buffer, $pos, "bytestr");
                                $result["os"]            = $this->parse_buffer($buffer, $pos, "bytestr");
                                $result["password"]      = $this->parse_buffer($buffer, $pos, "byte");
                                $result["secure"]        = $this->parse_buffer($buffer, $pos, "byte");
                                //return formatted result
                                return $result;
                } //function Info()

                function parse_buffer($buffer, &$pos, $type)
                {
				$result = "";
                                switch ($type) {
                                                case 'string':
                                                                while (substr($buffer, $pos, 1) !== "\x00") {
                                                                                $result .= substr($buffer, $pos, 1);
                                                                                $pos++;
                                                                }
                                                                break;
                                                case 'short':
                                                                $result = ord(substr($buffer, $pos, 1)) + (ord(substr($buffer, $pos + 1, 1)) << 8);
                                                                $pos++;
                                                                break;
                                                case 'long':
                                                                $result = ord($buffer[$pos]) + (ord($buffer[$pos + 1]) << 8) + (ord($buffer[$pos + 2]) << 16) + (ord($buffer[$pos + 3]) << 24);
                                                                $pos += 3;
                                                                break;
                                                case 'byte':
                                                                $result = ord(substr($buffer, $pos, 1));
                                                                break;
                                                case 'bytestr':
                                                                $result = substr($buffer, $pos, 1);
                                                                break;
                                                case 'float':
                                                                $tmptime = @unpack('ftime', substr($buffer, $pos, 4));
                                                                $result  = date('H:i:s', round($tmptime['time'], 0) + 82800);
                                                                $pos += 3;
                                                                break;
                                }
                                $pos++;
                                return $result;
                }

                //通过信息协议获取玩家
                function Players()
                {
                                //get players online
                                $server = new Rcon();
                                $server->Connect("$this->server_ip", "$this->server_port", "$this->server_password");
                                $serverinfo = $server->ServerInfo();
                                $result = [];

				//If there is no open connection return false
                                if (!$this->connected)
                                                return $this->connected;

                                //send players command
                                $command = "\xff\xff\xff\xffnetinfo 49 0 3";
                                $buffer  = $this->Communicate($command);

                                //If there is no open connection return false
                                if (trim($buffer) == "") {
                                                $this->connected = false;
                                                return false;
                                }
				$maxplayers = $serverinfo['activeplayers'];
				$players = array_chunk(explode("\x5c", trim(substr($buffer, 14))), 4);
                               for ($i = 0; $i < $maxplayers; $i++) {
                                                $result[$i]["index"] = $players[$i][3];
                                                $result[$i]["name"]  = $players[$i][0];
                                                $result[$i]["frag"]  = $players[$i][1];
                                                $result[$i]["time"]  = $players[$i][2];
                                }
                                return $result;
                } //function Players()

                function RconCommand($rconcommand, $pagenumber = 0, $single = true)
                {
                                $command = "\xff\xff\xff\xffrcon $this->server_password $rconcommand\n";

                                //If there is no open connection return false
                                if (!$this->connected)
                                                return $this->connected;
                                //write command on socket
                                if ($command != "")
                                                fputs($this->socket, $command, strlen($command));
                                //get results from server
                                $buffer = fread($this->socket, 1);
                                $status = socket_get_status($this->socket);

                                if ($status["unread_bytes"] > 0) {
                                        $buffer .= fread($this->socket, $status["unread_bytes"]);
					if (substr($buffer, -6, 6) == "print\n") {
						return;
					}

                                        while(true) {
                                                $buffer .= fread($this->socket, 128);
                                                if (substr($buffer, -6, 6) == "print\n") {
							$result = str_replace("\xff\xff\xff\xffprint\n", "", $buffer);
                                                        return $result;
                                                }
                                        }
                                }
                }

                //Communication between PHPrcon and the Gameserver
                function Communicate($command)
                {
                                //If there is no open connection return false
                                if (!$this->connected)
                                                return $this->connected;
                                //write command on socket
                                if ($command != "")
                                                fputs($this->socket, $command, strlen($command));
                                //get results from server
                                $buffer = fread($this->socket, 1);
                                $status = socket_get_status($this->socket);

                               // Sander's fix:
                                if ($status["unread_bytes"] > 0) {
					$buffer .= fread($this->socket, $status["unread_bytes"]);
                                }

                                $bufferret = substr($buffer, 4);
                                //return complete package including the type byte
                                return $bufferret;
                } //function Communicate($buffer)
}
?>