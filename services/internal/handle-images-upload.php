<?php
//Handling multiple image upload
//Thanks to  CertaiN for comment about file validation and security
header('Content-Type: text/plain; charset=utf-8');
define('MB', 1048576);

function fnUploadMultipleImages() {

	$result = array();

	for($i = 0; $i < count($_FILES['img']['name']); $i++) {
		try {
		   
		    // Undefined | $_FILES Corruption Attack
		    // If request falls under any of them, treat it invalid.
		    if (
		        !isset($_FILES['img']['error'])
		    ) {
		        throw new RuntimeException('Invalid parameters.');
		    }

		    // Check $_FILES['error'] value.
		    switch ($_FILES['img']['error'][$i]) {
		        case UPLOAD_ERR_OK:
		            break;
		        case UPLOAD_ERR_NO_FILE:
		            throw new RuntimeException('No file sent.');
		        case UPLOAD_ERR_INI_SIZE:
		        case UPLOAD_ERR_FORM_SIZE:
		            throw new RuntimeException('Exceeded filesize limit.');
		        default:
		            throw new RuntimeException('Unknown errors.');
		    }

		    // Check if file is larger than 2 mb 
		    if ($_FILES['img']['size'][$i] > 2*MB) {
		        throw new RuntimeException('Exceeded filesize limit.');
		    }

		    // Not trusting $_FILES['img']['mime'] VALUE
		    // Checking MIME Type by myself.
		    $finfo = new finfo(FILEINFO_MIME_TYPE);
		    if (false === $ext = array_search(
		        $finfo->file($_FILES['img']['tmp_name'][$i]),
		        array(
		            'jpg' => 'image/jpeg',
		            'png' => 'image/png'
		        ),
		        true
		    )) {
		        throw new RuntimeException('Invalid file format.');
		    }

		    // Assigning unique names, not using $_FILES['img']['name'] 
		    // Obtaining safe unique name from its binary data.
		    $sNewName = sha1_file($_FILES['img']['tmp_name'][$i]);
		    if (!move_uploaded_file(
		        $_FILES['img']['tmp_name'][$i],
		        sprintf('../images/properties/%s.%s',
		            $sNewName,
		            $ext)
		        )
		    ) {
		        throw new RuntimeException('Failed to move uploaded file.');
		    }
		    //Add image name to array to return
		    array_push($result, $sNewName.'.'.$ext);

		} catch (RuntimeException $e) {

		    echo $e->getMessage();

		}
	} // end of loop
	// return array of uploaded files names
	return $result;
}
?>