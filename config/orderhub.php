<?php 
return [
    "discount"=> [
        "driver"=> env ("ORDERHUB_DISCOUNT_DRIVER","percentage"),
        "percentage"=> [
            "percent"=> (int) env ("ORDERHUB_DISCOUNT_PERCENT",20),
        ],
        "fixed"=> [
            "amount"=>(int) env ("ORDERHUB_DISCOUNT_FIXED_AMOUNT",1500),
            "currency"=>  env ("ORDERHUB_DISCOUNT_CURRENCY","USD"),
        ],
    ]
];