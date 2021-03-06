<?php
defined('_JEXEC') or die('Restricted access');
//include_once (JPATH_ROOT.DS.'components'.DS.'com_sitemain'.DS.'header.php');
?>
&nbsp;
<div class="container">
    
    <div class="form_heading">
        Upload You Artwork
    </div>
    <div id="info_alert" class="alert alert-error" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" onclick="return closeInfoAlert();">×</button>
        <b>Opps!</b> <span id="info_text">You best check yourself, you're not looking so good.</span>
    </div>
    
    <div class="form_body">
        <!-- If uploading single file, 'task=uploadfile' It is outdated-->
        <form id="form1" onsubmit="return validateForm();" action="/index.php?option=com_sitemain&task=uploadmultiplefiles" method="post" enctype="multipart/form-data">
            <div class="form_line upload_width">
                <div class="form_label upload_width"></div>
                <div class="form_input">
                    <input type="text" id="title" name="title" value="Title" />
                </div>
                <div class="form_note"></div>
            </div>
            <div class="form_line upload_width">
                <div class="form_label upload_width">Category</div>
                <div class="form_input">
                    <select id="category_id" name="category_id">
                        <option value="0">Please select</option>
                        <?php
                        foreach($this -> categories as $cate){
                             echo $cate['children'];
                             if(count($cate['children'])>0 ){
                                 echo "<optgroup label='".$cate['parent']->name."'>";
                                foreach($cate['children'] as $ca){
                                    echo "<option class='child_option' value='".$ca->category_id."'>".$ca->name."</option>";
                                }
                                echo "</optgroup>";
                             }else{
                                 echo "<option class='parent_option' value='".$cate['parent']->category_id."'>".$cate['parent']->name."</option>";
                             }
                                
                        }
                        ?>
                    </select>
                </div>
                <div class="form_note"></div>
            </div>
            <div class="form_line upload_width">
                <div class="form_label upload_width"></div>
                <div class="form_input">
                    <input type="text" id="tags" name="tags" value="Tags" />
                </div>
                <div class="form_note">
                    Tags are separated by space(" ") or comma(,).
                </div>
            </div>
            
            
<!--            <div class="form_line upload_width">
                <div class="form_label upload_width"></div>
                <div class="form_input">
                    <textarea id="meta_desc" name="meta_desc" row="3" col="50" maxlength="200">Meta Description</textarea>
                </div>
                <div class="form_note">This is a short version of description. For promoting purpose. Maximum 200 characters.</div>
            </div>-->
            <div class="form_line upload_width">
                <div class="form_label upload_width">Artwork Images</div>
                <div class="form_input">
                    <!-- If uploading single file. It is outdated -->
                    <!-- <input type="file" id="Filedata" name="Filedata" /> -->
                    <input type="file" id="Filedata" name="Filedata[]" multiple="multiple" />
                </div>
                <div class="form_note">
                    Choose more than one photo of your artwork if available.
                </div>
            </div>
            <div class="form_line upload_width">
                <div class="form_label upload_width"></div>
                <div class="form_input">
                    <textarea id="desc" name="desc" row="10" col="50" >Description</textarea>
                </div>
                <div class="form_note"></div>
            </div>
            <div class="form_line upload_width">
                <div class="form_note">
                    By clicking 'Upload', you agree to our <a target="_blank" href="<?php echo JUri::base().'index.php?option=com_sitemain&view=articles&c_id=83&a_id=76' ?>">Terms and Conditions</a><br/><br/>
                </div>
                <div class="form_input" style="font-size:13px;">
                    <input type="submit" value="Upload" id="btnSubmit" class="submit_btn" />
                </div>
                
            </div>
        </form>
    </div>
    <script>
           jQuery("#title").focus(function(){
                formFocus(this, 'Title',1)
            });
            jQuery("#title").blur(function(){
                formFocus(this, 'Title',0)
            });
            jQuery("#tags").focus(function(){
                formFocus(this, 'Tags',1)
            });
            jQuery("#tags").blur(function(){
                formFocus(this, 'Tags',0)
            });
            jQuery("#meta_desc").focus(function(){
                formFocus(this, 'Meta Description',1)
            });
            jQuery("#meta_desc").blur(function(){
                formFocus(this, 'Meta Description',0)
            });
            jQuery("#desc").focus(function(){
                formFocus(this, 'Description',1)
            });
            jQuery("#desc").blur(function(){
                formFocus(this, 'Description',0)
            });
    
    </script>
    <div class="explian_panel upload_panel">
        <div class="explain_heading">
            Good To Know
        </div>
        <div class="explain_text">
            <p>
                <a href='<?php echo JRoute::_('index.php?option=com_sitemain&view=upload') ?>'>Link</a>
            </p>
            <p>
                It might take us up to 48 hours to process your uploaded image(s). But most of times, it can be done within an hour.
                
            </p>
            <p>
                After your artwork(s) is(are) published, it is always good practice to let it go viral.
            </p>
        </div>
    </div>
</div>