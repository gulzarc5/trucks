<?php
namespace App\Services;

use App\Models\Bids;

class ClientBidCheckService {

    public function clientBidCheck($order_id,$client_id){
        $bid_check = Bids::where('order_id',$order_id)->where('client_id',$client_id)->count();
        return $bid_check;
    }

}
