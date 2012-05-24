
    <fieldset class="control-group">
        <label class="control-label" for="<?php echo $prefix ? $prefix : '' ?>ga_category">Category</label>
        <div class="controls">
            <input type="text" name = "<?php echo $prefix ? $prefix : '' ?>ga_category" id = "<?php echo $prefix ? $prefix : '' ?>ga_category" class = "span4" value = "<?php $prop = $prefix.'ga_category'; echo $_POST && isset($_POST[$prop]) ? $_POST[$prop] : ($item ? $item->$prop : '') ?>"/>
        </div>
    </fieldset>
    <fieldset class="control-group">
        <label class="control-label" for="<?php echo $prefix ? $prefix : '' ?>ga_action">Action</label>
        <div class="controls">
            <!-- <input type="text" name = "<?php echo $prefix ? $prefix : '' ?>ga_action" id = "<?php echo $prefix ? $prefix : '' ?>ga_action" class = "input-xlarge" value = "<?php $prop = $prefix.'ga_action';  echo $_POST && isset($_POST[$prop]) ? $_POST[$prop] : ($item ? $item->$prop : '') ?>"/> -->
            <?php 
                $prop = $prefix.'ga_action';   
                $actions = array('Click'=>'Click', 'Play'=>'Play', 'Download'=>'Download');
            ?>

            <?php echo form_dropdown(
                            $item->$prop && !in_array($item->$prop, $actions) ? '' : $prefix.'ga_action', 
                            $actions, 
                            $_POST && isset($_POST[$prop]) ? $_POST[$prop] : ($item ? $item->$prop : ''), 
                                'id="ga-action-select"'. ($item->$prop && !in_array($item->$prop, $actions) ? 'style="display:none"' : '')
                        )  
            ?>

            <a href="#" class="btn add-custom-action" style="<?php echo !$item->$prop || in_array($item->$prop, $actions) ? '' : 'display:none' ?>"><i class="icon-plus-sign"></i></a>
            
            <p style="<?php echo $item->$prop && !in_array($item->$prop, $actions) ? '' : 'display:none' ?>">
                <input type="" value="<?php echo !in_array($item->$prop, $actions) ? $item->$prop : '' ?>" <?php echo !$item->$prop || in_array($item->$prop, $actions) ? '' : 'name="'.$prefix.'ga_action'.'"' ?>>
                <a href="#" class="cance-custom-action"><i class="icon-trash"></i></a>
            </p>
        </div>
    </fieldset>
    <fieldset class="control-group">
        <label class="control-label" for="<?php echo $prefix ? $prefix : '' ?>ga_label">Label</label>
        <div class="controls">
            <input type="text" name = "<?php echo $prefix ? $prefix : '' ?>ga_label" id = "<?php echo $prefix ? $prefix : '' ?>ga_label" class = "span4" value = "<?php $prop = $prefix.'ga_label';  echo $_POST && isset($_POST[$prop]) ? $_POST[$prop] : ($item ? $item->$prop: '') ?>"/>
        </div>
    </fieldset>
    <fieldset class="control-group">
        <label class="control-label" for="<?php echo $prefix ? $prefix : '' ?>ga_value">Value</label>
        <div class="controls">
            <input type="text" name = "<?php echo $prefix ? $prefix : '' ?>ga_value" id = "<?php echo $prefix ? $prefix : '' ?>ga_value" class = "span4" value = "<?php $prop = $prefix.'ga_value';  echo $_POST && isset($_POST[$prop]) ? $_POST[$prop] : ($item && $item->$prop ? $item->$prop : '1') ?>"/>
        </div>
    </fieldset>
    <fieldset class="control-group">
        <label class="control-label inline-block" for="<?php echo $prefix ? $prefix : '' ?>ga_noninteraction">Non interaction</label>
        <div class="controls inline-block">
            <input type="checkbox" name = "<?php echo $prefix ? $prefix : '' ?>ga_noninteraction" id = "<?php echo $prefix ? $prefix : '' ?>ga_noninteraction" value = "<?php $prop = $prefix.'ga_noninteraction';  echo $_POST && isset($_POST[$prop]) ? 'checked="checked"' : ($item && $item->$prop ? 'checked="checked"' : '') ?>"/>
        </div>
    </fieldset>
