<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Orphanage extends Controller
{
    //
   public $newname;


    function isPresent($str, $sub){
        if (stristr($str, $sub)){
            $this->comp = true;
            return $this->comp;
        }
        else{
            $this->comp = false;
            return $this->comp;
        }
    }

    public function upload(string $name, $dir, bool $create_dir_if_not_exists,  array $extensions, int $size){
        if(empty($name)){
            echo 'empty name parameter';
            exit;
        }
        $filename = basename($_FILES[$name]['name']);
        $this->isPresent($filename, 'php');
        if ($this->comp == true){
            echo '<br>file name is unacceptable'; exit;
        }
        //the third parameter 'create_dir_if_not_exists', take either true or false
        //if true a directory with the directory name passed as a second parameter will be created
        //$type can either be $file = application/pdf, image/png etc
        //please be sure to check the right format for your file;
        //the $type parameter is optional
       // for($i = 0; $i < count($dir); $i++){
            
        if(!file_exists($dir) && $create_dir_if_not_exists == false){
          echo $dir . 'is not a recognized folder <br> please create this directory or pass <u>true</u> as a third parameter to this function';   
        }
        else if(!file_exists($dir) && $create_dir_if_not_exists == true){
            mkdir($dir);
        }
       // }
        
       $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
       if ($extensions[0] !== '*'){
       if (!in_array($file_ext, $extensions)){
           echo 'unrecognized file extension - ' . $file_ext; exit;    
       }
       }
       
       if ($size !== 0){
           if ($_FILES[$name]['size'] > $size){
               echo 'max file size allowed : ' . $size . '<br> file size uploaded : ' . $_FILES[$name]['size'];
               exit;
           }
           
       }
       else if($size == 0){
         $size =  $_FILES[$name]['size'] * 1.5; 
       }
       $iv = rand(99, 9999);
       $date = time();
       $this->newname = $dir . '/' . $date . $filename;
       if (move_uploaded_file($_FILES[$name]['tmp_name'], $this->newname)){
           $result = array();
           $result['filename'] = $this->newname;
           $result['outcome'] = 'file successfully moved ';
           echo '<br>';
           echo $result['outcome'];
           return $result;
       }
    }

    public function enroll(Request $request){
        $url = Route('index');
        $files = $request->file('IDpic');
        //echo $files;
        $rn = rand(999, 9999);
        $date = date("d-m-Y");
            //$this->upload('IDpic', 'uploads', true,  array('jpg', 'jpeg', 'png'), 0);
            $name_o = $rn. "/" . $date . "/" . $files->getClientOriginalName();
            $files->move('uploads', $name_o);
        
        $ins = \App\Models\children::create(["name" => $request->name, "date_found" => $request->df, "time_found" => $request->tf, "age" => $request->age, "gender" => $request->gender, "photo" => $name_o]);
        if($ins){
            echo "<script>alert('child enrolled'); window.location='$url'</script>";
        }else{
            echo "<script>alert('process failed'); window.location='$url'</script>";
        }
    }

    public function listChildren(){
      $sel = \App\Models\children::select('name', 'gender', 'age', 'date_found', \App\Models\children::raw("CASE WHEN gender = 1 THEN 'male' WHEN gender = 2 THEN 'female' ELSE 'unknown' END AS gen"))->orderBy('id', 'desc')->get();
      return view('list_children', ["query" => $sel, "count" => 0]);
    }

    public function postListChildren(Request $req){
      $sql = "SELECT *, CASE WHEN gender = 1 THEN 'male' WHEN gender = 2 THEN 'female' ELSE 'unknown' END AS gen FROM childrens WHERE 1";
      if ($req->age != ''){
        $sql .= " AND age = '$req->age'";
      }
      if ($req->gender != ''){
        $sql .= " AND gender = '$req->gender'";
      }
      $sel = \DB::select($sql);
      /*if ($req->age != ''){
        $sql = $sql->where('age', $req->age);
      }
      if ($req->gender != ''){
        $sql = $sql->where('gender', $req->gender);
      }*/
      if (count($sel) > 0){
        return view('list_children', ["query" => $sel, "count" => 0]);
      }else{
        return view('list_children', ["querystr" => "no data to display", "count" => 0]);
      }

    }
    public function states(){
  $states = array('abia', 'adamawa', 'akwa-ibom', 'anambra', 'bauchi', 'bayelsa', 'benue', 'borno', 'cross river', 'delta', 'ebonyi', 'edo', 'ekiti', 'enugu',
  'gombe', 'imo', 'jigawa', 'kaduna', 'kano', 'katsina', 'kebbi', 'kogi', 'kwara', 'lagos', 'niger', 'ogun', 'ondo', 'osun', 'oyo', 'plateau', 'rivers', 'sokoto',
  'taraba', 'yobe', 'zamfara');
  //$this->states = $states;
  return $states;
  
}
    
}
