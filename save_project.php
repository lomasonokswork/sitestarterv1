<?php
session_start();
if (!isset($_SESSION['user_id'])) { echo json_encode(['success'=>false,'message'=>'Please login first']); exit; }
$projectName=$_POST['project_name']??''; $action=$_POST['action']??'save';
if (empty($projectName)) { echo json_encode(['success'=>false,'message'=>'Invalid project']); exit; }
$userId=$_SESSION['user_id'];$saveFile="saves/user_{$userId}.json";
if(!file_exists('saves')) mkdir('saves',0777,true);
$saves=file_exists($saveFile)?(json_decode(file_get_contents($saveFile),true)??[]):[];
if($action==='save'){if(!in_array($projectName,$saves)){$saves[]=$projectName;file_put_contents($saveFile,json_encode($saves));echo json_encode(['success'=>true,'message'=>'Project saved!']);}else echo json_encode(['success'=>false,'message'=>'Already saved']);}
else{$saves=array_values(array_diff($saves,[$projectName]));file_put_contents($saveFile,json_encode($saves));echo json_encode(['success'=>true,'message'=>'Project removed']);}
?>
