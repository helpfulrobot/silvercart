<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de-DE" lang="de-DE">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><% _t('SilvercartOrder.SINGULARNAME') %> $OrderNumber | $Created.Nice</title>
    </head>
    <body>

        <table>
            <colgroup>
                <col width="40%"></col>
                <col width="30%"></col>
                <col width="30%"></col>
            </colgroup>
            <tr>
                <td valign="top">
                    <h2><% _t('SilvercartOrderDetailPage.TITLE') %>:</h2>

                    <table>
                        <tr>
                            <td><% _t('SilvercartAddress.EMAIL') %></td>
                            <td>$CustomersEmail</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartPage.ORDER_DATE') %></td>
                            <td>$Created.Nice</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartNumberRange.ORDERNUMBER') %></td>
                            <td>$OrderNumber</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartOrder.STATUS') %></td>
                            <td>$SilvercartOrderStatus.Title</td>
                        </tr>
                        <% if Note %>
                            <tr>
                                <td><% _t('SilvercartOrder.YOUR_REMARK') %></td>
                                <td>$FormattedNote</td>
                            </tr>
                        <% end_if %>
                    </table>
                </td>
                <td valign="top">
                <% if InvoiceAddressEqualsShippingAddress %>
                    <h2><% _t('SilvercartPage.SHIPPING_AND_BILLING') %>:</h2>
                <% else %>
                    <h2><% _t('SilvercartPage.SHIPPING_ADDRESS') %>:</h2>
                <% end_if %>
                    <% with SilvercartShippingAddress %>
                    <table>
                        <% if TaxIdNumber %>
                            <tr>
                                <td><% _t('SilvercartAddress.TAXIDNUMBER') %></td>
                                <td>$TaxIdNumber</td>
                            </tr>
                        <% end_if %>
                        <% if Company %>
                            <tr>
                                <td><% _t('SilvercartAddress.COMPANY') %></td>
                                <td>$Company</td>
                            </tr>
                        <% end_if %>
                        <tr>
                            <td><% _t('SilvercartAddress.FIRSTNAME') %></td>
                            <td>$FirstName</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.SURNAME') %></td>
                            <td>$Surname</td>
                        </tr>
                        <% if Addition %>
                        <tr>
                            <td><% _t('SilvercartAddress.ADDITION') %></td>
                            <td>$Addition</td>
                        </tr>
                        <% end_if %>
                        <% if IsPackstation %>
                        <tr>
                            <td><% _t('SilvercartAddress.POSTNUMBER_PLAIN') %></td>
                            <td>$PostNumber</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.PACKSTATION_PLAIN') %></td>
                            <td>$Packstation</td>
                        </tr>
                        <% else %>
                        <tr>
                            <td><% _t('SilvercartAddress.STREET') %></td>
                            <td>$Street</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.STREETNUMBER') %></td>
                            <td>$StreetNumber</td>
                        </tr>
                        <% end_if %>
                        <tr>
                            <td><% _t('SilvercartAddress.POSTCODE') %></td>
                            <td>$Postcode</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.CITY') %></td>
                            <td>$City</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.PHONE') %></td>
                            <td><% if Phone %>{$PhoneAreaCode} {$Phone}<% else %>---<% end_if %></td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.FAX') %></td>
                            <td>$Fax</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartCountry.SINGULARNAME') %></td>
                            <td>$SilvercartCountry.Title</td>
                        </tr>
                    </table>
                    <% end_with %>
                </td>
                <td valign="top">
                <% if InvoiceAddressEqualsShippingAddress %>
                <% else %>
                    <h2><% _t('SilvercartInvoiceAddress.SINGULARNAME') %>:</h2>
                    <% with SilvercartInvoiceAddress %>
                    <table>
                        <% if TaxIdNumber %>
                            <tr>
                                <td><% _t('SilvercartAddress.TAXIDNUMBER') %></td>
                                <td>$TaxIdNumber</td>
                            </tr>
                        <% end_if %>
                        <% if Company %>
                            <tr>
                                <td><% _t('SilvercartAddress.COMPANY') %></td>
                                <td>$Company</td>
                            </tr>
                        <% end_if %>
                        <tr>
                            <td><% _t('SilvercartAddress.FIRSTNAME') %></td>
                            <td>$FirstName</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.SURNAME') %></td>
                            <td>$Surname</td>
                        </tr>
                        <% if Addition %>
                        <tr>
                            <td><% _t('SilvercartAddress.ADDITION') %></td>
                            <td>$Addition</td>
                        </tr>
                        <% end_if %>
                        <tr>
                            <td><% _t('SilvercartAddress.STREET') %></td>
                            <td>$Street</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.STREETNUMBER') %></td>
                            <td>$StreetNumber</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.POSTCODE') %></td>
                            <td>$Postcode</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.CITY') %></td>
                            <td>$City</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.PHONE') %></td>
                            <td><% if Phone %>{$PhoneAreaCode} {$Phone}<% else %>---<% end_if %></td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartAddress.FAX') %></td>
                            <td>$Fax</td>
                        </tr>
                        <tr>
                            <td><% _t('SilvercartCountry.SINGULARNAME') %></td>
                            <td>$SilvercartCountry.Title</td>
                        </tr>
                    </table>
                    <% end_with %>
                <% end_if %>
                </td>
            </tr>
        </table>

        <h2><% _t('SilvercartPage.ORDERED_PRODUCTS') %>:</h2>
        $OrderDetailTable
    
        <br/>
        <br style="page-break-after: always;"/>
        <button onclick="javascript:window.print();"><% _t('SilvercartOrder.PRINT') %></button>
    </body>
</html>