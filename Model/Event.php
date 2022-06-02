<?php

class Event {

    public function  createEvent($data) {
        if($data['type']=="deposit") {

            return array("data"=>array('destination'=> array('id'=> $data['destination'],'balance'=>$data['amount'])),'code'=>'201');
        } elseif ($data['type']=="withdraw") {
            if($data['origin']=="100")//exist
                return array("data"=>array('origin' => array('id'=> $data['origin'],'balance'=>'15')),'code'=>'201');
            else
                return array("data"=>0,'code'=>'404');
        } elseif ($data['type']=="transfer") {
            if($data['origin']=="100")//exist
                return array("data"=>array('origin'=> array('id'=> $data['origin'],'balance'=>'0'),'destination'=>array('id'=>"300",'balance'=>15)),'code'=>'201');
            else
                return array("data"=>0,'code'=>'404');
        }
    }
}