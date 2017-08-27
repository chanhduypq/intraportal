<?php

class AsobimeigenController extends Controller
{
   public $pageTitle;	
   //check if logined or not
   public function init()
   {
        parent::init();
		$this->pageTitle="今日の名言 | ニューギンスクエア";
        if(Yii::app()->request->cookies['id'] =="")
		{ 
			$this->redirect(Yii::app()->baseUrl.'/index.php');
        }
    } 
	
	
	

	public function actionIndex()
	{
//		
   
                $html_string = file_get_contents('http://www.iwanami.co.jp/meigen/heute.html');                
                $dom = new DOMDocument();
                $dom->encoding = 'UTF-8';
                $dom->loadHTML($html_string);                
                $divs = $dom->getElementsByTagName("div");
                foreach ($divs as $div){
                    if($div->getAttribute('id')=='witt_frame'){
                        $divs = $div->getElementsByTagName("div");
                        break;
                    }
                }
                $text='';
                $link='www.iwanami.co.jp';
                $a_text='';
                $last_text='';
                foreach ($divs as $div){
                    if($div->getAttribute('class')=='witticism'){
                        $text=$div->nodeValue;                            
                    }
                    if($div->getAttribute('class')=='source'){                            
                        $as=$div->getElementsByTagName('a');
                        foreach ($as as $a){
                            $link.=$a->getAttribute('href');
                            $a_text=$a->nodeValue;
                        }
                    }
                    if($div->getAttribute('class')=='comment'){                            
                        $last_text=$div->nodeValue;             
                    }
                }
                
                    
		$this->render('/asobi/meigen/index',array('link'=>$link,'text'=>$text,'last_text'=>$last_text,'a_text'=>$a_text));
	}
}
?>
