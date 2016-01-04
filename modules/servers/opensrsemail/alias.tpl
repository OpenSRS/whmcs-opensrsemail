<style type="text/css">{$css}</style>
<div class="page-header nav-header">
	<h1>{$lang.addalias}</h1>
</div>
{foreach from=$error item=e}
	{if $e != ""}
            <p class="alert alert-danger">{$e}</p>
       {/if}
{/foreach}
<form action="clientarea.php?action=productdetails&id={$serviceid}&modop=custom&a=mailbox&type={$type}" class="form-stacked" method="post">
	<input type="hidden" name="modaction" value="save-alias" />
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label class="control-label" for="alias">{$lang.aliasname}</label>
                <div class="clearfix"></div>
                <div class="form-inline">
                    <div class="form-group">
                        <input class="form-control" name="alias" value="{$alias}" type="text">
                    </div>
                    <div class="form-group">
                        <label>@</label>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="alias_domain" id="alias_domain">
                        {foreach from=$alias_domains item=alias_domain}
                            <option value="{$alias_domain.alias_domain}">{$alias_domain.alias_domain}</option>
                        {/foreach}
                        </select>
                    </div>
                    
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="mailbox">{$lang.mailboxname}</label>
				<div class="form-inline">
					<select class="form-control" name="mailbox">
						{foreach from=$mailboxes item=mailbox}
							<option value="{$mailbox.mailbox}">{$mailbox.mailbox}</option>
						{/foreach}
					</select>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-primary" type="submit">{$lang.save}</button>
	<a class="btn btn-danger" href="clientarea.php?action=productdetails&id={$serviceid}">{$lang.cancel}</a>
</form>