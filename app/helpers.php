<?php


  	function getBucketImageUrl($uuid,$image_name,$type){
        if($type == 'company') {
            return url('https://'.env('AWS_COMPANY_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/company/'.$uuid.'/'.$image_name);
        }else if($type == 'employer'){
            return url('https://'.env('AWS_COMPANY_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/employer/'.$uuid.'/'.$image_name);
        }else{
            return url('https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/'.$uuid.'/'.$image_name);
        }
    }

   	function getPlanName($subscriptionId,$ends_at){
   		$paymentArr = [];
   		$info =  config('spark.billables');
   		if($info){
   			$plans = $info['user']['plans'];
   			foreach ($plans as $key => $value) {
   				if($subscriptionId == $value['monthly_id'] || $subscriptionId == $value['yearly_id']){
   					$plan_name = $value['name'];
   					$features = $value['features'][0];
   					$slot = str_replace(" Job Slots","",$features);
   				}
   			}
   		}
   		if($ends_at != NULL){
   			$plan_name = "Free Plan";
   			$slot = "2";
   		}
   		$paymentArr = ["name"=>$plan_name,"slot"=>$slot];
		return $paymentArr;
   	}