<?php
namespace App\Models;

class Event {

    public function  createEvent($data) {
        if($data['type']=="deposit") {
            $oldbalance = [];
            if(file_exists("balance.json")) {
                $oldbalance = file_get_contents('balance.json');
                $oldbalance = json_decode($oldbalance, true);
            }

            if(isset($oldbalance['count']) && $oldbalance['count'] && $oldbalance['count']==1) {
                $oldbalance[$data['destination']]=$data['amount'];
                $oldbalance['count']++;
                unlink('balance.json');
            } else {
                $oldbalance[$data['destination']]=$data['amount']+10;
                $oldbalance['count']=1;
                file_put_contents('balance.json', json_encode($oldbalance,JSON_PRETTY_PRINT));
            }

            return array("data"=>array('destination'=> array('id'=>$data['destination'],'balance'=>$oldbalance[$data['destination']])),'result'=>'Created');
        } elseif ($data['type']=="withdraw") {
            if($data['origin']=="100")//exist
                return array("data"=>array('origin' => array('id'=> $data['origin'],'balance'=>15)),'result'=>'Created');
            else
                return array("data"=>0,'result'=>'Not Found');
        } elseif ($data['type']=="transfer") {
            if($data['origin']=="100")//exist
                return array("data"=>array('origin'=> array('id'=> $data['origin'],'balance'=>0),'destination'=>array('id'=>"300",'balance'=>15)),'result'=>'Created');
            else
                return array("data"=>0,'result'=>'Not Found');
        }
    }
}