<?php
echo 'v1<br>';
echo 'v2<br>';
echo 'v3<br>';
echo 'Khong chay duoc ZipArchive';
try {
    $zip = new ZipArchive();

	if($zip->open('test.zip') === TRUE )
	{
	    if ($zip->locateName('moduleConfig.xml') !== false)
	    {
	    echo "Config exists";
	    }
	}
	else {
	    echo 'Failed code:'. $res;
	}

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


?>