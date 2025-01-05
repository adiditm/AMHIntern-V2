<?

    header('Access-Control-Allow-Origin');
	 
	  if ($_GET['op'] =='collect') {
		        $total_chunk_number=$_POST['count'];
				$uid = $_POST['uuid'];
				$filename = $_POST['filename'];
				$upload_folder = dirname(__FILE__) . '/uploadedimg/';
				
				// reassemble the partial pieces to a whole file
					
				for ($i = 0; $i < $total_chunk_number; $i ++) {
					$content = file_get_contents($upload_folder . $uid . '.part' . $i);
					
					file_put_contents($upload_folder . $filename, $content, FILE_APPEND);
					unlink($upload_folder . $uid . '.part' . $i);
				}	
				
				exit;	  
	  }
	 
	  if ($_GET['op'] =='dzUp') {
		  
		//  print_r($_POST);
		  
	// uid is used to identify chunked partial files so we can assemble them back when all chunks are finished uploading
		$uid = $_REQUEST['dzuuid'];
		$filename = $_FILES['file']['name'];
		if (empty($_FILES['file']['name'])) {
			return '';
		}
		if (isset($_POST['dztotalchunkcount'])) {
			// the file is uploaded piece by piece, chunk mode
			$current_chunk_number = $_REQUEST['dzchunkindex'];
			$chunk_size = $_REQUEST['dzchunksize'];
			$total_size = $_REQUEST['dztotalfilesize'];
	
			$upload_folder = dirname(__FILE__) . '/uploadedimg/';
			$total_chunk_number = ceil($total_size / $chunk_size);
			move_uploaded_file($_FILES['file']['tmp_name'], $upload_folder . $uid . '.part' . $current_chunk_number);
			
		} else {
			// the file is uploaded as a whole, no chunk mode
			move_uploaded_file($_FILES['file']['tmp_name'], $upload_folder . $filename);
		}		
		
		
		/*move_uploaded_file($_FILES['file']['tmp_name'],"../setup/uploadedimg/{$_FILES['file']['name']}");  

		echo json_encode($_FILES);
		*/
		
		
	    exit;	
	  } else {
		//print_r($_GET);  
		//exit;
	  }
	
	?>
