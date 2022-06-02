<?php

class Event {

    public function  createEvent($data) {
        if($data['type']=="deposit") {

            return array('destination'=> array('id'=> $data['destination'],'balance'=>$data['amount']));
        } elseif ($data['type']=="withdraw") {
            if($data['origin']=="100")//exist
                return array('origin' => array('id'=> $data['origin'],'balance'=>'15'));
            else
                return array('origin' => array('id'=> $data['origin'],'balance'=>'0'));
        } elseif ($data['type']=="transfer") {
            if($data['origin']=="100")//exist
                return array('origin'=> array('id'=> $data['origin'],'balance'=>'0'),'destination'=>array('id'=>"300",'balance'=>15));
            else
                return array('origin'=> array('id'=> $data['origin'],'balance'=>'0'));
        }
    }
}