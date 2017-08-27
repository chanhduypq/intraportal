<?php
/**
 * Config
 * Use configuration system
 * @author Hainhl
 * @Company GMO Runsystem
 * @since 1.1 - 20130724
 */
class Config
{
	/*DB�ݒ�*/
	const HOST_DATA = '192.168.168.11';
	const DB_NAME = 'IntraPortal';
	const LOGIN_DATA = 'rsdn';
	const PASS_DATA = 'rsdn20120903';
	const LIMIT_ROW = 10;
	
	//pick up mail subject
	const PICKUP_MAILSUB ="ニューギンスクエア：社員ピックアップについて";
        
        //base_news batch
        const POSITION_ID=169;


        /*�p�X���[�h�đ��̃��[��*/
	const EMAIL_SUB = '�p�X���[�h�̃��}�C���_�[';
		
	/*�j���[�M���X�N�G�A�Ǘ��҂ւ̂��₢���킹�̂��߂̐ݒ�	*/
	//SMTP�w�T�[�o��
	const EMAIL_HOST='smtp.gmail.com';	
	//���M��
	const EMAIL_USERNAME='case4u.dn@gmail.com'; 
	//���M��
	const PWDREMINDER_EMAIL_FROM='trungnt@runsystem.net';	
    static  $INQUIRY_EMAIL_TO= array('trungnt@runsystem.net','ndhungvu@gmail.com','vundh@runsystem.net','tuetc@runsystem.net');
        //�F�ؗp�̃p�X���[�h
	const EMAIL_PASS='thienbao368368';	
	//���M�|�[�g
	const EMAIL_PORT='465';	
	
	/*�Z�b�V�����^�C���A�E�g*/
	const TIME_OUT=7200;
	//image big
	const IMG_WIDTH_BIG=800;
	const IMG_HEIGHT_BIG=600;
	//image thumbs
	const IMG_WIDTH=228;
    // const MINUTE=60;
	// const HOUR =24;
        //unit MB
    const MAX_FILE_SIZE=10;

	const ZENTAISHIHYOU_PATH='zentaishihyou';
	//image thumbs
	const IMG_WIDTH_ZENTAISHIHYOU=364;
	const IMG_HEIGHT_ZENTAISHIHYOU=200;
    //title for twitter dialog
    const TITLE_FOR_TWITTER_DIALOG='anh Trung nhap doan text tieng Nhat vao day(vi du: ket qua search la:), tai file config.php. neu anh k muon co doan text nao tren header thi anh cho string nay la empty.';
	//Const Path
	const RANKING_DATA_PATH='/var/www/intraportal/upload/ranking/';
        //Const Path user
	const IMAGE_PATH='/var/www/intraportal/photo/';
        //const Path log        
         const LOG_PATH='/var/www/intraportal/protected/runtime/';
        const LOG_FILE_NAME='newgin.log';
        const LOG_FILE_NAME_MAX_SIZE=0.001;//unit MB; input: float or integer

	
}
