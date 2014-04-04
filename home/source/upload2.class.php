<?php

	class upload1
	{
		var $upload_name;					//上传文件名
		var $upload_tmp_name;				//上传临时文件名
		var $upload_final_name;				//上传文件的最终文件名
		var $upload_target_dir;				//文件被上传到的目标目录
		var $upload_target_path;			//文件被上传到的最终路径
		var $upload_filetype ;				//上传文件类型
		var $allow_uploadedfile_type;		//允许的上传文件类型
		var $upload_file_size;				//上传文件的大小
		var $allow_uploaded_maxsize=111115000; 	//允许上传文件的最大值
		var $image_w=900; 					//要显示图片的宽
		var $image_h=350; 					//要显示图片的高

		function __construct()
		{
			$this->upload_name = $_FILES["file2"]["name"]; //取得上传文件名
			$this->upload_filetype = $_FILES["file2"]["type"];
			$this->upload_tmp_name = $_FILES["file2"]["tmp_name"];
			$this->allow_uploadedfile_type = array("image/gif","image/jpeg");
			$this->upload_file_size = $_FILES["file2"]["size"];
		}

		function upload_file1($id,$table)
		{   
			if(!empty($this->upload_filetype)){
			if(in_array($this->upload_filetype,$this->allow_uploadedfile_type))
			{
				if($this->upload_file_size < $this->allow_uploaded_maxsize)
				{
					$this->upload_target_dir="./upload/$table/";
					if(!is_dir($this->upload_target_dir))
					{
						mkdir($this->upload_target_dir);
					}

					//showmessage($this->upload_final_name);
					//$this->upload_target_path = $this->upload_target_dir.$this->upload_name;
					$this->upload_final_name = $table."_".$id."_"."zhizhao.jpg";
					$this->upload_target_path = $this->upload_target_dir.$this->upload_final_name;
					if(move_uploaded_file($this->upload_tmp_name,$this->upload_target_path)){

					include("./source/image2.class.php");
  					$image=new image1();

  					$image->reImg2($this->upload_target_path,100,100,80,$id,$table);
  					
  					
  					updatetable($table, array('image3url'=>$this->upload_target_path), array('uid'=>$id));
  					
				}
				}else
				{
					showmessage("<font color=red>文件太大,上传失败！</font>");
				}
					
			}else{
				showmessage("不支持此文件类型，请重新选择");
			}
		}
	}

		

}

?>
