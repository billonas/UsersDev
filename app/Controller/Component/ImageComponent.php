<?php

/**
 * Description of ImageComponent
 *
 * @author P.Loverdos
 */

class ImageComponent extends Component {
    
    public function checkImage($image){
        if(empty($image['tmp_name'])){
            return -1;
        }
        $result = 1;
         ini_set("display_errors", 0);  //xreiazetai gia na mhn bgainei warning an den einai foto
   	 if(!exif_imagetype($image['tmp_name'])){
            $result = 0;
	 }
         ini_set("display_errors", 1);
         return $result;
    }
    
    public function tmpRename($img){
        $tok = strtok ($img['name'], "." );
        while(($tok1 = strtok(".")) !== false){
		$tok = $tok1;      		
        }
	//briskw ena tuxaio arithmo tetoion wste na mhn uparxei eikona ston /img/temporary pou na exei gia onoma auton
      
        do{ 
            $rand = rand();
            $name = "$rand.$tok";		
	}while(file_exists("img/temporary/$name"));
	//allazw to onoma tou arxeiou kai to kanw ton arithmo pou brhka (me thn katallhlh katalhksh)
	//(auto den ephreazei tpt, dld den xanetai to arxeio)
        $img['name'] = $name;
        return $name;
    }
    
    public function mvSubImg($report, $name, $dir, $photo, $ext = ""){
        if(empty($name))
                return 1;
         $newNameId = $report->id;  //to id ths eggrafhs pou molis prostethhke
	 $tok = strtok (  $name, "." ); //briskw thn katalhksh ths eikonas
         while(($tok1 = strtok(".")) !== false){
		$tok = $tok1;      		
	}
	//dinw sthn eikona gia onoma to id ths eggrafhs(me thn katallhlh katalhksh) kai th metaferw tautoxrona ston fakelo
        //webroot/img/reports
	$newName = "$dir/$newNameId$ext.$tok";  
	rename("$name", "img/$newName");
        if(!$report->saveField($photo, $newName)) return 0;
        return 1;
    }
    
    public function uploadSubImg($model, $tmp, $name, $dir, $photo, $ext = ""){
	if(empty($name))
                return 1;
         $newNameId = $model->id;  //to id ths eggrafhs pou molis prostethhke
	 $tok = strtok (  $name, "." ); //briskw thn katalhksh ths eikonas
         while(($tok1 = strtok(".")) !== false){
		$tok = $tok1;      		
	}
	//dinw sthn eikona gia onoma to id ths eggrafhs(me thn katallhlh katalhksh) kai th metaferw tautoxrona ston fakelo
        //webroot/img/reports
	$newName = "$dir/$newNameId$ext.$tok";  
	move_uploaded_file($tmp, "img/$newName");
        if(!$model->saveField($photo, $newName)) return 0;
        return 1;
    }

    public function mvSubImg2($report, $name, $dir, $ext = ""){
        if(empty($name))
                return 1;
         $newNameId = $report->id;  //to id ths eggrafhs pou molis prostethhke
	 $tok = strtok (  $name, "." ); //briskw thn katalhksh ths eikonas
         while(($tok1 = strtok(".")) !== false){
		$tok = $tok1;      		
	}
	//dinw sthn eikona gia onoma to id ths eggrafhs(me thn katallhlh katalhksh) kai th metaferw tautoxrona ston fakelo
        //webroot/img/reports
	$newName = "$dir/$newNameId$ext.$tok";  
	rename("$name", "img/$newName");
        if(!$report->saveField("additional_photo1", $newName)) return 0;
        return 1;
    }
    
    public function dlImg($rep, $id, $Model){
            $report = $rep->findById($id);
	    $main_photo = $report[$Model]['main_photo'];
	    $additional_photo1 = $report[$Model]['additional_photo1'];
	    $additional_photo2 = $report[$Model]['additional_photo2'];
	    $additional_photo3 = $report[$Model]['additional_photo3'];
            if($main_photo)  //diagrafw thn eikona pou antistoixouse sthn eggrafh, ama uparxei
         	    unlink("img/$main_photo");
	    if($additional_photo1)  
         	    unlink("img/$additional_photo1");
	    if($additional_photo2)  
         	    unlink("img/$additional_photo2");
	    if($additional_photo3)  
         	    unlink("img/$additional_photo3");
	    if(!strcmp($Model, 'Report')){
		$additional_photo4 = $report[$Model]['additional_photo4'];
	    	$additional_photo5 = $report[$Model]['additional_photo5'];
		$video = $report[$Model]['video'];
		if($additional_photo4)  
         	    unlink("img/$additional_photo4");
	    	if($additional_photo5)  
         	    unlink("img/$additional_photo5");
		if($video)  
         	    unlink("video/$video");
	    }
    }
    
    public function changePriority($photo_name, $hot, $photoId, $pId, $obj){
        $id = $hot['HotSpecie']['id'];
        $tok = strtok (  $photo_name, "." ); //briskw thn katalhksh ths eikonas
        while(($tok1 = strtok(".")) !== false){
		$tok = $tok1;      		
	}
	$tok2 = strtok (  $hot['HotSpecie']['main_photo'], "." ); //briskw thn katalhksh ths eikonas
        while(($tok1 = strtok(".")) !== false){
		$tok2 = $tok1;      		
	}
        rename("img/{$hot['HotSpecie']['main_photo']}", "img/hotspecies/tmp.$tok2");
        rename("img/$photo_name", "img/hotspecies/$id.$tok");
	rename("img/hotspecies/tmp.$tok2", "img/hotspecies/{$id}{$photoId}.$tok2");
        $obj->id = $id;
        if(!$obj->saveField("main_photo","hotspecies/$id.$tok" ))
                 return 0;
        if(!$obj->saveField("additional_photo".$pId,"hotspecies/{$id}{$photoId}.$tok2" )) return 0;
               return 1;
    }
}    


?>
