
<p><a href="<?php echo base_url() ?><?php echo $this->uri->segment(1) ?>" class="btn btn-primary"><i class="icon-arrow-left"></i>Go back</a></p>

<?php if (validation_errors()): ?>
    <div class="alert alert-error">
        <?php echo validation_errors() ?>
    </div>
<?php endif ?>

<?php echo form_open('', array('id'=>'edit-form', 'class'=>'form-horizontal')) ?>    

    <legend>
        <?php if ($item): ?>
            Edit
        <?php else: ?>
            New
        <?php endif ?>
    </legend>    
        <fieldset class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
                <input type="text" name = "name" id = "name" class = "input-xxlarge" value = "<?php echo $_POST && isset($_POST['name']) ? $_POST['name'] : ($item ? $item->name : '') ?>"/>
            </div>
        </fieldset>  
        <fieldset class="control-group">
            <label class="control-label" for="game_id">Game_id</label>
            <div class="controls">
                <input type="text" name = "game_id" id = "game_id" class = "input-xxlarge" value = "<?php echo $_POST && isset($_POST['game_id']) ? $_POST['game_id'] : ($item ? $item->game_id : '') ?>"/>
            </div>
        </fieldset>  
        <fieldset class="control-group">
            <label class="control-label" for="order">Order</label>
            <div class="controls">
                <input type="text" name = "order" id = "order" class = "input-xxlarge" value = "<?php echo $_POST && isset($_POST['order']) ? $_POST['order'] : ($item ? $item->order : '') ?>"/>
            </div>
        </fieldset>      
    <fieldset class="form-actions">
        <button class="btn btn-primary"><i class="icon-ok"></i>Save</button> &nbsp; <a class="btn" href="<?php echo base_url() ?>/<?php echo $this->uri->segment(1) ?>">Cancel</a>
    </fieldset>    
<?php echo form_close() ?>
