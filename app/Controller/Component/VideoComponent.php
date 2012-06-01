<?php
/**
 * Description of VideoComponent
 *
 * @author P.Loverdos
 */
//http://www.ehow.com/how_6938294_upload-php-video-files.html
class VideoComponent extends Component {
 
    public function uploadVideo($file, $folder){
    //This handles the maximum size for the video file in kbs

    define ("MAX_SIZE","500000");
    //This function reads the extension of the file to ensure that it is an video file
    function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
         $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
    
    //This variable handles an error and won't upload the file if there is a problem with it
    $errors=0;
    //checks if the form has been submitted
    //if(isset($_POST['Submit']))
    if(empty($file['video']))   echo "oxi re paidi";
    if(isset($file['video']))
    {
    //reads the name of the file the user submitted for uploading
    $video=$file['video']['name'];
    //if it is not empty
    if ($video){
    //get the original name of the file from the clients machine

    $video_filename = stripslashes($file['video']['name']);

    $video_extension = getExtension($video_filename);

    $video_extension = strtolower($video_extension);

//if it is not a known extension, we will suppose it is an error and will not upload the file, otherwise we will do more tests

if (($video_extension != "mpeg") && ($video_extension != "avi") && ($video_extension != "flv") && ($video_extension != "mov") && ($video_extension != "mp4") && ($video_extension != "mpg"))

{

echo '<h1>Unknown extension!</h1>';

$errors=1;

}

else

{

//get the size of the video

$size=filesize($file['video']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger

if ($size > MAX_SIZE*1024)

{

echo '<h1>You have exceeded the size limit!</h1>';

$errors=1;

}

//give the video a unique name in case a video already exists with the name on the server

$video_name=time().'.'.$video_extension;

//assign a folder to save the video to on your server

$newname= $folder.$video_name;

//verify that the video has been loaded
$copied = copy($file['video']['tmp_name'], $newname);

if (!$copied)

{

echo '<h1>Copy unsuccessful!</h1>';

$errors=1;

}}}}

//If no errors registered, print the success message
if(isset($file['video']) && !$errors)

{

echo "<h1>File Uploaded Successfully! Try again!</h1>";

}
}
}
?>
