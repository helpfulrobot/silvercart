 <div id="{$FormName}_{$FieldName}_Box" class="input-append quantity<% if errorMessage %> error<% end_if %>">
    <%-- <label for="{$FormName}_{$FieldName}">{$Label}</label>  --%>

<% with FieldTag %>
    <input id="{$ID}" class="input-nano text-right" type="text" value="{$Value}" name="{$Name}">
<% end_with %>   
$CustomHtmlFormSpecialFields

<% with Parent.Actions %>
<button title="$Product.Title <% _t('SilvercartProduct.ADD_TO_CART','add Cart') %>" class="btn btn-small btn-primary" data-title="$Owner.Title <% _t('SilvercartProduct.ADD_TO_CART','add Cart') %>" data-placement="top" data-toggle="tooltip">
    <i class="icon-shopping-cart"></i> <span class="full-shopping-cart-title">{$Form.SubmitButtontitle}</span><span class="short-shopping-cart-title"><% _t('SilvercartPage.CART') %></span>
</button> 
<% end_with %>
</div>