<div class="row">
    <div class="span9">
        <% include SilvercartBreadCrumbs %>
        <h1>{$Title}</h1>

        $Content
        <% if Form %>
            <div class="yform silvercart-system-form">
                $Form
            </div>
        <% end_if %>
        
        <div class="silvercartWidgetHolder">
            <div class="silvercartWidgetHolder_content">
                $InsertWidgetArea(Content)
            </div>
        </div>
        
        $PageComments
    </div>
    <aside class="span3">
        $SubNavigation
        $InsertWidgetArea(Sidebar)
    </aside>
</div>
