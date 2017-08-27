<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate, max-age=0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if(isset(Yii::app()->session['lastime']))
{
    if(time()-Yii::app()->session['lastime']>Config::TIME_OUT)
	{
        Yii::app()->request->cookies->clear();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->request->baseUrl.'/newgin');
    }
}
if(Yii::app()->request->cookies['id'] !="")
{
    Yii::app()->session['lastime'] = time();
}
?>
<title><?php echo isset($this->pageTitle) ? $this->pageTitle : 'ニューギンスクエア'; ?></title>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->assetsBase; ?>/css/common/css/color.css" rel="stylesheet" media="screen">
<link href="<?php echo $this->assetsBase; ?>/css/common/css/base.css" rel="stylesheet" type="text/css">    
<link href="<?php echo $this->assetsBase; ?>/css/common/css/default.css" rel="stylesheet" type="text/css">
<?php
 if(Yii::app()->getController()->getId() =='majime'){ 
?>
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/toppage.css" rel="stylesheet" type="text/css">
<?php
 }
 else if(Yii::app()->getController()->getId() =='asobi'){ 
?>
<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/toppage.css" rel="stylesheet" type="text/css">
<?php	 
	 }
?>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/function.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/jquery.cookies.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/up.down.js"></script>
<!--<script src="<?php echo $this->assetsBase; ?>/js/lib/jquery.cookies.2.2.0.js"></script>-->
<script src="<?php echo $this->assetsBase; ?>/js/lib/common.js"></script>
<style>    
    img#not_download{
        -webkit-touch-callout:none;
        -webkit-user-select:none;
    }
</style>
</head>
<body id="majime">

<?php

if(Yii::app()->request->cookies['passwd']=='7581'){
	  $get_id_p = Yii::app()->getController()->getAction()->getId();
	  $get_ac_p = Yii::app()->getController()->getId();
	 if(($get_id_p=='edit' && $get_ac_p !='adminprofile') || $get_id_p=='editconfirm' || $get_id_p=='add' || $get_id_p=='addconfirm' || $get_id_p=='addcomplete' || $get_id_p=='index' || ($get_id_p=='detail' && $get_ac_p !='adminprofile') || $get_ac_p=='majime' || $get_ac_p=='admin' || $get_ac_p=='asobi' ||  $get_ac_p=='majime' || $get_id_p=='categoryedit'  || $get_id_p=='categoryregist' || $get_id_p=='adoptionadd' || $get_id_p=='adoptionedit')
	 {  
			$this->redirect(Yii::app()->request->baseUrl.'/adminprofile/detail/?id='.Yii::app()->request->cookies['id']);
	 }	
?>	
<script type='text/javascript'>
    
 $(document).ready(function(){
	$('a').removeAttr('href');
	$('a').removeAttr('onclick');
	$('button').removeAttr('type');
	});
</script>
<?php		
}
else {
	$get_id = Yii::app()->getController()->getAction()->getId();
	$get_ac = Yii::app()->getController()->getId();
	$get_Controlles = substr($get_ac,5);
	
//isAdmin = false and isPost=true and contributor_id=false 	
	$array_Ac = array('adminbbs', 'adminideas', 'adminbounty' ,'adminclaim','admincriticism','adminenquete','adminnewitem' ,'adminreport','adminrival','admintrouble','adminto_officer','adminpride','admingolf_news','admingolf_score','adminhobby_itd','adminhobby_new');
	if(FunctionCommon::isAdmin()==FALSE && (FunctionCommon::isPostFunction($get_Controlles)) && (FunctionCommon::isContributorFunction($get_Controlles))==false)
	{	
	   
		if(($get_id=='detail' && (in_array($get_ac,$array_Ac))) || ($get_id=='edit' && (in_array($get_ac,$array_Ac))) || ($get_id=='editconfirm' && (in_array($get_ac,$array_Ac))) || ($get_ac =='admincelebrate' && ($get_id=='categoryedit' || $get_id=='categoryregist'))  || ($get_ac =='adminsoumu_qa' && ($get_id=='categoryedit' || $get_id=='categoryregist')))
		{  	
				$this->redirect(array(Yii::app()->request->baseUrl.'general/error'));
		}
	}
/*22/11/2013 
isAdmin = false (base, user, role, post, office,holiday,tagcrowd*/
	$array_Ac_new = array('adminuser', 'adminrole', 'adminbase' ,'adminpost','adminoffice','adminholiday','admintagcrowd',
'admintwitter','adminblogc','adminslink','adminlink','adminpresident_msg','adminpickup','adminbase_news','adminsales_ranking','adminsoumu_jinji','adminsoumu_news','admincelebrate_rpt','adminthanks','adminskill','adminshare_item','adminzentaishihyou');
	if(FunctionCommon::isAdmin()==FALSE)
	{	
	   
	   $get_ac = Yii::app()->getController()->getId();
		if(in_array($get_ac,$array_Ac_new))
		{  		
				$this->redirect(array(Yii::app()->request->baseUrl.'general/error'));
		}
	}	
}
?>
<div class="header">
<div class="headBox">
    <h1><a href="<?php echo Yii::app()->request->baseUrl; ?>/majime/" class="logo portal">ニューギンスクエア</a></h1>
    <a href="#" class="logo newgin">ニューギン</a>
    <a href="#" class="logo excite">エキサイト</a>
    <?php
   if(Yii::app()->request->cookies['id'] !=""){ 
       if(!isset(Yii::app()->session['lastname'])||!isset(Yii::app()->session['firstname'])){
           $row=Yii::app()->db->createCommand()
                   ->select(array("lastname","firstname"))
                   ->from("user")
                   ->where("id=".Yii::app()->request->cookies['id'])
                   ->queryRow()
                   ;
           if(is_array($row)&&count($row)>0){
               Yii::app()->session['lastname']=$row['lastname'];
               Yii::app()->session['firstname']=$row['firstname'];
           }
       }
	$this->widget('MenutopWidget');
	}?>
 </div><!-- /headBox -->
</div><!-- /header -->
 <?php 
$action=Yii::app()->getController()->getAction()->getId();
if($action!="regist"&&$action!="edit"&&$action!="add"){
    unset(Yii::app()->session['attachment1']);
    unset(Yii::app()->session['attachment2']);
    unset(Yii::app()->session['attachment3']);
    unset(Yii::app()->session['attachment4']);
}
 if(Yii::app()->request->cookies['id'] !="" || (Yii::app()->getController()->getId() =='newgin')){ 
		 echo $content; 
 }
else{
		echo ("<SCRIPT LANGUAGE='JavaScript'>window.location.href='newgin/';</SCRIPT>");
}

 ?>
	    
<script src="<?php echo $this->assetsBase; ?>/css/common/js/bootstrap.min.js"></script>
<script type="text/javascript">

    jQuery(function($) { 
//        $('img#not_download').mousedown( function() {            
//            return false;
//        });
//        $('a#demo').mousedown( function() {
//            return false;
//        });
//        $('img#not_download').attr("ondragstart","return false;");
//        $('img#not_download').attr("ondrop","return false;");
//        $('a#demo').attr("ondragstart","return false;");
//        $('a#demo').attr("ondrop","return false;");
        
         
        
        act='<?php echo Yii::app()->getController()->getAction()->getId();?>';
        con='<?php echo Yii::app()->getController()->getId();?>';
        /*module='';
        task='';
        if(con.substr(0,6)=='majime'){
            module='majime';
        }
        else if(con.substr(0,5)=='admin'){
            module='admin';
        }
        else if(con.substr(0,5)=='asobi'){
            module='asobi';
        }
        if(module=='majime'){
            task=con.substr(6,con.length-6);
        }
        else if(module=='asobi'||module=='admin'){
            task=con.substr(5,con.length-5);
        }        
        arr=$.cookies.filter();       
        for (var key in arr) {        
            if(key!='id'&&key!='passwd'&&key!='PHPSESSID'){                
                    if(
                            act=='index'
                            ||act=='detail'
                            ||act=='detail_result'
                            ||act=='detail_ado'
                            ||act=='addconfirm'
                            ||act=='listindex'
                            ||act=='pw'
                            ||act=='pw_complete'
                            ||act=='error'
                            ||act=='logout'
                            ||act=='categories'
                            ||act=='categoryedit'
                            ||act=='categoryregist'
                            ||act=='category_edit'
                            ||act=='category_regist'
                    ){//not in xxx<->xxxconfirm                    
                        $.cookies.del(key);                                                
                    }
                    else{ 
                        temp=key.split('_');
                        if(temp.length>1){
                            str1=temp[0];                            
                            if(str1!=task){                                
                                $.cookies.del(key);
                            }
                            
                        }

                    }
                
                
                
            }
        }*/
    
      
       ul=$("div.pagination").find('ul').eq(0);
       page='<?php echo Yii::app()->request->getParam('page');?>';
       pageCount=$("input#page_count").val();
           $('div.pagination ul li.selected').removeClass('selected');
            $('div.pagination ul li').removeClass('page');
            $('div.pagination ul li').removeClass('previous');
            $('div.pagination ul li').removeClass('next');
            $('div.pagination ul li').removeClass('last');
            $('div.pagination ul li').removeClass('first');
            $('div.pagination ul li').removeClass('hidden');
            $('div.pagination ul').removeClass('yiiPager');  
        
        if(page=='1'||page==''){ 
            
                $('div.pagination ul').find('li').eq(0).addClass('disabled');
                $('div.pagination ul').find('li').eq(1).addClass('disabled');
                $('div.pagination ul').find('li').eq(2).addClass('active');
        }       
        else{
            lis=$('div.pagination').find('ul').eq(0).find('li');

            for(i=0,n=lis.length;i<n;i++){
                
                if($(lis[i]).find('a').eq(0).html()==page){
                    $(lis[i]).addClass('active');
                    if(page==pageCount){
                        $(lis[i]).next().addClass('disabled');
                        $(lis[i]).next().next().addClass('disabled');                      
                    }
                   
                }
            }
        } 
        
       
        
    });
var unitedit_from= getCookie("unitedit_from");
if(unitedit_from !="" && unitedit_from !=null && unitedit_from !='null'){
	deleteCookies("unitedit_from");	
} 
var office_edit_from= getCookie("office_edit_from");
if(office_edit_from !="" && office_edit_from !=null && office_edit_from !='null'){
	deleteCookies("office_edit_from");	
} 
var office_regist_from= getCookie("office_regist_from");
if(office_regist_from !="" && office_regist_from !=null && office_regist_from !='null'){
	deleteCookies("office_regist_from");	
} 
var base_edit_from= getCookie("unit_edit_from");
if(base_edit_from !="" && base_edit_from !=null && base_edit_from !='null'){
	deleteCookies("unit_edit_from");	
} 
var base_regist_from= getCookie("unit_regist_from");
if(base_regist_from !="" && base_regist_from !=null && base_regist_from !='null'){
	deleteCookies("unit_regist_from");	
}


</script>

</body>
</html>