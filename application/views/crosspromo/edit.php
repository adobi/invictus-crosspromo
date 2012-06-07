      <div class="modal fade" id="edit-description-modal">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Edit crosspromo items</h3>
        </div>
        <?php echo form_open('', array('style'=>'margin-bottom:0;', 'id'=>'edit-description-form')) ?>
        <div class="modal-body">
          <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
              <textarea name="description"  class="span6" rows="3" data-countable="1" data-limit="160" data-parent=".modal-body" data-prepend=".modal-footer"><?php echo $item->description ?></textarea>
            </div>
          </div>          
          <div class="control-group">
            <label class="control-label">Type</label>
            <div class="controls">
              <?php echo form_dropdown('type_id', $types, $item->type_id, 'class="span6"') ?>
            </div>
          </div>
          <div class="row">
            <div class="span3 control-group">
              <label class="control-label">Until</label>
              <div class="controls">
                <input type="text" name="until" class="datepicker span2">
              </div>
            </div>                    
            <div class="span3 control-group">
              <label class="control-label">Promo price</label>
              <div class="controls">
                <input type="text" name="promo_price" class="span2"> <strong>$</strong>
              </div>
            </div>           
            </div>         
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
        <?php echo form_close() ?>
      </div>