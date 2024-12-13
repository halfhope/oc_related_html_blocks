<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<style>
html {
	overflow-y: scroll;
}
.input-code {
	min-height: 250px;
}
.btn-divider {
	display: inline-block;
	width: 1px;
	padding: 7px 0px;
	margin: 0px 5px;
	background: #cdcdcd;
	border: none;
}
</style>
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $list ?>" data-toggle="tooltip" title="<?php echo $button_cancel ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
				<span type="button" class="btn-divider">&nbsp;</span>
				<div class="btn-group" data-toggle="tooltip" title="<?php echo $button_modules; ?>">
					<a href="<?php echo $modules_link; ?>" type="button" class="btn btn-success"><?php echo $button_modules; ?></a>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo $add_module; ?>"><?php echo $button_add; ?></a></li>
						<?php if (!empty($modules)) { ?>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header"><?php echo $button_modules; ?></li>
						<?php foreach ($modules as $module) { ?> 
						<li><a href="<?php echo $module['edit']; ?>"><?php echo $module['name']; ?></a></li>
						<?php } ?>
						<?php } ?>
					</ul>
				</div>
				<div class="btn-group" data-toggle="tooltip" title="<?php echo $text_list; ?>">
					<a href="<?php echo $list; ?>" type="button" class="btn btn-success"><?php echo $text_list; ?></a>
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?php echo $add_block; ?>"><?php echo $button_add; ?></a></li>
						<?php if (!empty($htmls_top)) { ?>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header"><?php echo $text_list; ?></li>
						<?php foreach ($htmls_top as $html) { ?> 
						<li><a href="<?php echo $html['edit']; ?>"><?php echo $html['name']; ?></a></li>
						<?php } ?>
						<?php } ?>
					</ul>
				</div>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?> 
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger alert-dismissible" data-countdown><i class="fa fa-exclamation-circle"></i> <span class="countdown">[2]</span> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible" data-countdown><i class="fa fa-check-circle"></i> <span class="countdown">[2]</span> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_multiple; ?></h3><h3 class="panel-title pull-right">v<?php echo $version; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">
					<?php if ($htmls) { ?>
					<?php foreach ($htmls as $html) { ?>

						<input type="hidden" name="htmls[<?php echo $html['html_id'] ?>][html_id]" value="<?php echo $html['html_id'] ?>">

						<fieldset>
							<legend><?php echo $html['name'] ?></legend>

							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-name<?php echo $html['html_id'] ?>"><?php echo $entry_name ?></label>
								<div class="col-sm-10">
									<input type="text" name="htmls[<?php echo $html['html_id'] ?>][name]" id="input-name<?php echo $html['html_id'] ?>" class="form-control" value="<?php echo $html['name'] ?>" placeholder="<?php echo $entry_name ?>">
									<?php if (isset($error_name[$html['html_id']])) { ?>
										<div class="text-danger"><?php echo $error_name[$html['html_id']] ?></div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-sort-order<?php echo $html['html_id'] ?>"><?php echo $entry_sort_order ?></label>
								<div class="col-sm-10">
									<input type="text" name="htmls[<?php echo $html['html_id'] ?>][sort_order]" id="input-sort-order<?php echo $html['html_id'] ?>" class="form-control" value="<?php echo $html['sort_order'] ?>" placeholder="<?php echo $entry_sort_order ?>">
								</div>
							</div>

							<ul class="nav nav-tabs" id="language<?php echo $html['html_id'] ?>">
								<?php foreach ($languages as $language) { ?>
								<li><a href="#language<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>" data-toggle="tab"><img src="language/<?php echo $language['code'] ?>/<?php echo $language['code'] ?>.png" title="<?php echo $language['name'] ?>" /> <?php echo $language['name'] ?></a></li>
								<?php } ?>
							</ul>

							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div class="tab-pane" id="language<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>">

									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-code-<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>"><?php echo $entry_code_block ?></label>
										<div class="col-sm-10">
											<pre id="input-code-<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>" class="input-code"></pre>
											<input type="hidden" name="htmls[<?php echo $html['html_id'] ?>][code][<?php echo $language['language_id'] ?>]" id="hidden-code-<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>" value="<?php echo $html['code'][$language['language_id']] ?>">
										</div>
									</div>

								</div>
								<?php } ?>
							</div>

						</fieldset>

					<?php } ?>
					
					<?php } else { ?>
						<div class="text-center" colspan="5"><?php echo $text_no_results; ?></div>
					<?php } ?>
				</form>
				
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.9.6/ace.min.js" integrity="sha512-U2JKYiHG3ixOjmdycNbi4Xur8q4Nv73CscCGEopBeiVyzDR5ErC6jmHNr0pOB8CUVWb0aQXLgL0wYXhoMU6iqw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
<?php foreach ($htmls as $html) { ?>
<?php foreach ($languages as $language) { ?>
let jsEditorWrapper_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>;
let jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>;
<?php } ?>
<?php } ?>
$(document).ready(function() {

	<?php foreach ($htmls as $html) { ?>
	$('#language<?php echo $html['html_id'] ?> a:first').tab('show');
	<?php } ?>

	window.ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.9.6/');
	<?php foreach ($htmls as $html) { ?>
	<?php foreach ($languages as $language) { ?>
	jsEditorWrapper_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?> = document.querySelector('#input-code-<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>');
	jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?> = window.ace.edit(jsEditorWrapper_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>);
	jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>.setTheme('ace/theme/textmate');
	jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>.session.setMode('ace/mode/html');

	jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>.setValue($('#hidden-code-<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>').val(), -1);
	jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>.focus();
	<?php } ?>
	<?php } ?>

	$('#form-module').on('submit', function(e) {
		<?php foreach ($htmls as $html) { ?>
		<?php foreach ($languages as $language) { ?>
		$('#hidden-code-<?php echo $html['html_id'] ?>-<?php echo $language['language_id'] ?>').val(jsEditor_<?php echo $html['html_id'] ?>_<?php echo $language['language_id'] ?>.getValue());
		<?php } ?>
		<?php } ?>
		return true;
	});

	$('[data-countdown]').each(function(index, value) {
		let tid = setInterval(() => {
			let current = parseInt($(value).find('.countdown').text().match(/(\d+)/));
			$(value).find('.countdown').text('[' + (current - 1) + ']');
			if (current == 1) {
				clearInterval(tid);
				$(value).remove();
			}
		}, 1000);
	});

});
</script>
<?php echo $footer; ?>