<?php
//include 'define_path_upload.php';
/**
 * constants.php
 * Default value is constants
 * @Author Hainhl
 * Company GMO Runsystem
 * @since 1.0 - 20130703
 */
class Constants 
{
    public static $asobi_footer_twitter_keyword=array(
        '花の慶次'=>'txt1',
        'ダルマッシュ'=>'txt1',
        'パチンコ'=>'txt2',
        '影の軍団～疾風驀進～'=>'txt1',
        'CR COBRA'=>'txt3',
        'CR 眠狂四郎'=>'txt1',
        'GO!GO! 郷Ⅲ'=>'txt3',
        '真田純勇士すぺしゃる'=>'txt3',
        '長七郎江戸日記'=>'txt2',
        'アニメ人気'=>'txt1',
        '演出最高'=>'txt2',
        'パチンコ'=>'txt2',
        '希望出玉'=>'txt3',
        'パチンコ新台'=>'txt1',
        '噂'=>'txt2',
        'パチンコ'=>'txt2',
        '潜伏'=>'txt3',
        'パチンコ情報'=>'txt2',
        'cr'=>'txt3',
        '注目映画'=>'txt2',
        'サイボーグ009'=>'txt1',
        'トライガン'=>'txt2',
        '漫画ランキング'=>'txt3',
        '野生の王国'=>'txt2',
        '未来少年コナン'=>'txt3',
        '西部警察3'=>'txt1',
        '佐武と市捕物控'=>'txt3',
        'パチスロ兎'=>'txt1',
        '話題ドラマ'=>'txt2',
        '天誅'=>'txt1',
        'パチスロメーカ'=>'txt1',
        'センゴク'=>'txt3',
        '回胴記'=>'txt2',
        'パチンコ動画'=>'txt1',
        'パチンコ中古'=>'txt2',
        'パチンコ実機'=>'txt1',
        'パチスロ動画'=>'txt1',
        'newgin'=>'txt2',
    );
    /*contain title in modules*/
        public static $module_tile_array=array(
          'claim'=>'お客様クレーム',
          'criticism'=>'機種総評＆検証',
          'enquete'=>'みんなのアンケートBOX',
          'ideas'=>'製品アイデア投稿広場',
          'newitem'=>'新商品情報',
          'president_msg'=>'新井社長メッセージ',
          'report'=>'リアルタイム社内報告',
          'rival'=>'競合情報',  
          'soumu_news'=>'総務からのお知らせ',
          'soumu_qa'=>'教えて総務さん！FAQ',
          'to_officer'=>'役員宛目安箱',
          'trouble'=>'トラブル＆不正情報',  
          'bbs'=>'ニューギン掲示板',  
          'bounty'=>'懸賞金付き募集コンテンツ',         
         'share_item' => '共有事項',
         'zentaishihyou' => '全体指標',
         'pride' => 'あそびにマジメ！？あそび自慢＆対決！',
            'golf_news'=>'ゴルフもマジメ！',
            'hobby_new'=>"趣味・サークルの広場What'sNew",
            'hobby_itd'=>'趣味・サークル広場サークル紹介',
           
        

        );
        /*Type bounty apply*/
	public static $typeBountyApply = array(
	'1'	=> '全て公開',//hien thi toan bo cac apply
	'2'	=> '採用のみ公開',//chi hien thi apply nao duoc chon
	'3'	=> '非公開',//chi hien thi comment
	);
	
	/*Type New Item*/
	public static $typeNewItem = array(
	'1'	=> '記事',
	'2'	=> 'リンク',
	);
	/*Type enquete*/
	public static $typeEnquete = array(
	'1'	=> '択一回答',
	'2'	=> '複数回答',
	);
	
	/*Type category*/
	public static $typeCategory = array(
	'1'	=> 'マジメ：お祝い',
	'2'	=> 'マジメ： 総務QA',
	'3'	=> 'マジメ： 総務人事',	
	'4'	=> 'あそび：資格取得',
	'5'	=> 'あそび：ゴルフもマジメ　お知らせ',
	'6'	=> 'あそび：趣味・サークルの広場：What is New',
	'7'	=> 'リンク集',
	);
	
	/*Type Icon report*/
	public static $typeIconReport = array(
	'1'	=> 'HELP',
	'2'	=> '営業',
	'3'	=> 'うわさ',
	'4'	=> '製造',
	'5'	=> '行政',
	'6'	=> 'ホール',
	'7'	=> '開発',
	'8'	=> '他',
	);
	
	/*Type image file*/
	public static $imgExtention=array("gif","jpg","png","jpeg","GIF","JPG","PNG","JPEG");
	/*Type zip file*/
	public static $zipExtention=array("zip","rar");
	/*Type word file*/
	public static $wordExtention=array("doc","docx");
	/*Type pdf file*/
	public static $pdfExtention=array("pdf");
	/*Type Excel file*/
	public static $excelExtention=array("xls","xlsx");
	/*Type Powerpoint file*/
	public static $powerpointExtention=array("ppt","pptx");
    //Base role
    public static $baserole=array("view"=>1,"post"=>2,"admin"=>3);
    //Admin role
    
    public static $adminRole=array(
     "1"=>"管理者"
    );
	 /*Type modifiable_flag */
	public static $typemodifiable_flag = array(
	'1'	=> '有効',
	'2'	=> '無効',
	'3'	=> '削除',
	);
}
