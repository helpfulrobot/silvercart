<div id="{$FormName}_{$FieldName}_Box" class="type-check<% if errorMessage %> error<% end_if %>">
    <% if errorMessage %>
        <div class="errorList">
            <% control errorMessage %>
				<strong class="message">
					{$message}
				</strong>
            <% end_control %>
        </div>
    <% end_if %>
    $FieldTag
    <label for="{$FormName}_{$FieldName}"><% _t('SilvercartPage.I_ACCEPT','I accept the') %> <a href="{$PageByIdentifierCode(SilvercartMetaNavigationHolder).Link}<% _t('SilvercartPage.URL_SEGMENT_TERMS') %>"><% _t('SilvercartPage.TITLE_TERMS') %></a> </label>
</div>