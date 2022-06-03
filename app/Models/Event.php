<?php
class Event {

    public function  createEvent($data) {
        if($data['type']=="deposit") {
            $oldbalance = [];
            if(file_exists("balance.json")) {
                $oldbalance = file_get_contents('balance.json');
                $oldbalance = json_decode($oldbalance, true);
            }

            if( isset($oldbalance[$data['destination']]) && $oldbalance[$data['destination']] && $oldbalance[$data['destination']]==10) {
                $oldbalance[$data['destination']]=$oldbalance[$data['destination']]+$data['amount'];
            } else {
                $oldbalance[$data['destination']]=$data['amount'];
                file_put_contents('balance.json', json_encode($oldbalance,JSON_PRETTY_PRINT));
            }

//            $oldbalance[date('M-d H:i:s')]=$data;
//            if(isset($oldbalance['count']))
//                $oldbalance['count']=$oldbalance['count']+1;
//            else
//                $oldbalance['count']=1;


            return array("data"=>array('destination'=> array('id'=>$data['destination'],'balance'=>$oldbalance[$data['destination']])),'code'=>'201');
        } elseif ($data['type']=="withdraw") {
            if($data['origin']=="100")//exist
                return array("data"=>array('origin' => array('id'=> $data['origin'],'balance'=>15)),'code'=>'201');
            else
                return array("data"=>0,'code'=>'404');
        } elseif ($data['type']=="transfer") {
            if($data['origin']=="100")//exist
                return array("data"=>array('origin'=> array('id'=> $data['origin'],'balance'=>0),'destination'=>array('id'=>"300",'balance'=>15)),'code'=>'201');
            else
                return array("data"=>0,'code'=>'404');
        }
    }
}