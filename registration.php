<?php

$fullname="N/A";
$phone="N/A";
$gender="N/A";
$age="N/A";
$district="N/A";

if(!empty($_POST) && !empty($_POST['phoneNumber'])){

require_once('database.php');

$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phone = $_POST["phoneNumber"];
$text = $_POST["text"];
$response="";

$textarry=explode("*", $text);
$userResponse=trim(end($textarry));

$level=0;
// Check if the user already exists in the database
$sql="SELECT * FROM users WHERE phone_number='$phone'";
$userResult=mysqli_query($connect, $sql);
$user = mysqli_num_rows($userResult);




if($user==0){
    $sqlInsert="INSERT INTO users VALUES (0,'$phone','$fullname','$gender','$age','$district',1)";
    $insertResult=mysqli_query($connect, $sqlInsert);
    $response  = "CON Welcome to Mlimi Digital\n";
    $response .= "Chonde lembani dzina lanu lonse\n";
    header('Content-type: text/plain');
    echo $response;
    // If user does not exist, insert them into the database
    
}
else{
    $sql="SELECT * FROM users WHERE phone_number='$phone'";
    $userResult=mysqli_query($connect, $sql);
    $user = mysqli_num_rows($userResult);
    $row=mysqli_fetch_row($userResult);
    $regLevel=$row[6]; //this is the level of the user during the registration
    $fullname=$row[2]; //this is the level of the user during the registration
    switch($regLevel){
        case 1:
            $updateUser="UPDATE users SET fullname='$userResponse', user_level=2 WHERE phone_number='$phone'";
            $insertResult=mysqli_query($connect, $updateUser);
            $response  = "CON Ndinu Mamuna kapena Mkazi?\n";
            header('Content-type: text/plain');
            echo $response;
        break;
        case 2:
            $updateUser="UPDATE users SET gender='$userResponse', user_level=3 WHERE phone_number='$phone'";
            $insertResult=mysqli_query($connect, $updateUser);
            $response  = "CON Muli ndizaka zingati?\n";
            header('Content-type: text/plain');
            echo $response; 
        break;
        case 3:
            $updateUser="UPDATE users SET age='$userResponse', user_level=4 WHERE phone_number='$phone'";
            $insertResult=mysqli_query($connect, $updateUser);
            $response  = "CON Muli m'dera liti?\n";
            header('Content-type: text/plain');
            echo $response;
        break;
        case 4:
            $updateUser="UPDATE users SET district='$userResponse', user_level=5 WHERE phone_number='$phone'";
            $insertResult=mysqli_query($connect, $updateUser);
            $response  = "CON $fullname Takhokoza polembetsa ku Mlimi Digital\n";
            header('Content-type: text/plain');
            echo $response;
        break;
        case 5:
            //the user is registered and can now access the services
            $sql="SELECT * FROM levels WHERE session_id='$sessionId'";
            $result=mysqli_query($connect, $sql);
            $rows = mysqli_num_rows($result);
            if ($rows > 0){
                $row=mysqli_fetch_row($result);
                $level=$row[3];
            }
                switch($userResponse){
                    case "":
                        if ($level == 0){
                            $sqlLevel="INSERT into levels VALUES(0,'$sessionId', '$phone', 1)";
                            $result=mysqli_query($connect, $sqlLevel);  
                            
                            if(!$result){
                                die("Unable to connect to MySQL: " . mysqli_error($connect));
                            }
                            
                            $response  = "CON Welcome $fullname to Mlimi Digital. Thandizo\n";
                            $response .= "1. Za Misika\n";
                            $response .= "2. Za Mankhwala\n";
                            $response .= "3. Za Za Mbeu\n";
                            $response .= "4. Za Za Ulimi Wakudimba\n";
                            header('Content-type: text/plain');
                            echo $response;	
                        }
                    break;
                    case "0":
                            if ($level == 1){
                                $sqlLevel="INSERT into levels VALUES(0,'$sessionId', '$phone', 1)";
                                $result=mysqli_query($connect, $sqlLevel);  
                                
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }
                                
                                $response  = "CON Welcome $fullname to Mlimi Digital. Thandizo\n";
                                $response .= "1. Za Misika\n";
                                $response .= "2. Za Mankhwala\n";
                                $response .= "3. Za Za Mbeu\n";
                                $response .= "4. Za Za Ulimi Wakudimba\n";
                                header('Content-type: text/plain');
                                echo $response;	
                            }
                            elseif ($level !=1 && $level !=0){
                                $updateLevel="UPDATE levels SET session_level=1 WHERE session_id='$sessionId'";
                                $result=mysqli_query($connect, $updateLevel);  
                                
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }   
                                
                                $response  = "CON Welcome $fullname to Mlimi Digital. Thandizo\n";
                                $response .= "1. Za Misika\n";
                                $response .= "2. Za Mankhwala\n";
                                $response .= "3. Za Za Mbeu\n";
                                $response .= "4. Za Za Ulimi Wakudimba\n";
                                $response  .= "0. Kuti mubwerere";
                                header('Content-type: text/plain');
                                echo $response;	
                            }
                    break;
                    case "1":
                        //while at level 1
                            if ($level == 1){
                                $response  = "CON Sankhani Msika omwe mufukufuna kudziwa\n";
                                $response  .= "1. Msika wa Soya\n";
                                $response .= "2. Msika wa Chimanga\n";
                                $response .= "3. Msika wa Mtenda\n";
                                $response .= "0. Kuti Mubwerere\n";

                                $updateLevel="UPDATE levels SET session_level=6 WHERE session_id='$sessionId'";
                                $result=mysqli_query($connect, $updateLevel);  
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }

                                header('Content-type: text/plain');
                                echo $response;	
                            }
                        //while at level 6
                            elseif($level == 6){
                                    $response  = "CON Soya tsopano akugulidwa pa Mtengo wa 500/kg kumalo awa";
                                    $response  .= "ACADES, Admarc, JTi, and NASFAM\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                        //while at level 7 Medication for Mbozi
                        elseif($level == 7){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa MBOZI ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            //while at level 8 Ulimi for SOYA
                        elseif($level == 8){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa SOYA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            elseif($level == 9){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa KUSAMALIRA KUDIMBA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }


                    break;
                    case "2":
                            if ($level == 1){

                                $response  = "CON Sankhani Mavuto\n";
                                $response  .= "1. Mankhwala a Mbozi\n";
                                $response .= "2. Mankhwala a Nankafumbwe\n";
                                $response .= "3. Chiswe\n";

                                $updateLevel="UPDATE levels SET session_level=7 WHERE session_id='$sessionId'";
                                $result=mysqli_query($connect, $updateLevel);  
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }

                                header('Content-type: text/plain');
                                echo $response;	
                            }
                            elseif($level == 6){
                                    $response  = "CON Chimanga tsopano chikugulidwa pa Mtengo wa 500/kg kumalo awa";
                                    $response  .= "ACADES, Admarc, JTi, and NASFAM\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            //while at level 7 Medication for Namkafumbwe
                            elseif($level == 7){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa NAMKAFUMBWE ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            //while at level 8 Ulimi for CHIMANGA
                        elseif($level == 8){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa CHIMANGA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            elseif($level == 9){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa FERTILIZER KUDIMBA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                        

                    break;
                    case "3":
                            if ($level == 1){
                                $response  = "CON Sankhani\n";
                                $response  .= "1. Soya\n";
                                $response .= "2. Chimanga\n";
                                $response .= "3. Mtenda\n";
                                $response .= "0. Kuti Mubwerere\n";

                                $updateLevel="UPDATE levels SET session_level=8 WHERE session_id='$sessionId'";
                                $result=mysqli_query($connect, $updateLevel);  
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }

                                header('Content-type: text/plain');
                                echo $response;	
                            }
                            elseif($level == 6){
                                    $response  = "CON Mtedza tsopano ukugulidwa pa Mtengo wa 500/kg kumalo awa";
                                    $response  .= "ACADES, Admarc, JTi, and NASFAM\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            //while at level 7 Medication for Chiswe
                            elseif($level == 7){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa CHISWE ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            //while at level 8 Ulimi for MTEDZA
                        elseif($level == 8){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa MTEDZA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            elseif($level == 9){
                                    $response  = "CON Onenetsani mukuthira mankhwa awa TIZILOMBO KUDIMBA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa,Onenetsani mukuthira mankhwa awa TIZILOMBO KUDIMBA ali munda mwanu. ndipo mukakolora,mupuntheni ndikuyika matumba mukatero ndikuthira mankhwala awa\n";
                                    $response  .= "0. Kuti mubwerere";
                                    header('Content-type: text/plain');
                                    echo $response;
                            }
                            
                    break;
                    case "4":
                            if ($level == 1){
                                $response  = "CON Uphungu wakudimba\n";
                                $response  .= "1. Kusamalira\n";
                                $response .= "2. Fertilizer\n";
                                $response .= "3. Tizilombo\n";
                                $response .= "0. Kuti Mubwerere\n";

                                $updateLevel="UPDATE levels SET session_level=9 WHERE session_id='$sessionId'";
                                $result=mysqli_query($connect, $updateLevel);  
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }

                                header('Content-type: text/plain');
                                echo $response;	
                            }
                    break;
                    default:
                        if($level==1){
                            // Return user to Main Menu & Demote user's level
                            $response = "CON You have to choose a service.\n";
                            $response .= "Press 0 to go back.\n";
                            $updateLevel="UPDATE levels SET session_level=0 WHERE session_id='$sessionId'";
                                $result=mysqli_query($connect, $updateLevel);  
                                if(!$result){
                                    die("Unable to connect to MySQL: " . mysqli_error($connect));
                                }
                            header('Content-type: text/plain');
                            echo $response;	
                        }
                    
                }

        break;
        default:
            $response  = "END $fullname Muli kale m'ndandanda wa Mlimi Digital\n";
            header('Content-type: text/plain');
            echo $response;
                    
    }
}

exit;
}
echo "Working";
?>
