<% cached 'elements',Top.ID,Top.CurrentOffset %>
    <% if Elements %>
        <% control Elements %>
            <% if MultipleOf(2) %>
                <div class="c50r silvercart-product-group-page-box tile $EvenOdd">
            <% else %>
                <div class="subcolumns equalize clearfix">
                    <div class="c50l silvercart-product-group-page-box tile $EvenOdd">
            <% end_if %>

                <div class="silvercart-product-group-page-box_content">
                    <h3><a href="$Link" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title) %>">$Title</a></h3>
                    <div class="subcolumns clearfix equalize product-group-page-info">
                        <div class="c33l product-group-page-image">
                            <div class="subcl">
                            <% if SilvercartImages %>
                                <% control SilvercartImages.First %>
                                    <a href="$ProductLink" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Image.Title) %>">$Image.SetRatioSize(90,90)</a>
                                <% end_control %>
                            <% else %>

                            <% end_if %>
                            </div>
                        </div>
                        <div class="c66r">
                            <div class="subcr">
                                <strong><% _t('SilvercartProduct.PRODUCTNUMBER_SHORT') %>: $ProductNumberShop</strong>
                                <p>$ShortDescription</p>
                            </div>
                        </div>
                    </div>
                    <div class="silvercart-product-group-page-price">
                        <p>
                            <strong class="silvercart-price">$Price.Nice</strong>
                        </p>
                        <p>
                            <% if showPricesGross %>
                                <% sprintf(_t('SilvercartPage.INCLUDING_TAX', 'incl. %s%% VAT'),$TaxRate) %><br />
                            <% else %>
                                <% _t('SilvercartPage.EXCLUDING_TAX', 'plus VAT') %><br />
                            <% end_if %>
                            <% _t('SilvercartPage.PLUS_SHIPPING','plus shipping') %><br/>
                            <a href="$Link" title="<% sprintf(_t('SilvercartPage.SHOW_DETAILS_FOR','details'),$Title) %>"><% _t('SilvercartPage.SHOW_DETAILS','show details') %></a>
                        </p>
                    </div>
                    $productAddCartForm
                </div>
            </div>
            <% if MultipleOf(2) %>
                </div>
            <% else_if Last %>
                </div>
            <% end_if %>
        <% end_control %>
    <% end_if %>
<% end_cached %>