jQuery.fn.swapWith = function(to) {
    return this.each(function() {
        var copy_to = $(to).clone(true);
        var copy_from = $(this).clone(true);
        $(to).replaceWith(copy_from);
        $(this).replaceWith(copy_to);
    });
};
jQuery(function($) 
{
    $("td.updown a").removeAttr("href");
    $("td.updown a").css("text-decoration","underline");
     $("td.updown a").mouseover(function(){          
        $(this).css("text-decoration","none"); 
     });
     $("td.updown a").mouseout(function(){          
        $(this).css("text-decoration","underline"); 
     });
   $("td.updown a.up-btn").click(function(){          
            id1=$(this).parents("tr").eq(0).attr("id");
            if($(this).parents("tr").eq(0).prev()==null||$(this).parents("tr").eq(0).prev()==undefined){               
                return;
            }
            id2=$(this).parents("tr").eq(0).prev().attr("id");
            $("input#id1").val(id1);
            $("input#id2").val(id2);  
            
            $(this).parents("tr").eq(0).swapWith($(this).parents("tr").eq(0).prev());
            
            
            $.ajax({
                type: "POST", 
                async:true,
                url: $("form#up-down").attr("action"), 
                data: jQuery('#up-down').serialize()
            });
            
            
        });
		
        $("td.updown a.down-btn").click(function(){             
            id1=$(this).parents("tr").eq(0).attr("id");
            if($(this).parents("tr").eq(0).next()==null||$(this).parents("tr").eq(0).next()==undefined){
                return;
            }
            id2=$(this).parents("tr").eq(0).next().attr("id");
            $("input#id1").val(id1);
            $("input#id2").val(id2);   
            
            $(this).parents("tr").eq(0).swapWith($(this).parents("tr").eq(0).next());
            $.ajax({
                type: "POST", 
                async:true,
                url: $("form#up-down").attr("action"), 
                data: jQuery('#up-down').serialize()
            });
            
        });
        
});