<div id="col1">
    <div id="col1_content" class="clearfix">
        <div class="typography">
            <h2><% _t('SilvercartSearchResultsPage.TITLE') %></h2>

            <% if getProducts %>
                <% include SilvercartProductPagination %>
                $RenderProductGroupPageGroupView
                <% include SilvercartProductPagination %>
            <% end_if %>
        </div>
    </div>
</div>
<div id="col3">
    <div id="col3_content" class="clearfix">
        $InsertWidgetArea(Sidebar)
        $SubNavigation
    </div>
    <div id="ie_clearing"> &#160; </div>
</div>