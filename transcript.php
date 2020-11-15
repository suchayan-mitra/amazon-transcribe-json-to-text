<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="upfile" />
         <input type="submit" />
      </form>
      
   </body>
</html>

<?php

try {
   
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }


    switch ($_FILES['upfile']['error']) {
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

    
$data = json_decode(file_get_contents($_FILES['upfile']['tmp_name']));

$file = "output-";

foreach ($data as $item)
{
	
	
	if($item->Transcript->Results[0]->IsPartial == false && $item->Transcript->Results[0]->Alternatives[0]->Transcript <> "")
	{
	    echo "Start Time: " . fmtMSS($item->Transcript->Results[0]->StartTime);
	    echo "<br/>";
	    echo "Text: " . $item->Transcript->Results[0]->Alternatives[0]->Transcript;
	    echo "<br/>";
	    echo "End Time: " . fmtMSS($item->Transcript->Results[0]->EndTime);
	    echo "<br/>";
	    echo "<br/>";
	}

}


} catch (RuntimeException $e) {

    echo $e->getMessage();
}

function fmtMSS($s){
    $s=floor($s);
    $minutes = floor($s/60); 
    $seconds = $s-$minutes*60; 
    return "$minutes:$seconds";
};

/* End of the transcript.php file */
