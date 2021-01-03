<div class="caldera-config-group">
    <label><?php echo __('Sheet ID', 'cfgsconnector'); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config required" name="{{_name}}[sheet-id]" value="{{sheet-id}}">
    </div>
</div>
<div class="caldera-config-group">
    <label><?php echo __('Tab Name', 'cfgsconnector'); ?> </label>
    <div class="caldera-config-field">
        <input type="text" class="block-input field-config required" name="{{_name}}[sheet-tab-name]" value="{{sheet-tab-name}}">
    </div>
</div>
<div class="caldera-config-group">
	<label><?php echo __('Header', 'cfgsconnector'); ?> </label>
	<div class="caldera-config-field">
		<label><input type="checkbox" class="field-config" name="{{_name}}[header]" id="{{_id}}_header" value="1" {{#if header}}checked="checked"{{/if}}> Automatically generate header for all fields</label>
	</div>
</div>

