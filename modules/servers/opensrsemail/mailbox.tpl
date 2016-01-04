<style type="text/css">{$css}</style>
<div class="page-header nav-header">
	{if $new}
		<h1>{$lang.addmailbox}</h1>
	{else}
		<h1>{$lang.editmailbox}</h1>
	{/if}
</div>
{if $deleteRequired}
	<p class="alert alert-danger">{$lang.deleterequired}</p>
{else}
	{foreach from=$error item=e}
       {if $e != ""}
		    <p class="alert alert-danger">{$e}</p>
       {/if}
	{/foreach}
	{if $mailbox}
		<form action="clientarea.php?action=productdetails&id={$serviceid}&modop=custom&a=mailbox{if !$new}&mailbox={$mailbox.mailbox}&workgroup={$workgroup}{/if}&type={$type}" class="form-stacked" method="post">
			<input type="hidden" name="modaction" value="save-mailbox" />
			<div class="row">
				<div class="col-sm-6">
					<h3>{$lang.mailboxinfo}</h3>
					{if $new}
						<input type="hidden" name="new" value="true" />
						<div class="form-group">
							<label class="control-label" for="mailbox">{$lang.mailboxname}</label>
							<div class="control">
								<input class="form-control small" type="text" name="mailbox" value="{$mailbox.mailbox}" /><span id="sdomain" class="row-text">@{$domain}</span>
							</div>
						</div>
					{else}
						<div class="form-group">
							<label class="control-label" for="mailbox">{$lang.mailboxname}</label>
							<div class="control">
								<input type="hidden" name="mailbox" value="{$mailbox.mailbox}" />
                                <!-- <span class="row-text">{$mailbox.mailbox}@{$domain}</span> -->
								<span class="row-text">{$mailbox.mailbox}</span>
							</div>
						</div>
					{/if}
					<div class="form-group">
						<label class="control-label" for="password">{$lang.password} {if !$new}{$lang.blankfornochange}{/if}</label>
						<div class="control">
							<input class="form-control" type="password" name="password" style="margin-bottom: 10px"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="passwordConfirm">{$lang.confirmpassword}</label>
						<div class="control">
							<input class="form-control" type="password" name="passwordConfirm" style="margin-bottom: 20px"/>
                            <input class="form-control" id="random" for="generatedPassword" style="margin-bottom: 10px"/>
						</div>
                         <div class="control">
                            <button class="btn btn-primary" type="button" id="generatePassword" name="generatePassword">Generate Password</button>
					     </div>
				    </div>
                 </div>
                <BR/>
				<div class="col-sm-6">
					<h3>{$lang.userinfo}</h3>
					<div class="form-group">
						<label class="control-label" for="title">{$lang.title}</label>
						<div class="control">
							<input class="form-control" type="text" name="title" value="{$mailbox.title}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="firstName">{$lang.firstname}</label>
						<div class="control">
							<input class="form-control" type="text" name="firstName" value="{$mailbox.first_name}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="lastName">{$lang.lastname}</label>
						<div class="control">
							<input class="form-control" type="text" name="lastName" value="{$mailbox.last_name}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="phone">{$lang.phone}</label>
						<div class="control">
							<input class="form-control" type="text" name="phone" value="{$mailbox.phone}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="fax">{$lang.fax}</label>
						<div class="control">
							<input class="form-control" type="text" name="fax" value="{$mailbox.fax}" />
						</div>
					</div>
				</div>
			</div>
			<button class="btn btn-primary" type="submit">{$lang.save}</button>
			<a class="btn btn-danger" href="clientarea.php?action=productdetails&id={$serviceid}">{$lang.cancel}</a>
		</form>
	{/if}
{/if}