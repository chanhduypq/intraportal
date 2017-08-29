
<script type="text/javascript">


    jQuery(function($) {
        $.urlParam = function(name){
          var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(top.window.location.href); 
          return (results !== null) ? results[1] : false;
        };        
        if($.urlParam("name_search")==false)
        {
            $('input[name="name_search"]').val('');
            $('input[name="name_search"]').attr('placeholder','社員番号、会社、部門、部署、氏名、ふりがなで検索できます');
        } 
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');
        $("body").attr('id', 'admin');

//		var trs=$(".table").eq(0).find("tr");
//		for(i=0,n=trs.length;i<n;i++){
//			html=$.trim($(trs[i]).find('td').eq(1).html());
//			if(html==""){
//				$(trs[i]).hide();
//			}
//		}
    });
</script>

<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount(); ?>"/>
<div class="wrap admin secondary user">

    <div class="container">
        <div class="contents index">

            <div class="mainBox detail">

                <div class="pageTtl">
                    <h2>ユーザー管理</h2>
                    <a href="<?php echo Yii::app()->baseUrl; ?>/adminuser/regist" class="btn btn-important"><i class="icon-pencil icon-white"></i> 登録</a>
                    <a href="<?php echo Yii::app()->baseUrl; ?>/adminuser/import" class="btn btn-important"><i class="icon-upload icon-white"></i> CSVインポート</a>
                    <div class="search">
                        <form  class="form-search" method="get" action="/adminuser/">
                            <?php
                            if(isset($_GET['name_search']) && $_GET['name_search'] !=""){
                                echo '<input name="name_search"  type="text" class="input-large search-query" value="'.$_GET['name_search'].'">';
                            }
                            else{
                                echo '<input name="name_search"  type="text" class="input-large search-query" placeholder="社員番号、会社、部門、部署、氏名、ふりがなで検索できます">';
                            }
                            ?>
<!--                            <input name="name_search"  type="text" class="input-large search-query" placeholder="社員番号、会社、部門、部署、氏名、ふりがなで検索できます">-->
                            <button type="submit" class="btn">
                                検索
                            </button>
                        </form>
                    </div>
                </div> 
                <div class="box">

                    <?php
//                    if(isset($_GET['name_search']) && $_GET['name_search'] !=""){
//                        echo "<div style='width:704px; text-align:left; font-weight:bold;'>検索キーワード：".$_GET['name_search']."</div>";
//                    }
                    if ($item_count < 1) {
                        ?>
                        <table width="724" border="0" class="table list font14">
                            <thead>
                                <tr><th>社員番号</th><th>所属部署</th><th>氏名 / 役割</th><th>編集</th></tr>
                            </thead>
                            <tbody>       
                                <tr class="item"><td colspan="4" align="center"> <span style="padding-left:310px;"><?php echo Lang::MSG_0118; ?></span></td></tr>
                            </tbody>
                        </table>           
                        <?php
                    } else {
                        ?>
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table list font14">
                            <thead>
                                <tr><th>社員番号</th><th>所属部署</th><th>氏名 / 役割</th><th>編集</th></tr>
                            </thead>
                            <tbody>       
                                <?php
                                if ($users != null && is_array($users) && count($users) > 0) {

                                    foreach ($users as $user) {
                                        ?>


                                        <tr class="item">
                                            <td class="employee_number td-contents alnC"><?php echo $user['employee_number']; ?></td>
                                            <td class="department">

            <?php
            $rows=Yii::app()->db->createCommand("select `unit`.`unit_name` AS `unit_name`,`branch`.`branch_name` AS `branch_name`,`base`.`company_name` AS `company_name` from ((((`user` join `role` on((`role`.`id` = `user`.`role_id`))) left join `unit` on(((`unit`.`id` = `user`.`division1`) or (`unit`.`id` = `user`.`division2`) or (`unit`.`id` = `user`.`division3`) or (`unit`.`id` = `user`.`division4`)))) left join `branch` on((`branch`.`id` = `unit`.`branch_id`))) left join `base` on((`base`.`id` = `branch`.`base_id`))) where ((`unit`.`id` is not null) and (`base`.`id` is not null) and (`branch`.`id` is not null)) and `user`.id=".$user['id'])
                    ->queryAll();
            if(is_array($rows)&&count($rows)>0){
                foreach ($rows as $row){
                    echo "<p>" . $row['company_name'] . "&nbsp;" . $row['branch_name'] . "&nbsp;" . $row['unit_name'] . "</p>";
                }
            }
            

            
//										foreach($unit as $units){
//											if($user['division1']==$units['id']){
//												echo "<p>".$units['company_name']."&nbsp;".$units['branch_name']."&nbsp;".$units['unit_name']."</p>";
//											}
//										
//											if($user['division2']==$units['id']){
//												echo "<p>".$units['company_name']."&nbsp;".$units['branch_name']."&nbsp;".$units['unit_name']."</p>";
//											}
//										
//											if($user['division3']==$units['id']){
//												echo "<p>".$units['company_name']."&nbsp;".$units['branch_name']."&nbsp;".$units['unit_name']."</p>";
//											}
//										
//											if($user['division4']==$units['id']){
//												echo "<p>".$units['company_name']."&nbsp;".$units['branch_name']."&nbsp;".$units['unit_name']."</p>";
//											}
//                                                                                }
            ?>

                                            </td>
                                            <td class="parson td-contents">
                                                <p class="name text-center">
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminuser/detail/?id=<?php echo $user['id']; ?>"><?php echo $user['lastname'] . ' ' . $user['firstname']; ?></a>
                                                </p>
                                                <p class="role text-center">
            <?php echo $user['role_name']; ?>
                                                </p>
                                            </td>
                                            <td class="td-edit">

                                                <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/adminuser/edit/?id=<?php echo $user['id']; ?>">修正</a>
                                                <a onclick="if (confirm('削除します。よろしいですか？') == true)
                                                            window.location = '<?php echo Yii::app()->request->baseUrl; ?>/adminuser/delete/?id=<?php echo $user['id']; ?>';" href="#" class="btn btn-correct">削除</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody></table>
    <?php
    if ($item_count > $page_size) {
        ?>
                            <div class="pagination">
                            <?php
                            $this->widget('CLinkPager', array(
                                'currentPage' => $pages->getCurrentPage(),
                                'itemCount' => $item_count,
                                'pageSize' => $page_size,
                                'maxButtonCount' => 5,
                                'nextPageLabel' => 'Next',
                                'prevPageLabel' => 'Prev',
                                'lastPageLabel' => 'Last',
                                'firstPageLabel' => 'First',
                                'header' => '',
                                'htmlOptions' => array('class' => 'yiiPager'),
                            ));
                            ?>
                            </div>
                                <?php
                            }
                        } //end $item_count > 0
                        ?>    
                    <?php echo CHtml::endForm(); ?>

                </div>
            </div>

            <div class="sideBox">
                <ul>
                    <li>
<?php $this->widget('MenuManager'); ?>
                        <?php $this->widget('AffairsManage'); ?>
                        <?php $this->widget('SystemManage'); ?>
                        <?php $this->widget('PostedByContentManage'); ?>
                    </li>
                </ul>
            </div><!-- /sideBox -->

        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>

