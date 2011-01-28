<% if IncludeFormTag %>
<form class="yform" $FormAttributes>
<% end_if %>

      <% if messages %>
      <div class="error">
        <% control messages %>
        <p>$message</p>
        <% end_control %>
    </div>
    <% end_if %>

    <% if errorMessages %>
    <div class="error">
        <p><strong>Bitte pr&uuml;fen Sie Ihre Eingaben in folgenden Feldern:</strong></p>
        <ul>
            <% control errorMessages %>
            <li>$fieldname</li>
            <% end_control %>
        </ul>
    </div>
    <% end_if %>

    <fieldset>
        <legend>Login</legend>
        <p><strong>Bitte geben Sie Ihre Zugangsdaten ein:</strong></p>
        <div class="subcolumns">
            <div class="c50l">
                <div class="subcl">
                    <div id="{$FormName}_Email_Box" class="type-text<% control errorMessages %><% if Email.message %> error<% end_if %><% end_control %>">
                        <% control errorMessages %>
                        <% if Email.message %>
                        <strong class="error" id="{$FormName}_Email_Error">
                            $Email.message
                        </strong>
                        <% end_if %>
                        <% end_control %>
                        <label for="{$FormName}_Email">* Benutzername: </label>
                        $dataFieldByName(Email)
                    </div>
                </div>
            </div>
            <div class="c50r">
                <div class="subcr">
                    <div id="{$FormName}_Password_Box" class="type-text<% control errorMessages %><% if Password.message %> error<% end_if %><% end_control %>">
                        <% control errorMessages %>
                        <% if Password.message %>
                        <strong class="error" id="{$FormName}_Password_Error">
                            $Password.message
                        </strong>
                        <% end_if %>
                        <% end_control %>
                        <label for="{$FormName}_Password">* Passwort: </label>
                        $dataFieldByName(Password)
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="Actions">
        <% control Actions %>
       <div class="type-button">$Field</div>
        <% end_control %>
    </div>

    $dataFieldByName(SecurityID)

<% if IncludeFormTag %>
</form>
<% end_if %>