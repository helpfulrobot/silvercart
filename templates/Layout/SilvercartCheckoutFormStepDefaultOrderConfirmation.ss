<br/>
{$Controller.ContentStep6}
<form class="form form-horizontal grouped" $FormAttributes>

    $CustomHtmlFormMetadata
    $CustomHtmlFormErrorMessages

    <h4><% _t('SilvercartPage.ORDER_COMPLETED','Your order is completed') %></h4>
    <p><% _t('SilvercartPage.ORDER_THANKS','Many thanks for Your oder.') %></p>
    <p><% _t('SilvercartPage.ORDERS_EMAIL_INFORMATION_TEXT','Please check Your email inbox for the order confirmation.') %></p>
    <% if currentMember.currentRegisteredCustomer %>
    <p><% _t('SilvercartPage.VIEW_ORDERS_TEXT','You can check the status of Your order any time in the') %> <a href="$Controller.PageByIdentifierCodeLink(SilvercartOrderHolder)"><% _t('SilvercartOrderHolder.SINGULARNAME') %></a>.<br/>
        <br/>
        <a class="btn btn-primary btn-block-sm" href="$Controller.PageByIdentifierCodeLink(SilvercartOrderHolder)"><% _t('SilvercartOrderHolder.SINGULARNAME') %></a>
    </p>
    <% end_if %>

    $PaymentConfirmationText
</form>

$CustomOutput

<% with Controller %>
    {$SiteConfig.GoogleConversionTrackingCode.Raw}
<% end_with %>