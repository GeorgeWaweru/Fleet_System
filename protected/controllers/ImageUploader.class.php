<?php
/*
Simple PHP OOP Image Upload script by m0nsta.
*/
class ImageUploader
{
    private $file_types = array(".csv",".png",".jpg", ".jpeg", ".txt", ".pdf", ".doc", ".docx");
    private $maxSize = 9999999;
    private $uploadTarget = "";
	private $can_rename = true;
    private $fileName = "";
    private $tmpName = "";
    
	/**
	 * @param string $file_input_name
	 * @param string $upload_path
	 * @param boolean $rename_file
	 * @param array $file_types
	 * @return string
	 */
    public function startUpload($file_input_name,$upload_path,$rename_file = true, $file_types = array())
    {
        $this->uploadTarget = $upload_path;
		$this->can_rename = $rename_file;
		$this->fileName = $_FILES[$file_input_name]['name'];
        $this->tmpName = $_FILES[$file_input_name]['tmp_name'];
		
		if(is_array($file_types)){
			if(count($file_types) > 0){
				$this->file_types = $file_types;
			}
		}
		
        if( !$this->isWritable() )
        {
            die( "Sorry, you must CHMOD your upload target to 777!" );
        }
        if( !$this->checkExt() )
        {
			//echo "The extension is ".$this->getExt();
            die( "Sorry, you can not upload this filetype!" );
        }
        if( !$this->checkSize() )
        {
            die( "Sorry, the file you have attempted to upload is too large!" );
        }
        if( $this->fileExists() )
        {
            die( "Sorry, this file already exists on our servers!" );
        }
        if( $this->uploadIt() )
        {
		 	return	str_replace (' ','', time().$this->fileName);
        }else{
            echo "Sorry, your file could not be uploaded for some unknown reason!";
        }
    }
    
    public function uploadIt()
    {
        if($this->can_rename == true){
			return ( move_uploaded_file( $this->tmpName, $this->uploadTarget .str_replace (' ','', time().$this->fileName)) ? true : false );
		}else{
			return ( move_uploaded_file( $this->tmpName, $this->uploadTarget. $this->fileName ) ? true : false );
		}
    }
    
    public function checkSize()
    {
        return ( ( filesize( $this->tmpName ) > $this->maxSize ) ? false : true );
    }
    
    public function getExt()
    {
        return strtolower( substr( $this->fileName, strpos( $this->fileName, "." ), strlen($this->fileName ) - 1));
		
    }
    
    public function checkExt()
    {
        return ( in_array( $this->getExt(), $this->file_types) ? true : false );
    }
    
    public function isWritable()
    {
        return ( is_writable( $this->uploadTarget ) );
    }
    
    public function fileExists()
    {
        return ( file_exists( $this->uploadTarget . str_replace (' ','', time().$this->fileName)) );
    }
}
?> 