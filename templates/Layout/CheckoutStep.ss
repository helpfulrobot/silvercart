<div id="col1">
    <div id="col1_content" class="clearfix">

		<h2>$Title</h2>

		$Content
        $InsertCustomHtmlForm
        $Process

        <% if CustomHtmlFormStepLinkCancel %>
            <a href="$CustomHtmlFormStepLinkCancel">Abbrechen</a>
        <% end_if %>

        $PageComments

    </div>
</div>

<div id="col3">
    <div id="col3_content" class="clearfix">

        <div class="sidebarBox">
            <div class="sidebarBox_content">
                <strong>Schritte</strong>

                <ul>
                <% control StepList %>
					<% if stepIsVisible %>
						<li<% if isCurrentStep %> class="active"<% end_if %>>
							<% if stepIsCompleted %>
								<a href="$Link">$title</a>
							<% else %>
								<p>$title</p>
							<% end_if %>
						</li>
					<% end_if %>
                <% end_control %>
                </ul>

            </div>
        </div>

    </div>

     <!-- IE Column Clearing -->
    <div id="ie_clearing"> &#160; </div>
</div>