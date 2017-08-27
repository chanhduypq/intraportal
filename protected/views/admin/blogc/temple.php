<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.cookies.js"></script>
<script type="text/javascript">

    google.load('search', '1');

    var blogSearch;
    function searchComplete() {

        // Check that we got results

        if (blogSearch.results && blogSearch.results.length > 0) {
            for (var i = 0; i < blogSearch.results.length; i++) {
                jQuery("#blogc_form").append("<input type='hidden' name='blog_url[]' value='" + blogSearch.results[i].blogUrl + "'/>");
                jQuery("#blogc_form").append("<input type='hidden' name='title[]' value='" + blogSearch.results[i].title + "'/>");
            }
        }
        temple=getCookie("temple");
        if(temple=="1"){           
            window.location="<?php echo Yii::app()->baseUrl;?>/admin/";            
        }
        else if(temple=="0"){
            document.getElementById("blogc_form").submit();            
        }

    }

    function onLoad() {


        // Create a BlogSearch instance.
        blogSearch = new google.search.BlogSearch();

        // Set searchComplete as the callback function when a search is complete.  The
        // blogSearch object will have results in it.
        blogSearch.setSearchCompleteCallback(this, searchComplete, null);

        // Specify search quer(ies)
        blogSearch.setResultSetSize(<?php echo $number_of_news_per_keyword; ?>);

        blogSearch.execute('<?php echo $keyword; ?>');

        // Include the required Google branding
        google.search.Search.getBranding('branding');


    }

    // Set a callback to call your code when the page loads
    google.setOnLoadCallback(onLoad);
    
    

</script>
<form id="blogc_form" action="<?php echo Yii::app()->baseUrl; ?>/adminblogc/process" method="post">
    <input type="hidden" name="Twitter_blogc[keyword]" value="<?php echo $keyword; ?>"/>
</form>