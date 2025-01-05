<?php
/**
 * Class for converting Text to Image.
 * Left Right Center align/justify of text in image.
 * Create an image from text and align them as you want.
 * @author Taslim Mazumder Sohel
 * @deprecated 1.0 - 2007/07/25
 * 
 */
 
class TextToImage {

	private $im;
    private $L_R_C;
    
    /**
     * @name 				   : makeImageF
     * 
     * Function for create image from text with selected font.
     * 
     * @param String $text     : String to convert into the Image.
     * @param String $font     : Font name of the text. Kip font file in same folder.
     * @param int    $W        : Width of the Image.
     * @param int    $H        : Hight of the Image.
     * @param int	 $X        : x-coordinate of the text into the image.
     * @param int    $Y        : y-coordinate of the text into the image.
     * @param int    $fsize    : Font size of text.
     * @param array  $color	   : RGB color array for text color.
     * @param array  $bgcolor  : RGB color array for background.
     * 
     */
    public function imagettfJustifytext($newline1,$newline2,$text,$addtext, $font="CENTURY.TTF", $Justify=2, $W=0, $H=0, $X=0, $Y=0, $fsize=12, $color=array(0x0,0x0,0x0), $bgcolor=array(0xFF,0xFF,0xFF)){
    	
    	$angle = 0;
    	$this->L_R_C = $Justify; 
    	$_bx = imageTTFBbox($fsize,0,$font,$text);

		$W = ($W==0)?abs($_bx[2]-$_bx[0]):$W;	//If Height not initialized by programmer then it will detect and assign perfect height. 
		$H = ($H==0)?abs($_bx[5]-$_bx[3]):$H;	//If Width not initialized by programmer then it will detect and assign perfect width. 

    	//$this->im = @imagecreate($W, $H)
		$this->im = imagecreatefrompng("../images/user/welcome_noline.png")
		    or die("Cannot Initialize new GD image stream");
		    
		    
		$background_color = imagecolorallocate($this->im, $bgcolor[0], $bgcolor[1], $bgcolor[2]);		//RGB color background.
		$text_color = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);			//RGB color text.
		
		if($this->L_R_C == 0){ //Justify Left
			
			imagettftext($this->im, $fsize, $angle, $X, $fsize, $text_color, $font, $newline1.$text." ($addtext)");
			//imagettftext($this->im, 36, $angle,$_X, $__H, $text_color, "arial.ttf", $newline2."\n".$addtext);
			
		}elseif($this->L_R_C == 1){ //Justify Right
			$s = split("[\n]+", $text);
    		$__H=0;
    		
    		foreach($s as $key=>$val){
    		
    			$_b = imageTTFBbox($fsize,0,$font,$val);
    			$_W = abs($_b[2]-$_b[0]); 
    			//Defining the X coordinate.
    			$_X = $W-$_W;
				//Defining the Y coordinate.
				$_H = abs($_b[5]-$_b[3]);  
				$__H += $_H;  			
    			imagettftext($this->im, $fsize, $angle, $_X, $__H, $text_color, $font, $newline1.$val." ($addtext)");	
				//imagettftext($this->im, 36, $angle,$_X, $__H, $text_color, $font, '___________________________');
    			$__H += 6;
    			
    		}
    		
		}
		elseif($this->L_R_C == 2){ //Justify Center
    		
    		$s = split("[\n]+", $text);
    		$__H=0;
    		
    		foreach($s as $key=>$val){
    		
    			$_b = imageTTFBbox($fsize,0,$font,$val);
    			$_W = abs($_b[2]-$_b[0]); 
    			//Defining the X coordinate.
    			$_X = abs($W/2)-abs($_W/2);
				//Defining the Y coordinate.
				$_H = abs($_b[5]-$_b[3]);  
				$__H += $_H;  			
    			imagettftext($this->im, $fsize, $angle, $_X, $__H, $text_color, $font, $newline1.$val);	
				//imagettftext($this->im, 23, $angle,$_X, $__H, $text_color, "arial.ttf",  $newline2.$addtext);
				
    			$__H += 6;
    			
    		}
			//.imagettftext($this->im, 23, $angle,$_X, $__H+100, $text_color, $font,  "__________________________________________________");
    		
    	}		
		
    }
    	
    /**
     * @name showAsPng
     * 
     * Function to show text as Png image.
     *  
     */ 
    public function showAsPng(){
		
		header("Content-type: image/png");				
		return imagepng($this->im);		
	}
    
    /**
     * @name saveAsPng
     * 
     * Function to save text as Png image.
     *  
     * @param String $filename 		: File name to save as.
     * @param String $location 		: Location to save image file.
     */ 
    public function saveAsPng($fileName, $location= null){		
		
		$_fileName = $fileName.".png";
		$_fileName = is_null($location)?$_fileName:$location.$_fileName;
		return imagepng($this->im, $_fileName);		
	}
    
    /**
     * @name showAsJpg
     * 
     * Function to show text as JPG image.
     *  
     */ 
    public function showAsJpg(){
		
		header("Content-type: image/jpg");				
		return imagejpeg($this->im);		
	}
    
    /**
     * @name saveAsJpg
     * 
     * Function to save text as JPG image.
     *   
     * @param String $filename 		: File name to save as.
     * @param String $location 		: Location to save image file.
     */ 
    public function saveAsJpg($fileName, $location= null){		
		
		$_fileName = $fileName.".jpg";
		$_fileName = is_null($location)?$_fileName:$location.$_fileName;
		return imagejpeg($this->im, $_fileName);
	}
	
	/**
     * @name showAsGif
     * 
     * Function to show text as GIF image.
     *  
     */ 
	public function showAsGif(){
		
		header("Content-type: image/gif");				
		return imagegif($this->im);
	}
    
    /**
     * @name saveAsGif
     * 
     * Function to save text as GIF image.
     *   
     * @param String $filename 		: File name to save as.
     * @param String $location 		: Location to save image file.
     */ 
    public function saveAsGif($fileName, $location= null){		
	
		$_fileName = $fileName.".gif";
		$_fileName = is_null($location)?$_fileName:$location.$_fileName;
		return imagegif($this->im, $_fileName);
	}
	
}
?>