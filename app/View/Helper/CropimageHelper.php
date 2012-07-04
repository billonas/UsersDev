<?php  
/**
 *  
 */
class CropimageHelper extends Helper { 
    var $helpers = array('Html', 'Javascript', 'Form'); 

    function createJavaScript($imgW, $imgH, $thumbW, $thumbH) { 
            return $this->output("<script type=\"text/javascript\"> 

                function preview(img, selection) { 
                    var scaleX = $thumbW / selection.width; 
                    var scaleY = $thumbH / selection.height; 

                    $('#thumbnail + div > img').css({ 
                        width: Math.round(scaleX * $imgW) + 'px', 
                        height: Math.round(scaleY * $imgH) + 'px', 
                        marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
                        marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
                    }); 
                    $('#x1').val(selection.x1); 
                    $('#y1').val(selection.y1); 
                    $('#x2').val(selection.x2); 
                    $('#y2').val(selection.y2); 
                    $('#w').val(selection.width); 
                    $('#h').val(selection.height); 
                } 

                $(document).ready(function () { 
                    $('#save_thumb').click(function() { 
                        var x1 = $('#x1').val(); 
                        var y1 = $('#y1').val(); 
                        var x2 = $('#x2').val(); 
                        var y2 = $('#y2').val(); 
                        var w = $('#w').val(); 
                        var h = $('#h').val(); 
                        if(x1==\"\" || y1==\"\" || x2==\"\" || y2==\"\"|| w==\"\" || h==\"\"){ 
                            alert('Please choose a area to crop...'); 
                            return false; 
                        }else{ 
                            return true; 
                    } 
                }); 
            }); 
	    
            $(window).load(function () { 
                 $('#thumbnail').imgAreaSelect({ aspectRatio: '1:1', onSelectChange: preview, parent: '#f1'}); 
            });
            </script>"); 
    } 

    function createForm($imagePath, $tH, $tW){ 
            $x1 = $this->Form->hidden('x1', array("value" => "", "id"=>"x1")); 
            $y1 = $this->Form->hidden('y1', array("value" => "", "id"=>"y1")); 
            $x2 = $this->Form->hidden('x2', array("value" => "", "id"=>"x2",)); 
            $y2 = $this->Form->hidden('y2', array("value" => "", "id"=>"y2")); 
            $w =  $this->Form->hidden('w', array("value" => "", "id"=>"w")); 
            $h =  $this->Form->hidden('h', array("value" => "", "id"=>"h")); 
            $per = $this->Form->input('permissionUseMedia',array("label"=>"Μπορούν να χρησιμοποιηθούν οι φωτογραφίες/βίντεό σας για την παρουσίαση των αναφορών σας;", 'class'=>'std_form'));
            $imgP = $this->Form->hidden('imagePath', array("value" => $imagePath)); 
            $imgTum = $this->Html->image($imagePath, array('style'=>'', 'id'=>'jcrop_target', 'alt'=>'Create Thumbnail')); 
            //$imgTumPrev = $this->Html->image($imagePath, array('style'=>'position: relative;', 'id'=>'thumbnail', 'alt'=>'Thumbnail Preview')); 
            return $this->output("
                    <div id='img_crop_area'>                        
                        $imgTum
                        $per
                        <br/>Μπορείτε αν το επιθυμείτε να καταθέσετε μόνο ένα κομμάτι της φωτογραφίας κλικάροντας με το ποντίκι και σύροντάς το καλύπτοντας την επιφάνεια που θέλετε.
                        <br/>Ενδείκνυται όμως στη φωτογραφία να φαίνεται το περιβάλλον που εντοπίστηκε το είδος.
                        $x1 $y1 $x2 $y2 $w $h $imgP
                    </div>"); 
            
    }  

} 
?>
