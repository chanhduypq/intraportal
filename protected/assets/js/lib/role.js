 function validateCheckBox(){
        var numOfFunction=$("div.control-group").length;
        var check =false;
        for(var i=1;i<=numOfFunction;i++){
            if($("input#chbview_"+i).is(":checked") || $("input#chbpost_"+i).is(":checked") ||$("input#chbadmin_"+i).is(":checked")){
               check=true; 
            }
        }
        return check;
    }
    function getCheckboxData()
    {
    	
		var arrData={};
		var j=0;
		var numOfFunction=$("div.control-group").length;
        var check =false;
        for(var i=1;i<=numOfFunction;i++){
            if($("input#chbview_"+i).is(":checked") || $("input#chbpost_"+i).is(":checked") ||$("input#chbadmin_"+i).is(":checked")){
               var arrCheck={};
               arrCheck['1']=0;
               arrCheck['2']=0;
               arrCheck['3']=0;
               arrCheck['id']=i;
               if($("input#chbview_"+i).is(":checked")){
                    arrCheck['1']=1;
               }
               if($("input#chbpost_"+i).is(":checked")){
                    arrCheck['2']=1;
               }
               if($("input#chbadmin_"+i).is(":checked")){
                    arrCheck['3']=1;
               }
               arrData[j]=arrCheck;
               j++;
            }
        }	
		var str2=JSON.stringify(arrData);
        	return str2;
	    
    }