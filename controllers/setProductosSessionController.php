<?php session_start();

header('Content-type:application/json; charset=utf8');
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['productos'])) {
    
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    if(!empty($_SESSION)){
        $productos = json_decode(stripslashes($_POST['productos'])); 
        if(isset($_SESSION['productos'])){
            if($_POST['action'] == 'get'){
                $productos = $_SESSION['productos'];
                if(empty($productos)){
                    $productos = json_decode($_COOKIE['productos']);
                }
            }else{                
                if(!empty(json_decode($_POST['productos']))){
                    $productos = json_decode(stripslashes($_POST['productos']));   
                }else{
                    $productos = array(); 
                }
            }
        }else{
            if(strtolower($_COOKIE['productos']) == 'null' || empty($_COOKIE['productos'])){
                $productos = []; 
            }else{
                $productos = json_decode($_COOKIE['productos']);
            }
        }
        $_SESSION['productos'] = $productos; 
    }else{  
        if($_POST['action'] == 'get'){
            if(isset($_COOKIE['productos'])){
                if(strtolower($_COOKIE['productos']) == 'null' || empty($_COOKIE['productos'])){
                    $productos = []; 
                }else{
                    $productos = json_decode($_COOKIE['productos']);
                }
            }

        }else{        
            $productos = json_decode(stripslashes($_POST['productos']));   
        }        
    }
    setcookie('productos', json_encode($productos), time() + 60 * 60 * 24 * 30, '/');      
    echo json_encode($productos);
    exit();
}
