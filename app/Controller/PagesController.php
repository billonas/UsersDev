<?php

/**
 * Description of UsersController
 *
 * @author Billonas
 */
class PagesController extends AppController{
  
  	public $name = 'Pages';
  
	public $helpers = array('Html', 'Session','Js'); //To 'js' prepei na ginei 'Js' gia na douleuei
    
	public $uses = array();
        
   function beforeFilter() 
   {

      if($this->Session->check('report')){
            $this->Session->delete('report');
        }
        if($this->Session->check('report_completed')){
            $this->Session->delete('report_completed');
        }
        if($this->Session->check('uploaded1')){
            $this->Session->delete('uploaded1');
        }
        if($this->Session->check('uploaded2')){
            $this->Session->delete('uploaded2');
        }
   }

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();


        $temp_species = ClassRegistry::init('HotSpecie')->find('all');
		$i=0;
        foreach($temp_species as $item){
					$hotspecies[$i]['scientific_name']=$item['HotSpecie']['scientific_name'];
					$hotspecies[$i]['id']=$item['HotSpecie']['id'];
					$i++;
				}
		$this->set('hotspecies',$hotspecies);
		
		
		$coords=('0');
		
		//Load last 30 reports coords
		$this->set('coords',$coords);		
		

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	function about(){
		
	}
	
	function help(){
		
	}
	
	function communication(){
		
	}
    
}

?>
