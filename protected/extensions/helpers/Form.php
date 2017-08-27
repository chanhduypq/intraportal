<?php

class Form extends CWidget {

    public function editConfirm14($model, $form, $controller_name) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }
        $my_class = strtolower(get_class($model));
        $cookie_key_name = 'file_' . $my_class . '_edit_attachment4';
        if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null") {
            $uploaded_file_attachment4_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name]->value));
        } else if ($my_class == 'base' || $my_class == 'user') {
            $uploaded_file_attachment4_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->photo));
        } else if ($my_class == 'hobby_itd' || $my_class == 'golfnews') {
            $uploaded_file_attachment4_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->eye_catch));
        }
        if ($my_class == 'base' || $my_class == 'user') {
            echo $form->hiddenField($model, 'photo_file_type');
            echo $form->hiddenField($model, 'photo');
            echo $form->hiddenField($model, 'photo_checkbox_for_deleting');

            if ($model->photo_checkbox_for_deleting == '1') {//delete checkbox has been checked
                $this->echoEmpty(true);
            } else {//delete checkbox has not been checked                                 
                if (trim($model->photo) != "" || (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]))) {//upload new file                                            
                    Upload_file_common::echoOldFile1($uploaded_file_attachment4_ext, 4, $model, $controller_name, $action_type = 2);
                } else {//keep old status                                              
                    $this->echoEmpty(true);
                }
            }
        } else if ($my_class == 'hobby_itd'|| $my_class == 'golfnews') {
            echo $form->hiddenField($model, 'eye_catch_file_type');
            echo $form->hiddenField($model, 'eye_catch');
            echo $form->hiddenField($model, 'eye_catch_checkbox_for_deleting');

            if ($model->eye_catch_checkbox_for_deleting == '1') {//delete checkbox has been checked
                $this->echoEmpty();
            } else {//delete checkbox has not been checked                                 
                if (trim($model->eye_catch) != "" || (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]))) {//upload new file                                            
                    Upload_file_common::echoOldFile1($uploaded_file_attachment4_ext, 4, $model, $controller_name, $action_type = 2);                    
                } else {//keep old status                                              
                    $this->echoEmpty();
                }
            }
        }
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    public function editConfirm11($model, $form, $controller_name) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }
        $my_class = strtolower(get_class($model));
        $cookie_key_name = 'file_' . $my_class . '_edit_attachment';
        if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null") {
            $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '1']->value));
        } else {
            $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment1));
        }
        if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null") {
            $uploaded_file_attachment2_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '2']->value));
        } else {
            $uploaded_file_attachment2_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment2));
        }
        if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null") {
            $uploaded_file_attachment3_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '3']->value));
        } else {
            $uploaded_file_attachment3_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment3));
        }
        /**
         * 
         */
        ?>




        <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                
        <?php echo $form->hiddenField($model, 'attachment1'); ?>   
        <?php echo $form->hiddenField($model, 'attachment1_checkbox_for_deleting'); ?>  

        <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment2'); ?>   
        <?php echo $form->hiddenField($model, 'attachment2_checkbox_for_deleting'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment3'); ?>  
        <?php echo $form->hiddenField($model, 'attachment3_checkbox_for_deleting'); ?>                               

        <div class="title">添付資料</div>    
        <div class="photo">
            <div class="imgbox"> 
        <?php
        if ($model->attachment1_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked                                 
            if (trim($model->attachment1) != "" || (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']))) {//upload new file                                            
                Upload_file_common::echoOldFile1($uploaded_file_attachment1_ext, 1, $model, $controller_name, $action_type = 2);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
                <?php
                if ($model->attachment2_checkbox_for_deleting == '1') {//delete checkbox has been checked
                    $this->echoEmpty();
                } else {//delete checkbox has not been checked
                    if (trim($model->attachment2) != "" || (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']))) {//upload new file
                        Upload_file_common::echoOldFile1($uploaded_file_attachment2_ext, 2, $model, $controller_name, $action_type = 2);
                    } else {//keep old status                                              
                        $this->echoEmpty();
                    }
                }
                ?>
            </div>
            <div class="imgbox">
                <?php
                if ($model->attachment3_checkbox_for_deleting == '1') {//delete checkbox has been checked
                    $this->echoEmpty();
                } else {//delete checkbox has not been checked
                    if (trim($model->attachment3) != "" || (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']))) {//upload new file
                        Upload_file_common::echoOldFile1($uploaded_file_attachment3_ext, 3, $model, $controller_name, $action_type = 2);
                    } else {//keep old status                                              
                        $this->echoEmpty();
                    }
                }
                ?>
            </div>
        </div>
                <?php
            }

            public function edit14($model, $form, $controller_name, $attachment4_error) {
                $my_class = strtolower(get_class($model));
                $cookie_key_name = 'file_' . $my_class . '_edit_attachment';
                $host_file_attachment4_ext = "";
                if ($my_class == 'base' || $my_class == 'user') {
                    $host_file_attachment4_ext = strtolower($this->getFileNameExtension($model->photo));
                    echo $form->hiddenField($model, 'photo_file_type');
                } else if ($my_class == 'hobby_itd' || $my_class == 'golfnews') {
                    $host_file_attachment4_ext = strtolower($this->getFileNameExtension($model->eye_catch));
                    echo $form->hiddenField($model, 'eye_catch_file_type');
                }
                if ($attachment4_error != "") {
                    echo '<div class="alert error_message" id="photo_error">' . $attachment4_error . '</div>';
                }
                if ($my_class == 'base' || $my_class == 'user') {
                    
                    //echo '<div id="error_message4"></div>';
                    if (trim($model->photo) != "") {//have file               
                        Upload_file_common::echoOldFile1($host_file_attachment4_ext, 4, $model, $controller_name, $edit = true);
                    }
                } else if ($my_class == 'hobby_itd' || $my_class == 'golfnews') {
                    if (trim($model->eye_catch) != "") {//have file               
                        Upload_file_common::echoOldFile1($host_file_attachment4_ext, 4, $model, $controller_name, $edit = true);
                    } else {
                        echo '<img alt="" src="' . Yii::app()->request->baseUrl . '/css/common/img/img_photo01.jpg">';
                    }
                } else {//do not have file
                    if ($my_class == 'base') {
                        echo '<img alt="" src="' . Yii::app()->request->baseUrl . '/css/common/img/img_photo01.jpg">';
                    } else {
                        echo '<img style="width:228px; float:left; margin: 0px 15px;" src="' . Yii::app()->baseUrl . '/css/common/img/img_dummyman.jpg">';
                    }
                }
                if ($my_class == 'hobby_itd' || $my_class == 'golfnews') {
                    echo '<p>';
                    echo $form->fileField($model, 'eye_catch', array('size' => 20));
                    echo '</p>';
                    echo '<p><span class="checkDelete">';
                    echo $form->checkBox($model, 'eye_catch_checkbox_for_deleting'
                            , array('value' => 1, 'uncheckValue' => 0)
                    );
                    echo '削除する</span></p>';
                } else
                if ($my_class == 'base') {
                    echo '<p><span class="mr10">家屋写真：</span>' . $form->fileField($model, 'photo') . '</p>';
                    echo '<p><span class="checkDelete">';
                    echo $form->checkBox($model, 'photo_checkbox_for_deleting'
                            , array('value' => 1, 'uncheckValue' => 0)
                    );
                    echo '削除する</span></p>';
                } else if ($my_class == 'user') {
                    echo '<p style="width:228px; float:left; margin-left: 15px;"><span class="mr10">写真：</span>' . $form->fileField($model, 'photo');
                    echo '<span class="checkDelete">';
                    echo $form->checkBox($model, 'photo_checkbox_for_deleting'
                            , array('value' => 1, 'uncheckValue' => 0)
                    );
                    echo '   削除する</span></p>';
                }
                if (Yii::app()->request->cookies[$cookie_key_name . '4'] != "" && Yii::app()->request->cookies[$cookie_key_name . '4'] != "null") {
                    if ($my_class == 'base'||$my_class == 'hobby_itd' || $my_class == 'golfnews') {
                        echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '4']->value);
                    }
                    
                }
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function edit11($model, $form, $controller_name, $attachment1_error, $attachment2_error, $attachment3_error) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }
                $my_class = strtolower(get_class($model));
                $cookie_key_name = 'file_' . $my_class . '_edit_attachment';
                /**
                 * 
                 */
                $host_file_attachment1_ext = strtolower($this->getFileNameExtension($model->attachment1));
                $host_file_attachment2_ext = strtolower($this->getFileNameExtension($model->attachment2));
                $host_file_attachment3_ext = strtolower($this->getFileNameExtension($model->attachment3));
                ?>

        <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                       


        <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>    


        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                              
        <div class="attachements">
            <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ<?php echo Config::MAX_FILE_SIZE; ?>MB迄可)</div> 
            <div id="error_message1"></div>            
            <div id="error_message2"></div>            
            <div id="error_message3"></div>   
        <?php
        if ($attachment1_error != "") {
            echo '<div class="alert error_message" id="err1">' . $attachment1_error . '</div>';
        }
        if ($attachment2_error != "") {
            echo '<div class="alert error_message" id="err2">' . $attachment2_error . '</div>';
        }
        if ($attachment3_error != "") {
            echo '<div class="alert error_message" id="err3">' . $attachment3_error . '</div>';
        }
        ?>
            <div class="photo">
                <div class="imgbox">
        <?php
        if (trim($model->attachment1) != "") {//have file                                                 
            FunctionCommon::echoOldFile($host_file_attachment1_ext, 1, $model, $controller_name, $edit = true);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 1);
        $this->echoCheckboxForDeletingFile($model, $form, 1);
        ?>
            <?php
            if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null") {
                echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '1']->value);
            }
            ?>
                </div>
                <div class="imgbox">
            <?php
            if (trim($model->attachment2) != "") {//have file 
                FunctionCommon::echoOldFile($host_file_attachment2_ext, 2, $model, $controller_name, $edit = true);
            } else {//do not have file
                FunctionCommon::echoEmpty();
            }
            $this->echoFileForUploadingFile($model, $form, 2);
            $this->echoCheckboxForDeletingFile($model, $form, 2);
            ?>
                    <?php
                    if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null") {
                        echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '2']->value);
                    }
                    ?>
                </div>
                <div class="imgbox">
                    <?php
                    if (trim($model->attachment3) != "") {//have file                                         
                        FunctionCommon::echoOldFile($host_file_attachment3_ext, 3, $model, $controller_name, $edit = true);
                    } else {//do not have file
                        FunctionCommon::echoEmpty();
                    }
                    $this->echoFileForUploadingFile($model, $form, 3);
                    $this->echoCheckboxForDeletingFile($model, $form, 3);
                    ?>
                    <?php
                    if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null") {
                        echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '3']->value);
                    }
                    ?>
                </div>
            </div>
        </div>






                    <?php
                }

                /**
                 * @param CActiveRecord $model 
                 * @return html 
                 */
                public function registConfirm11($model, $form, $controller_name) {
                    if (!($model instanceof CActiveRecord)) {
                        return;
                    }

                    $my_class = strtolower(get_class($model));
                    $cookie_key_name = 'file_' . $my_class . '_regist_attachment';

                    /**
                     * 
                     */
                    if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null") {
                        $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '1']->value));
                    } else {
                        $uploaded_file_attachment1_ext = '';
                    }
                    if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null") {
                        $uploaded_file_attachment2_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '2']->value));
                    } else {
                        $uploaded_file_attachment2_ext = '';
                    }
                    if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null") {
                        $uploaded_file_attachment3_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '3']->value));
                    } else {
                        $uploaded_file_attachment3_ext = '';
                    }
                    ?>        

        <?php echo $form->hiddenField($model, 'attachment1'); ?>          
        <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                 
        <?php echo $form->hiddenField($model, 'attachment1_checkbox_for_deleting'); ?>  

        <?php echo $form->hiddenField($model, 'attachment2'); ?>          
        <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment2_checkbox_for_deleting'); ?>  

        <?php echo $form->hiddenField($model, 'attachment3'); ?>          
        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment3_checkbox_for_deleting'); ?>
        <div class="title">添付資料</div>                                 	                        
        <div class="photo">
            <div class="imgbox"> 
        <?php
        if ($model->attachment1_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked                                 
            if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1'])) {
                Upload_file_common::echoOldFile1($uploaded_file_attachment1_ext, 1, $model, $controller_name, $action_type = 1);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment2_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2'])) {
                Upload_file_common::echoOldFile1($uploaded_file_attachment2_ext, 2, $model, $controller_name, $action_type = 1);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
                <?php
                if ($model->attachment3_checkbox_for_deleting == '1') {//delete checkbox has been checked
                    $this->echoEmpty();
                } else {//delete checkbox has not been checked
                    if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3'])) {
                        Upload_file_common::echoOldFile1($uploaded_file_attachment3_ext, 3, $model, $controller_name, $action_type = 1);
                    } else {//keep old status                                              
                        $this->echoEmpty();
                    }
                }
                ?>
            </div>
        </div>
                <?php
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function registConfirm14($model, $form, $controller_name, $attr_name) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }

                $my_class = strtolower(get_class($model));
                $cookie_key_name = 'file_' . $my_class . '_regist_attachment4';

                /**
                 * 
                 */
                if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null") {
                    $uploaded_file_attachment4_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name]->value));
                } else {
                    $uploaded_file_attachment4_ext = '';
                }
                ?>        

                <?php echo $form->hiddenField($model, $attr_name); ?>          
                <?php echo $form->hiddenField($model, $attr_name . '_file_type'); ?>                                 
                <?php echo $form->hiddenField($model, $attr_name . '_checkbox_for_deleting'); ?>                        	                        


        <?php
        if ($attr_name == 'photo') {
            if ($model->photo_checkbox_for_deleting == '1') {//delete checkbox has been checked
                $this->echoEmpty();
            } else {//delete checkbox has not been checked                                 
                if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name])) {
                    Upload_file_common::echoOldFile1($uploaded_file_attachment4_ext, 4, $model, $controller_name, $action_type = 1);
                } else {//keep old status                                              
                    $this->echoEmpty();
                }
            }
        } else if ($attr_name == 'eye_catch') {

            if ($model->eye_catch_checkbox_for_deleting == '1') {//delete checkbox has been checked
                $this->echoEmpty();
            } else {//delete checkbox has not been checked     
                if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name])) {
                    Upload_file_common::echoOldFile1($uploaded_file_attachment4_ext, 4, $model, $controller_name, $action_type = 1);
                } else {//keep old status                                              
                    $this->echoEmpty();
                }
            }
        }
        ?>



        <?php
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    public function regist11($model, $form, $attachment1_error, $attachment2_error, $attachment3_error) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }
        ?>
        <?php
        $my_class = strtolower(get_class($model));
        $cookie_key_name = 'file_' . $my_class . '_regist_attachment';
        ?>
        <div class="attachements">
            <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ<?php echo Config::MAX_FILE_SIZE; ?>MB迄可)</div> 
            <div id="error_message1"></div>            
            <div id="error_message2"></div>            
            <div id="error_message3"></div>   
        <?php
        if ($attachment1_error != "") {
            echo '<div class="alert error_message" id="err1">' . $attachment1_error . '</div>';
        }
        if ($attachment2_error != "") {
            echo '<div class="alert error_message" id="err2">' . $attachment2_error . '</div>';
        }
        if ($attachment3_error != "") {
            echo '<div class="alert error_message" id="err3">' . $attachment3_error . '</div>';
        }
        ?>
            <div class="photo">
                <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                    <p><?php echo $form->fileField($model, 'attachment1', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 1); ?>
        <?php
        if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null") {
            echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '1']->value);
        }
        ?>
                </div>
                <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                    <p><?php echo $form->fileField($model, 'attachment2', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 2); ?>
        <?php
        if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null") {
            echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '2']->value);
        }
        ?>
                </div>
                <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                    <p><?php echo $form->fileField($model, 'attachment3', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 3); ?>
        <?php
        if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null") {
            echo Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '3']->value);
        }
        ?>
                </div>
            </div>
        </div>
            <?php
        }
        
        public function regist111($model, $form,$controller_name, $attachment1_error, $attachment2_error, $attachment3_error) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }
        ?>
        <?php
        $my_class = strtolower(get_class($model));
        $cookie_key_name = 'file_' . $my_class . '_regist_attachment';
        ?>
        <div class="attachements">
            <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ<?php echo Config::MAX_FILE_SIZE; ?>MB迄可)</div> 
            <div id="error_message1"></div>            
            <div id="error_message2"></div>            
            <div id="error_message3"></div>   
        <?php
        if ($attachment1_error != "") {
            echo '<div class="alert error_message">' . $attachment1_error . '</div>';
        }
        if ($attachment2_error != "") {
            echo '<div class="alert error_message">' . $attachment2_error . '</div>';
        }
        if ($attachment3_error != "") {
            echo '<div class="alert error_message">' . $attachment3_error . '</div>';
        }
        ?>
            <div class="photo">
                <div class="imgbox">
                    <?php
        if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null") {            
            $uploaded_file_attachment1_ext=  Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '1']->value));
            Upload_file_common::echoOldFile1($uploaded_file_attachment1_ext, 1, $model, $controller_name, $action_type = 1);
        }
        else{
        ?>
                    <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
        <?php }?>
                    <p><?php echo $form->fileField($model, 'attachment1', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 1); ?>
        
                </div>
                <div class="imgbox">
                    <?php
        if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null") {            
            $uploaded_file_attachment2_ext=  Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '2']->value));
            Upload_file_common::echoOldFile1($uploaded_file_attachment2_ext, 2, $model, $controller_name, $action_type = 1);
        }
         else{
        ?>
                    <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                    <?php }?>
                    <p><?php echo $form->fileField($model, 'attachment2', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 2); ?>
        
                </div>
                <div class="imgbox">
                    <?php
        if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null") {           
            $uploaded_file_attachment3_ext=  Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name . '3']->value));
            Upload_file_common::echoOldFile1($uploaded_file_attachment3_ext, 3, $model, $controller_name, $action_type = 1);
        }
         else{
        ?>
                    <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                    <?php }?>
                    <p><?php echo $form->fileField($model, 'attachment3', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 3); ?>
        
                </div>
            </div>
        </div>
            <?php
        }

        /**
         * @param CActiveRecord $model 
         * @return html 
         */
        public function regist1($model, $form, $attachment1_error, $attachment2_error, $attachment3_error) {
            if (!($model instanceof CActiveRecord)) {
                return;
            }
            ?>

        <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ5MB迄可)</div> 
        <div id="error_message1"></div>            
        <div id="error_message2"></div>            
        <div id="error_message3"></div>   
        <?php
        if ($attachment1_error != "") {
            echo '<div class="alert error_message">' . $attachment1_error . '</div>';
        }
        if ($attachment2_error != "") {
            echo '<div class="alert error_message">' . $attachment2_error . '</div>';
        }
        if ($attachment3_error != "") {
            echo '<div class="alert error_message">' . $attachment3_error . '</div>';
        }
        ?>
        <div class="photo">
            <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                <p><?php echo $form->fileField($model, 'attachment1', array('size' => 20)); ?></p>
                    <?php $this->echoCheckboxForDeletingFile($model, $form, 1); ?>
            </div>
            <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                <p><?php echo $form->fileField($model, 'attachment2', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 2); ?>
            </div>
            <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                <p><?php echo $form->fileField($model, 'attachment3', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 3); ?>
            </div>
        </div>
        <?php
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    public function regist($model, $form) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }
        ?>
        <?php echo $form->hiddenField($model, 'attachment1_file_name'); ?>         
        <?php echo $form->hiddenField($model, 'attachment1_file_bytes'); ?>             
        <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                 
        <?php echo $form->hiddenField($model, 'attachment2_file_name'); ?>         
        <?php echo $form->hiddenField($model, 'attachment2_file_bytes'); ?>             
        <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment3_file_name'); ?>         
        <?php echo $form->hiddenField($model, 'attachment3_file_bytes'); ?>             
        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>  
        <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ5MB迄可)</div> 
        <div id="error_message1"></div>            
        <div id="error_message2"></div>            
        <div id="error_message3"></div>            
        <?php echo $form->error($model, 'attachment1'); ?>
        <br/>
                <?php echo $form->error($model, 'attachment2'); ?>
        <br/>
        <?php echo $form->error($model, 'attachment3'); ?>
        <div class="photo">
            <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                <p><?php echo $form->fileField($model, 'attachment1', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 1); ?>
            </div>
            <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                <p><?php echo $form->fileField($model, 'attachment2', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 2); ?>
            </div>
            <div class="imgbox"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_photo01.jpg">
                <p><?php echo $form->fileField($model, 'attachment3', array('size' => 20)); ?></p>
        <?php $this->echoCheckboxForDeletingFile($model, $form, 3); ?>
            </div>
        </div>
        <?php
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    public function registConfirm1($model, $form, $controller_name) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }
        /**
         * 
         */
        $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment1));
        $uploaded_file_attachment2_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment2));
        $uploaded_file_attachment3_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment3));
        ?>        

        <?php echo $form->hiddenField($model, 'attachment1'); ?>          
        <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                 
                <?php echo $form->hiddenField($model, 'attachment1_checkbox_for_deleting'); ?>  

        <?php echo $form->hiddenField($model, 'attachment2'); ?>          
        <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
                <?php echo $form->hiddenField($model, 'attachment2_checkbox_for_deleting'); ?>  

        <?php echo $form->hiddenField($model, 'attachment3'); ?>          
        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                 
                <?php echo $form->hiddenField($model, 'attachment3_checkbox_for_deleting'); ?>
        <div class="title">添付資料</div>                                 	                        
        <div class="photo">
            <div class="imgbox"> 
        <?php
        if ($model->attachment1_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked                                 
            if (trim($model->attachment1) != "") {//upload new file                                            
                Upload_file_common::echoOldFile($uploaded_file_attachment1_ext, 1, $model, $controller_name);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment2_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment2) != "") {//upload new file
                Upload_file_common::echoOldFile($uploaded_file_attachment2_ext, 2, $model, $controller_name);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment3_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment3) != "") {//upload new file
                Upload_file_common::echoOldFile($uploaded_file_attachment3_ext, 3, $model, $controller_name);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
        </div>
                <?php
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function registConfirm($model, $form) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }
                /**
                 * 
                 */
                $uploaded_file_attachment1_ext = $this->getFileNameExtension($model->attachment1_file_name);
                $uploaded_file_attachment2_ext = $this->getFileNameExtension($model->attachment2_file_name);
                $uploaded_file_attachment3_ext = $this->getFileNameExtension($model->attachment3_file_name);
                ?>        
                <?php echo $form->hiddenField($model, 'attachment1_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment1_file_bytes'); ?>             
        <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                 
                <?php echo $form->hiddenField($model, 'attachment1_checkbox_for_deleting'); ?>  
                <?php echo $form->hiddenField($model, 'attachment2_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment2_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
                <?php echo $form->hiddenField($model, 'attachment2_checkbox_for_deleting'); ?>  
                <?php echo $form->hiddenField($model, 'attachment3_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment3_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                 
                <?php echo $form->hiddenField($model, 'attachment3_checkbox_for_deleting'); ?>
        <div class="title">添付資料</div>                                 	                        
        <div class="photo">
            <div class="imgbox"> 
                <?php
                if ($model->attachment1_checkbox_for_deleting == '1') {//delete checkbox has been checked
                    $this->echoEmpty();
                } else {//delete checkbox has not been checked                                 
                    if (trim($model->attachment1_file_name) != "") {//upload new file
                        FunctionCommon::echoNewFile($uploaded_file_attachment1_ext, 1, $model);
                    } else {//keep old status                                              
                        $this->echoEmpty();
                    }
                }
                ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment2_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment2_file_name) != "") {//upload new file
                FunctionCommon::echoNewFile($uploaded_file_attachment2_ext, 2, $model);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment3_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment3_file_name) != "") {//upload new file
                FunctionCommon::echoNewFile($uploaded_file_attachment3_ext, 3, $model);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
        </div>
                <?php
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function edit1($model, $form, $controller_name, $attachment1_error, $attachment2_error, $attachment3_error) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }
                /**
                 * 
                 */
                $host_file_attachment1_ext = strtolower($this->getFileNameExtension($model->attachment1));
                $host_file_attachment2_ext = strtolower($this->getFileNameExtension($model->attachment2));
                $host_file_attachment3_ext = strtolower($this->getFileNameExtension($model->attachment3));
                ?>





                <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                       


                <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>    


                <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                              

        <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ5MB迄可)</div> 
        <div id="error_message1"></div>            
        <div id="error_message2"></div>            
        <div id="error_message3"></div>   
                <?php
                if ($attachment1_error != "") {
                    echo '<div class="alert error_message">' . $attachment1_error . '</div>';
                }
                if ($attachment2_error != "") {
                    echo '<div class="alert error_message">' . $attachment2_error . '</div>';
                }
                if ($attachment3_error != "") {
                    echo '<div class="alert error_message">' . $attachment3_error . '</div>';
                }
                ?>
        <div class="photo">
            <div class="imgbox">
        <?php
        if (trim($model->attachment1) != "") {//have file                                                 
            FunctionCommon::echoOldFile($host_file_attachment1_ext, 1, $model, $controller_name, $edit = true);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 1);
        $this->echoCheckboxForDeletingFile($model, $form, 1);
        ?>
            </div>
            <div class="imgbox">
        <?php
        if (trim($model->attachment2) != "") {//have file 
            FunctionCommon::echoOldFile($host_file_attachment2_ext, 2, $model, $controller_name, $edit = true);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 2);
        $this->echoCheckboxForDeletingFile($model, $form, 2);
        ?>
            </div>
            <div class="imgbox">
        <?php
        if (trim($model->attachment3) != "") {//have file                                         
            FunctionCommon::echoOldFile($host_file_attachment3_ext, 3, $model, $controller_name, $edit = true);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 3);
        $this->echoCheckboxForDeletingFile($model, $form, 3);
        ?>
            </div>
        </div>







                <?php
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function edit($model, $form, $controller_name) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }
                /**
                 * 
                 */
                $host_file_attachment1_ext = strtolower($this->getFileNameExtension($model->attachment1));
                $host_file_attachment2_ext = strtolower($this->getFileNameExtension($model->attachment2));
                $host_file_attachment3_ext = strtolower($this->getFileNameExtension($model->attachment3));
                ?>




                <?php echo $form->hiddenField($model, 'attachment1_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment1_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                       

                <?php echo $form->hiddenField($model, 'attachment2_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment2_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>    

                <?php echo $form->hiddenField($model, 'attachment3_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment3_file_bytes'); ?>             
        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                              

        <div class="title">添付資料 (PDF,Office,Zip,画像ファイルを添付可。ファイルサイズ5MB迄可)</div> 
        <div id="error_message1"></div>            
        <div id="error_message2"></div>            
        <div id="error_message3"></div> 
        <?php echo $form->error($model, 'attachment1'); ?>
        <br/>
        <?php echo $form->error($model, 'attachment2'); ?>
        <br/>
        <?php echo $form->error($model, 'attachment3'); ?>
        <div class="photo">
            <div class="imgbox">
        <?php
        if (trim($model->attachment1) != "") {//have file                                                 
            FunctionCommon::echoOldFile($host_file_attachment1_ext, 1, $model, $controller_name);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 1);
        $this->echoCheckboxForDeletingFile($model, $form, 1);
        ?>
            </div>
            <div class="imgbox">
        <?php
        if (trim($model->attachment2) != "") {//have file 
            FunctionCommon::echoOldFile($host_file_attachment2_ext, 2, $model, $controller_name);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 2);
        $this->echoCheckboxForDeletingFile($model, $form, 2);
        ?>
            </div>
            <div class="imgbox">
        <?php
        if (trim($model->attachment3) != "") {//have file                                         
            FunctionCommon::echoOldFile($host_file_attachment3_ext, 3, $model, $controller_name);
        } else {//do not have file
            FunctionCommon::echoEmpty();
        }
        $this->echoFileForUploadingFile($model, $form, 3);
        $this->echoCheckboxForDeletingFile($model, $form, 3);
        ?>
            </div>
        </div>







                <?php
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function detail($model, $controller_name,$assetsBase, $edit = FALSE) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }
                /**
                 * 
                 */
                $host_file_attachment1_ext = strtolower($this->getFileNameExtension($model->attachment1));
                $host_file_attachment2_ext = strtolower($this->getFileNameExtension($model->attachment2));
                $host_file_attachment3_ext = strtolower($this->getFileNameExtension($model->attachment3));
                ?>








        <div class="photo">

                <?php
                if (trim($model->attachment1) != ""&&file_exists(Yii::getPathOfAlias('webroot').$model->attachment1)) {//have file 
                    echo '<div class="imgbox">';
                    FunctionCommon::echoOldFile($host_file_attachment1_ext, 1, $model, $controller_name,$assetsBase, $edit);
                    echo '</div>';
                }
                if (trim($model->attachment2) != ""&&file_exists(Yii::getPathOfAlias('webroot').$model->attachment2)) {//have file 
                    echo '<div class="imgbox">';
                    FunctionCommon::echoOldFile($host_file_attachment2_ext, 2, $model, $controller_name,$assetsBase, $edit);
                    echo '</div>';
                }
                if (trim($model->attachment3) != ""&&file_exists(Yii::getPathOfAlias('webroot').$model->attachment3)) {//have file 
                    echo '<div class="imgbox">';
                    FunctionCommon::echoOldFile($host_file_attachment3_ext, 3, $model, $controller_name,$assetsBase, $edit);
                    echo '</div>';
                }
                ?>


        </div>







        <?php
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    public function editConfirm1($model, $form, $controller_name) {
        if (!($model instanceof CActiveRecord)) {
            return;
        }

        /**
         * 
         */
        $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment1));
        $uploaded_file_attachment2_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment2));
        $uploaded_file_attachment3_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->attachment3));
        ?>




            <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                
            <?php echo $form->hiddenField($model, 'attachment1'); ?>   
            <?php echo $form->hiddenField($model, 'attachment1_checkbox_for_deleting'); ?>  

            <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
            <?php echo $form->hiddenField($model, 'attachment2'); ?>   
            <?php echo $form->hiddenField($model, 'attachment2_checkbox_for_deleting'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                 
        <?php echo $form->hiddenField($model, 'attachment3'); ?>  
        <?php echo $form->hiddenField($model, 'attachment3_checkbox_for_deleting'); ?>                               

        <div class="title">添付資料</div>    
        <div class="photo">
            <div class="imgbox"> 
        <?php
        if ($model->attachment1_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked                                 
            if (trim($model->attachment1) != "") {//upload new file                                            
                Upload_file_common::echoOldFile($uploaded_file_attachment1_ext, 1, $model, $controller_name);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment2_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment2) != "") {//upload new file
                Upload_file_common::echoOldFile($uploaded_file_attachment2_ext, 2, $model, $controller_name);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment3_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment3) != "") {//upload new file
                Upload_file_common::echoOldFile($uploaded_file_attachment3_ext, 3, $model, $controller_name);
            } else {//keep old status                                              
                $this->echoEmpty();
            }
        }
        ?>
            </div>
        </div>
                <?php
            }

            /**
             * @param CActiveRecord $model 
             * @return html 
             */
            public function editConfirm($model, $form, $controller_name) {
                if (!($model instanceof CActiveRecord)) {
                    return;
                }
                /**
                 * 
                 */
                $uploaded_file_attachment1_ext = $this->getFileNameExtension($model->attachment1_file_name);
                $uploaded_file_attachment2_ext = $this->getFileNameExtension($model->attachment2_file_name);
                $uploaded_file_attachment3_ext = $this->getFileNameExtension($model->attachment3_file_name);
                /**
                 * 
                 */
                $host_file_attachment1_ext = strtolower($this->getFileNameExtension($model->attachment1));
                $host_file_attachment2_ext = strtolower($this->getFileNameExtension($model->attachment2));
                $host_file_attachment3_ext = strtolower($this->getFileNameExtension($model->attachment3));
                ?>



                <?php echo $form->hiddenField($model, 'attachment1_file_name'); ?>         
        <?php echo $form->hiddenField($model, 'attachment1_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment1_file_type'); ?>                                
                <?php echo $form->hiddenField($model, 'attachment1'); ?>   
                <?php echo $form->hiddenField($model, 'attachment1_checkbox_for_deleting'); ?>  
                <?php echo $form->hiddenField($model, 'attachment2_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment2_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment2_file_type'); ?>                 
                <?php echo $form->hiddenField($model, 'attachment2'); ?>   
                <?php echo $form->hiddenField($model, 'attachment2_checkbox_for_deleting'); ?>  
                <?php echo $form->hiddenField($model, 'attachment3_file_name'); ?>         
                <?php echo $form->hiddenField($model, 'attachment3_file_bytes'); ?>             
                <?php echo $form->hiddenField($model, 'attachment3_file_type'); ?>                 
                <?php echo $form->hiddenField($model, 'attachment3'); ?>  
                <?php echo $form->hiddenField($model, 'attachment3_checkbox_for_deleting'); ?>                               

        <div class="title">添付資料</div>    
        <div class="photo">
            <div class="imgbox"> 
        <?php
        if ($model->attachment1_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked                                                                         
            if (trim($model->attachment1_file_name) != "") {//upload new file
                FunctionCommon::echoNewFile($uploaded_file_attachment1_ext, 1, $model);
            } else {//keep old status    
                if (trim($model->attachment1) != "") {
                    FunctionCommon::echoOldFile($host_file_attachment1_ext, 1, $model, $controller_name);
                } else {
                    $this->echoEmpty();
                }
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment2_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment2_file_name) != "") {//upload new file
                FunctionCommon::echoNewFile($uploaded_file_attachment2_ext, 2, $model);
            } else {//keep old status                                              
                if (trim($model->attachment2) != "") {
                    FunctionCommon::echoOldFile($host_file_attachment2_ext, 2, $model, $controller_name);
                } else {
                    $this->echoEmpty();
                }
            }
        }
        ?>
            </div>
            <div class="imgbox">
        <?php
        if ($model->attachment3_checkbox_for_deleting == '1') {//delete checkbox has been checked
            $this->echoEmpty();
        } else {//delete checkbox has not been checked
            if (trim($model->attachment3_file_name) != "") {//upload new file
                FunctionCommon::echoNewFile($uploaded_file_attachment3_ext, 3, $model);
            } else {//keep old status                                              
                if (trim($model->attachment3) != "") {
                    FunctionCommon::echoOldFile($host_file_attachment3_ext, 3, $model, $controller_name);
                } else {
                    $this->echoEmpty();
                }
            }
        }
        ?>
            </div>
        </div>
                <?php
            }

            function echoOldFile($host_file_attachment_ext, $order_index, $model, $img_extention_array, $zip_extention_array, $excel_extention_array, $word_extention_array, $powerpoint_extention_array, $controller_name) {
                $attachment = "";
                if ($order_index == 1) {
                    $attachment = $model->attachment1;
                } else if ($order_index == 2) {
                    $attachment = $model->attachment2;
                } elseif ($order_index == 3) {
                    $attachment = $model->attachment3;
                }
                ?>
        <a <?php if (in_array($host_file_attachment_ext, $img_extention_array)) echo ' rel="prettyPhoto" '; ?> 
            href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/<?php echo $controller_name; ?>/download/?id=<?php echo $model->id . "&" . $order_index; ?>">

                <?php
                if (in_array($host_file_attachment_ext, $img_extention_array))
                    echo '<img style="width:228px; height:171px;" src="' . Yii::app()->request->baseUrl . $attachment . '"/>';
                else if ($host_file_attachment_ext == 'pdf')
                    echo '<img src="' . Yii::app()->request->baseUrl . '/css/common/img/img_pdf.gif' . '"/>';
                else if (in_array($host_file_attachment_ext, $zip_extention_array))
                    echo '<img src="' . Yii::app()->request->baseUrl . '/css/common/img/img_zip.gif' . '"/>';
                else if (in_array($host_file_attachment_ext, $excel_extention_array))
                    echo '<img src="' . Yii::app()->request->baseUrl . '/css/common/img/img_excel.gif' . '"/>';
                else if (in_array($host_file_attachment_ext, $word_extention_array))
                    echo '<img src="' . Yii::app()->request->baseUrl . '/css/common/img/img_word.gif' . '"/>';
                else if (in_array($host_file_attachment_ext, $powerpoint_extention_array))
                    echo '<img src="' . Yii::app()->request->baseUrl . '/css/common/img/img_ppt.gif' . '"/>';
                ?>
            <div style="text-align: center;"><?php echo $this->getFileNameFromValueInDatabase($attachment); ?></div>
                <?php
                ?>


        </a>
                <?php
            }

            public static function getFileNameFromValueInDatabase($full_file_name) {
                if ($full_file_name == null || !is_string($full_file_name) || trim($full_file_name) == "") {
                    return null;
                }
                $string_array = explode("/", $full_file_name);
                if (count($string_array) == 1) {
                    return NULL;
                }
                $file_name = $string_array[count($string_array) - 1];
                $string_array = explode(".", $file_name);
                $file_name = '';
                for ($i = 0, $n = count($string_array) - 2; $i < $n; $i++) {
                    $file_name.=$string_array[$i];
                }
                $file_name.='.' . $string_array[count($string_array) - 1];
                return $file_name;
            }

            public static function getFileNameExtension($file_name) {
                if ($file_name == null || !is_string($file_name) || trim($file_name) == "") {
                    return null;
                }
                $string_array = explode(".", $file_name);
                if (count($string_array) == 1) {
                    return null;
                }
                return $string_array[count($string_array) - 1];
            }

            function echoEmpty($has_img = FALSE) {
                $a=new Controller(1);
                $assetsBase=$a->assetsBase;
                if ($has_img === true) {
                    echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_photo01.jpg">';
                } else {
                    echo '';
                }
            }

            function echoCheckboxForDeletingFile($model, $form, $order_index) {
                $attachment_checkbox_for_deleting = 'attachment' . $order_index . '_checkbox_for_deleting';
                ?>
        <p>
            <span class="checkDelete">
        <?php
        echo $form->checkBox($model, $attachment_checkbox_for_deleting
                , array('value' => 1, 'uncheckValue' => 0)
        );
        ?>  削除する
            </span>
        </p>
        <?php
    }

    function echoFileForUploadingFile($model, $form, $order_index) {
        $attachment_checkbox_for_deleting = 'attachment' . $order_index;
        echo '<p>' . $form->fileField($model, $attachment_checkbox_for_deleting) . '</p>';
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    function add($model, $form) {
        $this->regist($model, $form);
    }

    /**
     * @param CActiveRecord $model 
     * @return html 
     */
    function addConfirm($model, $form) {
        $this->registConfirm($model, $form);
    }

}

