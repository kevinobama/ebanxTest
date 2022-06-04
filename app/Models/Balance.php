<?php
namespace App\Models;

class Balance {

    public function  getBalanceByAccountId($accountId) {
        $sql ="select id,Balance from Balances where account_id=".$accountId;

        if($accountId=='1234') {
            return array('balance'=>0,'result'=>"Not Found");
        }

        if($accountId=='100') {
            return array('balance'=>20,'result'=>"OK");
        }
        
        return array('balance'=>0,'result'=>"Not Found");
    }
}