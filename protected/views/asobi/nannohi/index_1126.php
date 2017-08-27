 


<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
    jQuery(function($)
    {
        $("body").attr('id', 'asobi');
    });
</script>
<?php
$countries = array(
    'AND' => array('code' => 'AD', 'name' => 'アンドラ'),
    'ARE' => array('code' => 'AE', 'name' => 'アラブ首長国連邦'),
    'AFG' => array('code' => 'AF', 'name' => 'アフガニスタン'),
    'ATG' => array('code' => 'AG', 'name' => 'アンティグア・バーブーダ'),
    'ALB' => array('code' => 'AL', 'name' => 'アルバニア'),
    'ARM' => array('code' => 'AM', 'name' => 'アルメニア'),
    'AGO' => array('code' => 'AO', 'name' => 'アンゴラ'),
    'ARG' => array('code' => 'AR', 'name' => 'アルゼンチン'),
    'AUT' => array('code' => 'AT', 'name' => 'オーストリア'),
    'AUS' => array('code' => 'AU', 'name' => 'オーストラリア'),
    'AZE' => array('code' => 'AZ', 'name' => 'アゼルバイジャン'),
    'BIH' => array('code' => 'BA', 'name' => 'ボスニア・ヘルツェゴビナ'),
    'BRB' => array('code' => 'BB', 'name' => 'バルバドス'),
    'BGD' => array('code' => 'BD', 'name' => 'バングラデシュ'),
    'BEL' => array('code' => 'BE', 'name' => 'ベルギー'),
    'BFA' => array('code' => 'BF', 'name' => 'ブルキナファソ'),
    'BGR' => array('code' => 'BG', 'name' => 'ブルガリア'),
    'BHR' => array('code' => 'BH', 'name' => 'バーレーン'),
    'BDI' => array('code' => 'BI', 'name' => 'ブルンジ'),
    'BEN' => array('code' => 'BJ', 'name' => 'ベナン'),
    'BRN' => array('code' => 'BN', 'name' => 'ブルネイ'),
    'BOL' => array('code' => 'BO', 'name' => 'ボリビア'),
    'BRA' => array('code' => 'BR', 'name' => 'ブラジル'),
    'BHS' => array('code' => 'BS', 'name' => 'バハマ'),
    'BTN' => array('code' => 'BT', 'name' => 'ブータン'),
    'BWA' => array('code' => 'BW', 'name' => 'ボツワナ'),
    'BLR' => array('code' => 'BY', 'name' => 'ベラルーシ'),
    'BLZ' => array('code' => 'BZ', 'name' => 'ベリーズ'),
    'CAN' => array('code' => 'CA', 'name' => 'カナダ'),
    'COD' => array('code' => 'CD', 'name' => 'コンゴ（旧ザイール）'),
    'CAF' => array('code' => 'CF', 'name' => '中央アフリカ'),
    'COG' => array('code' => 'CG', 'name' => 'コンゴ共和国'),
    'CHE' => array('code' => 'CH', 'name' => 'スイス'),
    'CIV' => array('code' => 'CI', 'name' => 'コートジボワール'),
    'COK' => array('code' => 'CK', 'name' => 'クック諸島'),
    'CHL' => array('code' => 'CL', 'name' => 'チリ'),
    'CMR' => array('code' => 'CM', 'name' => 'カメルーン'),
    'CHN' => array('code' => 'CN', 'name' => '中国'),
    'COL' => array('code' => 'CO', 'name' => 'コロンビア'),
    'CRI' => array('code' => 'CR', 'name' => 'コスタリカ'),
    'CUB' => array('code' => 'CU', 'name' => 'キューバ'),
    'CPV' => array('code' => 'CV', 'name' => 'カーボヴェルデ'),
    'CYP' => array('code' => 'CY', 'name' => 'キプロス'),
    'CZE' => array('code' => 'CZ', 'name' => 'チェコ'),
    'DEU' => array('code' => 'DE', 'name' => 'ドイツ'),
    'DJI' => array('code' => 'DJ', 'name' => 'ジブチ'),
    'DNK' => array('code' => 'DK', 'name' => 'デンマーク'),
    'DMA' => array('code' => 'DM', 'name' => 'ドミニカ国'),
    'DOM' => array('code' => 'DO', 'name' => 'ドミニカ共和国'),
    'DZA' => array('code' => 'DZ', 'name' => 'アルジェリア'),
    'ECU' => array('code' => 'EC', 'name' => 'エクアドル'),
    'EST' => array('code' => 'EE', 'name' => 'エストニア'),
    'EGY' => array('code' => 'EG', 'name' => 'エジプト'),
    'ERI' => array('code' => 'ER', 'name' => 'エリトリア'),
    'ESP' => array('code' => 'ES', 'name' => 'スペイン'),
    'ETH' => array('code' => 'ET', 'name' => 'エチオピア'),
    'FIN' => array('code' => 'FI', 'name' => 'フィンランド'),
    'FJI' => array('code' => 'FJ', 'name' => 'フィジー'),
    'FSM' => array('code' => 'FM', 'name' => 'ミクロネシア'),
    'FRA' => array('code' => 'FR', 'name' => 'フランス'),
    'GAB' => array('code' => 'GA', 'name' => 'ガボン'),
    'GBR' => array('code' => 'GB', 'name' => 'イギリス'),
    'GRD' => array('code' => 'GD', 'name' => 'グレナダ'),
    'GEO' => array('code' => 'GE', 'name' => 'グルジア'),
    'GHA' => array('code' => 'GH', 'name' => 'ガーナ'),
    'GMB' => array('code' => 'GM', 'name' => 'ガンビア'),
    'GIN' => array('code' => 'GN', 'name' => 'ギニア'),
    'GNQ' => array('code' => 'GQ', 'name' => '赤道ギニア'),
    'GRC' => array('code' => 'GR', 'name' => 'ギリシャ'),
    'GTM' => array('code' => 'GT', 'name' => 'グアテマラ'),
    'GNB' => array('code' => 'GW', 'name' => 'ギニアビサウ'),
    'GUY' => array('code' => 'GY', 'name' => 'ガイアナ'),
    'HKG' => array('code' => 'HK', 'name' => '香港'),
    'HND' => array('code' => 'HN', 'name' => 'ホンジュラス'),
    'HRV' => array('code' => 'HR', 'name' => 'クロアチア'),
    'HTI' => array('code' => 'HT', 'name' => 'ハイチ'),
    'HUN' => array('code' => 'HU', 'name' => 'ハンガリー'),
    'IDN' => array('code' => 'ID', 'name' => 'インドネシア'),
    'IRL' => array('code' => 'IE', 'name' => 'アイルランド'),
    'ISR' => array('code' => 'IL', 'name' => 'イスラエル'),
    'IND' => array('code' => 'IN', 'name' => 'インド'),
    'IRQ' => array('code' => 'IQ', 'name' => 'イラク'),
    'IRN' => array('code' => 'IR', 'name' => 'イラン'),
    'ISL' => array('code' => 'IS', 'name' => 'アイスランド'),
    'ITA' => array('code' => 'IT', 'name' => 'イタリア'),
    'JAM' => array('code' => 'JM', 'name' => 'ジャマイカ'),
    'JOR' => array('code' => 'JO', 'name' => 'ヨルダン'),
    'JPN' => array('code' => 'JP', 'name' => '日本'),
    'KEN' => array('code' => 'KE', 'name' => 'ケニア'),
    'KGZ' => array('code' => 'KG', 'name' => 'キルギス'),
    'KHM' => array('code' => 'KH', 'name' => 'カンボジア'),
    'KIR' => array('code' => 'KI', 'name' => 'キリバス'),
    'COM' => array('code' => 'KM', 'name' => 'コモロ'),
    'KNA' => array('code' => 'KN', 'name' => 'セントクリストファー・ネーヴィス'),
    'KOS' => array('code' => 'KO', 'name' => 'コソボ'),
    'PRK' => array('code' => 'KP', 'name' => '北朝鮮'),
    'KOR' => array('code' => 'KR', 'name' => '韓国'),
    'KWT' => array('code' => 'KW', 'name' => 'クウェート'),
    'KAZ' => array('code' => 'KZ', 'name' => 'カザフスタン'),
    'LAO' => array('code' => 'LA', 'name' => 'ラオス'),
    'LBN' => array('code' => 'LB', 'name' => 'レバノン'),
    'LCA' => array('code' => 'LC', 'name' => 'セントルシア'),
    'LIE' => array('code' => 'LI', 'name' => 'リヒテンシュタイン'),
    'LKA' => array('code' => 'LK', 'name' => 'スリランカ'),
    'LBR' => array('code' => 'LR', 'name' => 'リベリア'),
    'LSO' => array('code' => 'LS', 'name' => 'レソト'),
    'LTU' => array('code' => 'LT', 'name' => 'リトアニア'),
    'LUX' => array('code' => 'LU', 'name' => 'ルクセンブルク'),
    'LVA' => array('code' => 'LV', 'name' => 'ラトビア'),
    'LBY' => array('code' => 'LY', 'name' => 'リビア'),
    'MAR' => array('code' => 'MA', 'name' => 'モロッコ'),
    'MCO' => array('code' => 'MC', 'name' => 'モナコ'),
    'MDA' => array('code' => 'MD', 'name' => 'モルドバ'),
    'MNE' => array('code' => 'ME', 'name' => 'モンテネグロ'),
    'MDG' => array('code' => 'MG', 'name' => 'マダガスカル'),
    'MHL' => array('code' => 'MH', 'name' => 'マーシャル'),
    'MKD' => array('code' => 'MK', 'name' => 'マケドニア'),
    'MLI' => array('code' => 'ML', 'name' => 'マリ'),
    'MMR' => array('code' => 'MM', 'name' => 'ミャンマー'),
    'MNG' => array('code' => 'MN', 'name' => 'モンゴル'),
    'MAC' => array('code' => 'MO', 'name' => 'マカオ'),
    'MRT' => array('code' => 'MR', 'name' => 'モーリタニア'),
    'MLT' => array('code' => 'MT', 'name' => 'マルタ'),
    'MUS' => array('code' => 'MU', 'name' => 'モーリシャス'),
    'MDV' => array('code' => 'MV', 'name' => 'モルディブ'),
    'MWI' => array('code' => 'MW', 'name' => 'マラウイ'),
    'MEX' => array('code' => 'MX', 'name' => 'メキシコ'),
    'MYS' => array('code' => 'MY', 'name' => 'マレーシア'),
    'MOZ' => array('code' => 'MZ', 'name' => 'モザンビーク'),
    'NAM' => array('code' => 'NA', 'name' => 'ナミビア'),
    'NER' => array('code' => 'NE', 'name' => 'ニジェール'),
    'NGA' => array('code' => 'NG', 'name' => 'ナイジェリア'),
    'NIC' => array('code' => 'NI', 'name' => 'ニカラグア'),
    'NLD' => array('code' => 'NL', 'name' => 'オランダ'),
    'NOR' => array('code' => 'NO', 'name' => 'ノルウェー'),
    'NPL' => array('code' => 'NP', 'name' => 'ネパール'),
    'NRU' => array('code' => 'NR', 'name' => 'ナウル'),
    'NIU' => array('code' => 'NU', 'name' => 'ニウエ'),
    'NZL' => array('code' => 'NZ', 'name' => 'ニュージーランド'),
    'OMN' => array('code' => 'OM', 'name' => 'オマーン'),
    'PAN' => array('code' => 'PA', 'name' => 'パナマ'),
    'PER' => array('code' => 'PE', 'name' => 'ペルー'),
    'PNG' => array('code' => 'PG', 'name' => 'パプアニューギニア'),
    'PHL' => array('code' => 'PH', 'name' => 'フィリピン'),
    'PAK' => array('code' => 'PK', 'name' => 'パキスタン'),
    'POL' => array('code' => 'PL', 'name' => 'ポーランド'),
    'PSE' => array('code' => 'PS', 'name' => 'パレスチナ'),
    'PRT' => array('code' => 'PT', 'name' => 'ポルトガル'),
    'PLW' => array('code' => 'PW', 'name' => 'パラオ'),
    'PRY' => array('code' => 'PY', 'name' => 'パラグアイ'),
    'QAT' => array('code' => 'QA', 'name' => 'カタール'),
    'ROU' => array('code' => 'RO', 'name' => 'ルーマニア'),
    'SRB' => array('code' => 'RS', 'name' => 'セルビア'),
    'RUS' => array('code' => 'RU', 'name' => 'ロシア'),
    'RWA' => array('code' => 'RW', 'name' => 'ルワンダ'),
    'SAU' => array('code' => 'SA', 'name' => 'サウジアラビア'),
    'SLB' => array('code' => 'SB', 'name' => 'ソロモン諸島'),
    'SYC' => array('code' => 'SC', 'name' => 'セーシェル'),
    'SDN' => array('code' => 'SD', 'name' => 'スーダン'),
    'SWE' => array('code' => 'SE', 'name' => 'スウェーデン'),
    'SGP' => array('code' => 'SG', 'name' => 'シンガポール'),
    'SVN' => array('code' => 'SI', 'name' => 'スロベニア'),
    'SVK' => array('code' => 'SK', 'name' => 'スロバキア'),
    'SLE' => array('code' => 'SL', 'name' => 'シエラレオネ'),
    'SMR' => array('code' => 'SM', 'name' => 'サンマリノ'),
    'SEN' => array('code' => 'SN', 'name' => 'セネガル'),
    'SOM' => array('code' => 'SO', 'name' => 'ソマリア'),
    'SUR' => array('code' => 'SR', 'name' => 'スリナム'),
    'STP' => array('code' => 'ST', 'name' => 'サントメ・プリンシペ'),
    'SLV' => array('code' => 'SV', 'name' => 'エルサルバドル'),
    'SYR' => array('code' => 'SY', 'name' => 'シリア'),
    'SWZ' => array('code' => 'SZ', 'name' => 'スワジランド'),
    'TCD' => array('code' => 'TD', 'name' => 'チャド'),
    'TGO' => array('code' => 'TG', 'name' => 'トーゴ'),
    'THA' => array('code' => 'TH', 'name' => 'タイ'),
    'TJK' => array('code' => 'TJ', 'name' => 'タジキスタン'),
    'TLS' => array('code' => 'TL', 'name' => '東ティモール'),
    'TKM' => array('code' => 'TM', 'name' => 'トルクメニスタン'),
    'TUN' => array('code' => 'TN', 'name' => 'チュニジア'),
    'TON' => array('code' => 'TO', 'name' => 'トンガ'),
    'TUR' => array('code' => 'TR', 'name' => 'トルコ'),
    'TTO' => array('code' => 'TT', 'name' => 'トリニダード・トバゴ'),
    'TUV' => array('code' => 'TV', 'name' => 'ツバル'),
    'TWN' => array('code' => 'TW', 'name' => '台湾'),
    'TZA' => array('code' => 'TZ', 'name' => 'タンザニア'),
    'UKR' => array('code' => 'UA', 'name' => 'ウクライナ'),
    'UGA' => array('code' => 'UG', 'name' => 'ウガンダ'),
    'USA' => array('code' => 'US', 'name' => 'アメリカ'),
    'URY' => array('code' => 'UY', 'name' => 'ウルグアイ'),
    'UZB' => array('code' => 'UZ', 'name' => 'ウズベキスタン'),
    'VAT' => array('code' => 'VA', 'name' => 'バチカン'),
    'VCT' => array('code' => 'VC', 'name' => 'セントビンセント・グレナディーン'),
    'VEN' => array('code' => 'VE', 'name' => 'ベネズエラ'),
    'VNM' => array('code' => 'VN', 'name' => 'ベトナム'),
    'VUT' => array('code' => 'VU', 'name' => 'バヌアツ'),
    'WSM' => array('code' => 'WS', 'name' => 'サモア'),
    'ARE' => array('code' => 'AE', 'name' => 'アラブ首長国連邦'),
    'AFG' => array('code' => 'AF', 'name' => 'アフガニスタン'),
    'ATG' => array('code' => 'AG', 'name' => 'アンティグア・バーブーダ'),
    'ALB' => array('code' => 'AL', 'name' => 'アルバニア'),
    'ARM' => array('code' => 'AM', 'name' => 'アルメニア'),
    'WORLD' => array('code' => 'World', 'name' => '世界'),
    'DDR' => array('code' => 'DDR', 'name' => '東ドイツ'),
    'GHA' => array('code' => 'GHA', 'name' => 'ガーナ'),
    'CHN' => array('code' => 'CHN', 'name' => '中国'),
    'ROC' => array('code' => 'ROC', 'name' => '中華民国'),
    'ZAF' => array('code' => 'ZAF', 'name' => '南アフリカ共和国'),
);


$xml = new SimpleXmlElement($data);
foreach ($xml->page->revision as $entry) {
    $data = $entry->text;
}

function getContendText($inputstr, $delimeterLeft, $delimeterRight) {
    $posLeft = stripos($inputstr, $delimeterLeft) + strlen($delimeterLeft);
    $posRight = stripos($inputstr, $delimeterRight, $posLeft + 1);
    return substr($inputstr, $posLeft, $posRight - $posLeft);
}

function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            asort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}
?>
<div class="wrap asobi secondary nannohi">

    <div class="container">
        <div class="contents index">

            <div class="mainBox">
                <div class="pageTtl">
                    <h2>
                        今日(<?php echo date('n') ?>月<?php echo date('j') ?>日）は何の日
                    </h2>
                    <a href="<?php echo Yii::app()->baseUrl ?>/asobi" class="btn btn-important">
                        <i class="icon-home icon-white">
                        </i> あそびのTopへ戻る
                    </a>
                </div>
                <div class="box">
<?php
$data=  str_replace("== フィクションのできごと ==", "== フィクションのできごと ==|g_m_o_r_u_n_s_y_s_t_e_m", $data);
$data = getContendText($data, "日", "|g_m_o_r_u_n_s_y_s_t_e_m");
$data = preg_replace('~<!--.+?-->~s', '', $data);
//$data = preg_replace('~&lt;!--.+?--&gt;~s', '', $data);
preg_match_all("'== (.*?) =='si", $data, $match);
$arrTitle = array();
foreach ($match[1] as $key => $value) {
    switch ($value) {
        case 'できごと':
            $arrTitle[] = array("title" => $value, "order" => 0);
            break;
        case '記念日・年中行事':
            $arrTitle[] = array("title" => $value, "order" => 1);
            break;
        case '誕生日':
            $arrTitle[] = array("title" => $value, "order" => 2);
            break;
        case '忌日':
            $arrTitle[] = array("title" => $value, "order" => 3);
            break;
    }
}

if(count($arrTitle)==3){
    $arrTitle[] = array("title" => '記念日・年中行事', "order" => 1);
}
$arrTitle = msort($arrTitle, array('order'));
foreach ($arrTitle as $value){
    ?>
                        <div class="section">   
                            <h3><?php echo htmlspecialchars($value['title']); ?></h3>
                        <?php
                        
                        switch ($value['title']) {
                            case 'できごと':
                                $text = getContendText($data, "== できごと ==", "== 誕生日 ==");
                                break;
                            case '誕生日':
                                $text = getContendText($data, "== 誕生日 ==", "== 忌日 ==");                                
                                break;
                            case '忌日':
                                $text = getContendText($data, "== 忌日 ==", "== 記念日・年中行事 ==");
                                break;
                            case '記念日・年中行事':
                                $text = getContendText($data, "== 記念日・年中行事 ==", "== フィクションのできごと ==");                                
                                break;
                        }
//echo $text;
                        $text=remove_string_clear($text);

//                        $text=remove_string_img($text);
                        
                        $text = remove_img($text); 

                      

                        
                        
                        

//echo '<br>----------------------------------------------------<br>'.$text.'<br>';
                        $line_of_text = explode("\n", $text);
                        ?>
                            <ul class="unstyled">
                            <?php 
                            for ($i=0,$n=count($line_of_text);$i<$n;$i++){         
                                $line_view= build_line($line_of_text[$i],$countries);
                                if(trim($line_view)!=""){     
//                                    echo $line_of_text[$i].'<br>'.  mb_strlen ($line_of_text[$i]).'<br>';
                                    
                                    $line_view=  str_replace("* ", "", $line_view);
                                    $line_view=  str_replace("*: ", "&nbsp;&nbsp;", $line_view);
                                    $line_view=  str_replace("*:", "&nbsp;&nbsp;", $line_view);
                                    $line_view=  str_replace("*", "", $line_view);
                                    $line_view=  str_replace(": ", "", $line_view);
                                    $line_view=  str_replace("; ", "", $line_view);
                                    $line_view=  str_replace(":", "", $line_view);
                                    $line_view=  str_replace("https//", "https://", $line_view);
                                    
                                    if(strpos($line_view, "== ")==FALSE&&strpos($line_view, " ==")==FALSE&&strpos($line_view, "=== ")==FALSE&&strpos($line_view, " ===")==FALSE&&strpos($line_view, "listen|filename")==FALSE){//&&strpos($line_view, "url")==FALSE&&strpos($line_view, "title")==FALSE&&strpos($line_view, "work")==FALSE&&strpos($line_view, "newspaper")==FALSE&&strpos($line_view, "date")==FALSE&&strpos($line_view, "accessdate")==FALSE&&strpos($line_view, "}}")==FALSE
                                        $line_view=trim($line_view);                                        
                                        if($line_view[0]!='{'){
                                            echo $line_view; 
                                            echo '<br/>';
                                        }
                                        else{                                            
                                            $temp=  explode("|", $line_view);                                            
                                            if(count($temp)>1){
                                                echo $line_view; 
                                                echo '<br/>';
                                            }
                                        }
                                        
                                    }                                                                       

                                }
                            }
                    ?>
                                
                            </ul>      
                            

                    </div>
                                <?php
                                }
                    ?>
                </div><!-- /box -->
            </div><!-- /mainBox -->

        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<!-- /wrap -->

<?php
function get_title_array_for_img($string) {
    $title_array=array();
    $temp=  explode("thumb", $string);
    for($i=0,$n=count($temp)-1;$i<$n;$i++){
        $temp_string=$temp[$i];
        for($j=strlen($temp_string)-1;$j>-1;$j--){
            if($temp_string[$j]==':'){
                $end=$j;
            }
            else if($temp_string[$j]=='['){
                $start=$j;
                break;
            }
        }
        if(!in_array(substr($temp_string, $start+1,$end-$start-1), $title_array)){
            $title_array[]=  substr($temp_string, $start+1,$end-$start-1);        
        }
        
    }
    return $title_array;
}

function remove_img_by_key($string,$key) {
    
    while (strpos($string, "[[$key") != FALSE) {        
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen($key)) == "[[$key") {
                $index1 = $i;
                $index2 = $i + 2+  strlen($key);
                break;
            }
        }
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='[') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]==']') {                
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]==']'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    if($index2+1<$n-1&&substr($string, $index2+1, 2)=='}}'){
                        $index2+=2;
                        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
                            if (substr($string, $i, 2) == "{{") {
                                $index1 = $i;                                
                                break;
                            }
                        }
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
//            if (substr($string, $i, 2) == '[[') {
//                $open = TRUE;
//            }
//            if (substr($string, $i, 2) == ']]') {
//                if ($open == FALSE) {
//                    $index2 = $i + 1;
//                    if($index2+1<$n-1&&substr($string, $index2+1, 2)=='}}'){
//                        $index2+=2;
//                        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
//                            if (substr($string, $i, 2) == "{{") {
//                                $index1 = $i;                                
//                                break;
//                            }
//                        }
//                    }
//                    break;
//                } else {
//                    $open = FALSE;
//                }
//            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }  
    return $string;
}
function remove_img($string) { 
    while (strpos($string, "{{Imageframe") != FALSE) {        
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("Imageframe")) == "{{Imageframe") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("Imageframe");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {                
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }
   
    while (strpos($string, "{{audio") != FALSE) {        
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("audio")) == "{{audio") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("audio");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }    
    while (strpos($string, "{{右") != FALSE) {        
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("右")) == "{{右") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("右");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }
    
    while (strpos($string, "{{Imagestack") != FALSE) {     
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("Imagestack")) == "{{Imagestack") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("Imagestack");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }
    
    $title_array_for_img=get_title_array_for_img($string);    
    for($i=0,$n=count($title_array_for_img);$i<$n;$i++){
        $string=remove_img_by_key($string,$title_array_for_img[$i]);
    }
    while (strpos($string, "{{Double image") != FALSE) {     
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("Double image")) == "{{Double image") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("Double image");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }
    
    while (strpos($string, "{{multiple image") != FALSE) {        
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("multiple image")) == "{{multiple image") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("multiple image");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {                
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }
    
    while (strpos($string, "{{Vertical images") != FALSE) {        
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2+  strlen("Vertical images")) == "{{Vertical images") {
                $index1 = $i;
                $index2 = $i + 2+  strlen("Vertical images");
                break;
            }
        }
        
        $open = FALSE;
        $open_count=1;
        $close_count=0;
        for ($i = $index2, $n = strlen($string); $i < $n; $i+=2) {
            if ($string[$i]=='{') {
                $open = TRUE;
                $open_count++;               
            }
            if ($string[$i]=='}') {
                $close_count++;                
                if ($open == FALSE && $close_count==$open_count) {
                    if($string[$i-1]=='}'){
                        $index2=$i;
                    }
                    else{
                        $index2 = $i + 1;                    
                    }
                    
                    break;
                } else {
                    $open = FALSE;
                }
            }
        }
        
        $img_string = substr($string, $index1, $index2 - $index1 + 1);
        $string = str_replace($img_string, "", $string);
    }

    return $string;
}
function build_line($string,$countries){    
    while(strpos($string, "{{") != FALSE){
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2) == '{{') {
                $index1 = $i;    
                break;
            }
        }
        for ($i = 0, $n = strlen($string); $i < $n; $i++) {
            if (substr($string, $i, 2) == '}}') {
                $index2 = $i;  
                break;
            }
        }
        if(!isset($index2)){
            $index2=  strlen($string)-2;
            $img_string = substr($string, $index1, $index2 - $index1 + 2);
            $string = str_replace($img_string, "", $string);
        }
        $img_string = substr($string, $index1, $index2 - $index1 + 2);
        $code=substr($string, $index1+2, $index2 - $index1 -2);        
        $string_for_replace='';
        $has_special=true;
        foreach ($countries as $key => $value) {
            if(strtoupper($code)==$key){
                $inner_html=$value['name'];
                $url=  urlencode($value['name']);
                $url = "https://ja.wikipedia.org/wiki/" . $url;    
                $string_for_replace="<a target='_blank' title='$inner_html' href='$url'>$inner_html</a>";
                $string = str_replace($img_string, $string_for_replace, $string);
                $has_special=FALSE;
            }
        }
        if($has_special==true){                      
            if(strpos($code, "title")!=FALSE){             
                $string = str_replace($img_string, "", $string);
            }
            else if(strpos($code, "weight")!=FALSE||strpos($code, "normal")!=FALSE){ 
                foreach ($countries as $key => $value) {
                    if(strpos($img_string, $key)!=FALSE){
                        $img_string.='）}}';                        
                        $inner_html=$value['name'];
                        $url=  urlencode($value['name']);
                        $url = "https://ja.wikipedia.org/wiki/" . $url;    
                        $string_for_replace="<a target='_blank' title='$inner_html' href='$url'>$inner_html</a>";
                        $string = str_replace($img_string, $string_for_replace, $string);                       
                    }
                }                
            }
            else{
                $temp=  explode("|", $code);
                if(count($temp)>1){ 
                    $string = str_replace($img_string, $temp[1], $string);
                }
                else{
                    $string = str_replace($img_string, $temp[0], $string);
                }
            }
            
            
        }
        
    }
    if(strlen($string)>0){
        if($string[0]=='|'||$string[0]=='}'){
            $string='';
        }
    } 
    
    while (strpos($string, "[[") != FALSE) {        
        $string=build_link($string);
    }
    
    return $string;
    
    
}
function build_link($string){
    for ($i = 0, $n = strlen($string); $i < $n; $i++) {
        if (substr($string, $i, 2) == '[[') {
            $index1 = $i;  
            break;
        }
    }
    for ($i = 0, $n = strlen($string); $i < $n; $i++) {
        if (substr($string, $i, 2) == ']]') {
            $index2 = $i;     
            break;
        }
    }
    $string_for_search = substr($string, $index1, $index2 - $index1 + 2);
    $string_inner_html=substr($string, $index1+2, $index2 - $index1 - 2);
    $temp=  explode("|", $string_inner_html);

    if(count($temp)==2){
        $title=$temp[0];
        $url=$temp[0];
        $url=  str_replace(" ", "_", $url);        
        $inner_html=$temp[1];
    }
    else{
        $title=$temp[0];
        $url=$temp[0];
        $inner_html=$temp[0];
    }
    $url=  urlencode($url);
    $url = "https://ja.wikipedia.org/wiki/" . $url;                                   
    $string_for_replace="<a target='_blank' title='$title' href='$url'>$inner_html</a>";
    $string = str_replace($string_for_search, $string_for_replace, $string);
    return $string;
}
function remove_string_clear($string){    
    if($string[strlen($string)-3]=='}'){
        for($i=strlen($string)-4;$i>-1;$i--){
            if($string[$i]=='{'&&$string[$i-1]=='{'){
                $start=$i-1;
                break;
            }
        }
        $temp=  substr($string, $start);
        $string=str_replace($temp,"", $string);
    }    
    return $string;    
}
function remove_string_img($string){
    if($string[1]=='{'){
        for($i=1,$n=  strlen($string);$i<$n;$i++){
            if($string[$i]=='}'&&$string[$i+1]=='}'){
                $end=$i+1;
                break;
            }
        }
        $temp=  substr($string, 0,$end+1);
        $string=str_replace($temp,"", $string);
    }
    return $string;    
}
?>