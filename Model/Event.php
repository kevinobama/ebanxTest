<?php


class Event {

    public function  createEvent($data) {
        if($data['type']=="deposit") {
            return array('destination'=>array('id'=>$data['destination'],'balance'=>$data['amount']));
        } elseif ($data['type']=="withdraw") {
            return array('destination'=>array('id'=>'100','balance'=>'10'));
        } elseif ($data['type']=="transfer") {
            return array('destination'=>array('id'=>'100','balance'=>'10'));
        }
    }
}