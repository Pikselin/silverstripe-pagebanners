<% if $Banners %>
    <div class="page-banners row">
        <% loop $Banners %>
            <div id="alert-$ID" class="alert alert-{$Type} <% if $Dismiss %>alert-dismissible<% end_if %> fade show rounded-0 mb-0" role="alert">
                <div class="container">
                    <i class="{$FAIcon} fa-xl"></i>
                    <% loop $LinksTo %>
                        <% if $LinkURL %>
                            <a href="{$LinkURL}"{$TargetAttr} class="link text-dark ps-4" title="Click for more details">
                        <% end_if %>
                    <% end_loop %>
                    $Text

                    <% loop $LinksTo %>
                        <% if $LinkURL %>
                            </a>
                        <% end_if %>
                    <% end_loop %>

                    <% if $Dismiss %>
                        <button type="button" class="btn close float-end" data-dismiss="alert" aria-label="Close" data-id="$ID">
                            <i class="fa-solid fa-circle-xmark fa-xl"></i>
                        </button>
                    <% end_if %>    
                </div>
            </div>
        <% end_loop %>  
    </div>             
<% end_if %>