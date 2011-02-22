<a class="skip" title="skip link" href="#navigation">Skip to the navigation</a><span class="hideme">.</span>
<a class="skip" title="skip link" href="#content">Skip to the content</a><span class="hideme">.</span>

<div class="subcolumns">

    <div class="MetaNavigation">
        <div class="c20l">
            <a href="$PageByIdentifierCode(SilvercartFrontPage).Link"><img id="img" src="/silvercart/images/home_new.png" alt="home"/></a>
        </div>

        <div class="c20l">
            <a href="$PageByIdentifierCode(SilvercartContactFormPage).Link"><img id="img" class="emailIcon" src="/silvercart/images/mail_dark.png" alt="<% _t(SilvercartContactFormPage.TITLE) %>" /></a>
        </div>

        <div class="c60r">
            <div class="MemberName">
                <% if CurrentMember %>
                    $CurrentMember.FirstName $CurrentMember.Surname
                <% end_if %>
            </div>
        </div>
    </div>
</div>