<?php
/*
 * @Author: mukta.patel 
 * @Date: 2019-02-09 16:54:26 
 * @Last Modified by: mukta.patel
 * @Last Modified time: 2019-02-10 11:32:55
 */

//Enabling CORS to accept request
header('Access-Control-Allow-Origin: *');

 //Uploads file to images folder
 move_uploaded_file($_FILES["image"]["tmp_name"], "../frontend/images/" . $_FILES["image"]["name"]);


