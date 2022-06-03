<?php
namespace App\Models;

class Balance {

    public function  getBalanceByAccountId($accountId) {
        $sql ="select id,Balance from Balances where account_id=".$accountId;

        if($accountId=='1234') {
            return array('balance'=>0,'code'=>404);
        }

        if($accountId=='100') {
            return array('balance'=>20,'code'=>200);
        }
        
        return array('balance'=>0,'code'=>404);
    }
}