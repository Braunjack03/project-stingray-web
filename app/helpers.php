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