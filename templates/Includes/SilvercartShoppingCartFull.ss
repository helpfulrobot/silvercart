<% if CurrentMember.SilvercartShoppingCart.isFilled %>
    <% control CurrentMember %>
        <% control SilvercartShoppingCart %>
            <fieldset>
                <legend><% _t('SilvercartProduct.TITLE') %></legend>
                <table class="cartSummary">
                    <thead>
                        <tr>
                            <th><% _t('SilvercartPage.PRODUCTNAME','product name') %></th>
                            <th><% _t('SilvercartProduct.PRICE_SINGLE', 'price single') %></th>
                            <th><% _t('SilvercartProduct.VAT','VAT') %></th>
                            <th class="right"><% _t('SilvercartProductPage.QUANTITY') %></th>
                            <th class="right"><% _t('SilvercartProduct.PRICE') %></th>

                            <% if Top.EditableShoppingCart %>
                                <th></th>
                                <th></th>
                            <% end_if %>
                        </tr>
                    </thead>

                    <tbody>
                        <% control SilvercartShoppingCartPositions %>
                            <tr<% if Last %> class="separator"<% end_if %>>
                                <td>$SilvercartProduct.Title</td>
                                <td class="right">$SilvercartProduct.Price.Nice</td>
                                <td class="right">{$SilvercartProduct.SilvercartTax.Rate}%</td>
                                <td class="right">$Quantity</td>
                                <td class="right">$Price.Nice</td>

                                <% if Top.EditableShoppingCart %>
                                    <td>$IncrementPositionQuantityForm $DecrementPositionQuantityForm</td>
                                    <td>$RemovePositionForm</td>
                                <% end_if %>
                            </tr>
                        <% end_control %>

                        <% control registeredModules %>
                            <% if TaxableShoppingCartPositions %>
                                <% control TaxableShoppingCartPositions %>
                                    <tr>
                                        <td>$Name</td>
                                        <td class="right">$PriceFormatted</td>
                                        <td class="right">$SilvercartTax.Title</td>
                                        <td class="right">$Quantity</td>
                                        <td class="right">$PriceTotalFormatted</td>

                                        <% if Top.EditableShoppingCart %>
                                            <td>&nbsp;</td>
                                            <td>$removeFromCartForm</td>
                                        <% end_if %>
                                    </tr>
                                <% end_control %>
                            <% end_if %>
                        <% end_control %>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong><% _t('SilvercartPage.SUBTOTAL','subtotal') %></strong></td>
                            <td class="right" id="Sum"><strong>$TaxableAmountGrossWithoutFees.Nice</strong></td>

                            <% if Top.EditableShoppingCart %>
                                <td></td>
                                <td></td>
                            <% end_if %>
                        </tr>

                        <% if TaxRatesWithoutFees %>
                            <% control TaxRatesWithoutFees %>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><% _t('SilvercartPage.INCLUDED_VAT','included VAT') %> ({$Rate}%)</td>
                                <td class="right">$Amount.Nice</td>

                                <% if Top.EditableShoppingCart %>
                                    <td></td>
                                    <td></td>
                                <% end_if %>
                            </tr>
                            <% end_control %>
                        <% end_if %>

                        <% if ShowFees %>
                            <tr>
                                <td><% _t('SilvercartPaymentMethod.SHIPPINGMETHOD') %>: $CarrierAndShippingMethodTitle</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="right">$HandlingCostShipment.Nice</td>

                                <% if Top.EditableShoppingCart %>
                                    <td></td>
                                    <td></td>
                                <% end_if %>
                            </tr>
                            <tr>
                                <td><% _t('SilvercartPaymentMethod.SHIPPINGMETHOD') %>: $payment.Title</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="right">$HandlingCostPayment.Nice</td>

                                <% if Top.EditableShoppingCart %>
                                    <td></td>
                                    <td></td>
                                <% end_if %>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong><% _t('SilvercartPage.SUBTOTAL') %></strong></td>
                                <td class="right" id="Sum"><strong>$TaxableAmountGrossWithFees.Nice</strong></td>

                                <% if Top.EditableShoppingCart %>
                                    <td></td>
                                    <td></td>
                                <% end_if %>
                            </tr>

                            <% if TaxRatesWithFees %>
                                <% control TaxRatesWithFees %>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><% _t('SilvercartPage.INCLUDED_VAT','included VAT') %> ({$Rate}%)</td>
                                    <td class="right">$Amount.Nice</td>

                                    <% if Top.EditableShoppingCart %>
                                        <td></td>
                                        <td></td>
                                    <% end_if %>
                                </tr>
                                <% end_control %>
                            <% end_if %>

                        <% end_if %>

                        <% control registeredModules %>
                            <% if NonTaxableShoppingCartPositions %>
                                <% control NonTaxableShoppingCartPositions %>
                                    <tr>
                                        <td>$Name</td>
                                        <td class="right">$PriceFormatted</td>
                                        <td></td>
                                        <td class="right">$Quantity</td>
                                        <td class="right">$PriceTotalFormatted</td>

                                        <% if Top.EditableShoppingCart %>
                                            <td>&nbsp;</td>
                                            <td>$removeFromCartForm</td>
                                        <% end_if %>
                                    </tr>
                                <% end_control %>
                            <% end_if %>
                        <% end_control %>

                        <tr>
                            <td><strong><% _t('SilvercartPage.TOTAL','total') %></strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="right"><strong>$AmountTotal.Nice</strong></td>

                            <% if Top.EditableShoppingCart %>
                                <td></td>
                                <td></td>
                            <% end_if %>
                        </tr>
                    </tbody>

                </table>

                <div class="shoppingCartActions">
                    <% if registeredModules %>
                        <% control registeredModules %>
                            <% if ShoppingCartActions %>
                                <% control ShoppingCartActions %>
                                    $moduleOutput
                                <% end_control %>
                            <% end_if %>
                        <% end_control %>
                    <% end_if %>
                </div>
            </fieldset>
        <% end_control %>
    <% end_control %>
<% else %>
    <p><% _t('SilvercartCartPage.CART_EMPTY', 'Your cart is empty') %></p>
<% end_if %>