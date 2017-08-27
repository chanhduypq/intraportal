<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	jQuery(function($) 
	{
		$("body").attr('id','majime');      
	});
</script>
<?php $index=Yii::app()->baseUrl.'/majime/index'?>
<div class="wrap majime secondary">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox detail">
				<?php switch ($error['code']) 
				{
					case 401:
						echo '<div class="pageTtl">';
						echo '<h2>アクセス権がありません。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページはアクセス権がありませんので表示する事が出来ません。';
						echo '</div>';
					break;	
					case 404:
						echo '<div class="pageTtl">';
						echo '<h2>ページが見つかりませんでした。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページは一時的にアクセス出来ない状況にあるか、移動もしくは削除された可能性があります。';
						echo '</div>';
					break;
					case 405:
						echo '<div class="pageTtl">';
						echo '<h2>アクセス権がありません。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページはアクセス権がありませんので表示する事が出来ません。';
						echo '</div>';
					break;
					case 408:
						echo '<div class="pageTtl">';
						echo '<h2>アクセス権がありません。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページはアクセス権がありませんので表示する事が出来ません。';
						echo '</div>';
					break;
					case 500:
						echo '<div class="pageTtl">';
						echo '<h2>アクセス権がありません。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページはアクセス権がありませんので表示する事が出来ません。';
						echo '</div>';
					break;
					case 501:
						echo '<div class="pageTtl">';
						echo '<h2>アクセス権がありません。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページはアクセス権がありませんので表示する事が出来ません。';
						echo '</div>';
					break;
					case 503:
						echo '<div class="pageTtl">';
						echo '<h2>アクセス権がありません。</h2>';
						echo '<span>';
						echo '<a href='.$index.' class="btn btn-important">';
						echo '<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>';
						echo '</span>';
						echo '</div>';
						echo '<div class="box">';
						echo '大変申し訳ありません。<br />';
						echo 'お探しのページはアクセス権がありませんので表示する事が出来ません。';
						echo '</div>';
					break;
				}
				?>
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->

