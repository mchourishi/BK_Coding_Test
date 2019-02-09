<?php
/*
 * @Author: mukta.patel 
 * @Date: 2019-02-09 16:54:26 
 * @Last Modified by: mukta.patel
 * @Last Modified time: 2019-02-09 16:55:54
 */

 echo 'hello';
 move_uploaded_file($_FILES["image"]["tmp_name"], "img/" . $_FILES["image"]["name"]);


