<form class="yform full" $FormAttributes>
    $CustomHtmlFormMetadata
    $CustomHtmlFormErrorMessages

    <div class="subcolumns">
        <div class="c50l">
            <div class="subcl">
                $CustomHtmlFormFieldByName(emailaddress)
            </div>
        </div>

        <div class="c50r">
            <div class="subcr">
                $CustomHtmlFormFieldByName(password)
            </div>
        </div>
    </div>

    <div class="actionRow">
        <div class="type-button">
            <% control Actions %>
                $Field
            <% end_control %>
        </div>
    </div>

</form>