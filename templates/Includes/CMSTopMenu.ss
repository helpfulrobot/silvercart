<style type="text/css">
    body.ModelAdmin #left {
        width: 300px;
    }
    #top {
        background:                     #f1f1f1;
        background:                     -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#b9b9b9)); /* for webkit browsers */
        background:                     -moz-linear-gradient(top, #ffffff,  #b9b9b9); /* for firefox 3.6+ */
        background:                     -o-linear-gradient(top, #ffffff,  #b9b9b9); /* for opera */
        filter:                         progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#b9b9b9'); /* for IE */
        border-bottom: 1px #fff solid;
    }
    #silvercart-cms-mainmenu-logo {
        float: left;
    }
    #silvercart-cms-mainmenu-logo a {
        position: relative;
        display: block;
        line-height: 11px;
        text-decoration: none;
        color: #333;
        margin: 0px;
        padding: 0px 8px 0px 27px;
    }
    #silvercart-cms-mainmenu-logo a img {
        position: absolute;
        left: 0px;
        top: 0px;
    }
    #silvercart-cms-mainmenu-logo a span {
        display: block;
        padding: 6px 0px 0px 0px;
    }
    #silvercart-cms-mainmenu ul {
        float: left;
    }
    #silvercart-cms-mainmenu ul li {
        float: left;
        margin: 0;
        height: 33px;
        cursor: pointer;
    }
    #silvercart-cms-mainmenu ul li a {
        display: block;
        height: 33px;
        float: left;
        padding: 0 6px;
        font-size: 14px;
        letter-spacing: -0.1px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: normal;
        line-height: 32px;
        color: #333;
        text-decoration: none;
        border-left: 1px #fff solid;
    }
    #silvercart-cms-mainmenu ul li:hover,
    #silvercart-cms-mainmenu ul li.active:hover {
        background: #1c587a;
    }
    #silvercart-cms-mainmenu ul li.active {
        background:                     #777;
        background:                     -webkit-gradient(linear, left top, left bottom, from(#aaa), to(#777)); /* for webkit browsers */
        background:                     -moz-linear-gradient(top, #aaa,  #777); /* for firefox 3.6+ */
        background:                     -o-linear-gradient(top, #aaa,  #777); /* for opera */
        filter:                         progid:DXImageTransform.Microsoft.gradient(startColorstr='#aaaaaa', endColorstr='#777777'); /* for IE */
    }
    #silvercart-cms-mainmenu ul li:hover a {
        color: #fff;
    }
    #silvercart-cms-mainmenu ul li.active a {
        color: #fff;
    }
    #silvercart-cms-mainmenu ul li a:hover {
        text-decoration: none;
        background: #4687a4;
    }
    #silvercart-cms-mainmenu ul li ul {
        z-index: 99;
        display: none;
        position: absolute;
        color: #fff;
        background: #1c587a;
        width: 300px;
        top:   33px;
        left:  auto;
        border-left: 1px #fff solid;
        border-right: 1px #fff solid;
        border-bottom: 1px #fff solid;
    }
    #silvercart-cms-mainmenu ul li:hover ul {
        display: block;
    }
    #silvercart-cms-mainmenu ul li ul li {
        display: block;
        margin: 0px;
        width: 100%;
        height: auto;
    }
    #silvercart-cms-mainmenu ul li ul li.section {
        height: auto;
        border-bottom: 1px #ccc solid;
    }
    #silvercart-cms-mainmenu ul li ul li.section p {
        font-size: 9px;
        margin: 0px;
        padding: 10px 6px 4px 6px;
    }
    #silvercart-cms-mainmenu ul li ul li a {
        float: none;
        display: block;
        height: auto;
        font-size: 13px;
        letter-spacing: 0px;
        line-height: 100%;
        border-left: none;
        padding: 6px 6px;
    }
</style>

<div id="silvercart-cms-mainmenu">
    <div id="silvercart-cms-mainmenu-logo">
        <a href="#">
            <img src="/silvercart/images/logo_storeadmin.png" width="25" height="33" alt="SilverCart" />
            <% if ApplicationLogoText %>
                <span>$ApplicationLogoText</span>
            <% end_if %>
        </a>
    </div>
    <ul>
        <% control SilvercartMenus %>
            <li<% if MenuSection %> class="active"<% end_if %>>
                <a href="#">$name{$MenuSection}</a>
                <ul>
                    <% control ModelAdmins %>
                        <% if IsSection %>
                            <li class="section">
                                <p>$name</p>
                            </li>
                        <% else %>
                            <li class="$LinkingMode"><a href="$Link">$Title</a></li>
                        <% end_if %>
                    <% end_control %>
                </ul>
            </li>
        <% end_control %>
        <li<% if CmsSection %> class="active"<% end_if %>>
            <a href="#">CMS{$CmsSection}</a>
            <ul>
                <% control SilvercartMainMenu %>
                    <li class="$LinkingMode" id="Menu-$Code"><a href="$Link">$Title</a></li>
                <% end_control %>
            </ul>
        </li>
    </ul>
</div>