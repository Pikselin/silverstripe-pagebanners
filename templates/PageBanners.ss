<% if $Banners %>
<div class="page-banners">
    <% loop $Banners %>
    <div id="page-banner-$ID" class="page-banner page-banner-$Type page-banner--hidden" role="alert" data-id="$ID" aria-hidden="true" data-nosnippet>
        <div class="page-banner-type">
            <% if $Type == 'Info' %>
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 96 960 960" width="24"><path d="M453 776h60V536h-60v240Zm26.982-314q14.018 0 23.518-9.2T513 430q0-14.45-9.482-24.225-9.483-9.775-23.5-9.775-14.018 0-23.518 9.775T447 430q0 13.6 9.482 22.8 9.483 9.2 23.5 9.2Zm.284 514q-82.734 0-155.5-31.5t-127.266-86q-54.5-54.5-86-127.341Q80 658.319 80 575.5q0-82.819 31.5-155.659Q143 347 197.5 293t127.341-85.5Q397.681 176 480.5 176q82.819 0 155.659 31.5Q709 239 763 293t85.5 127Q880 493 880 575.734q0 82.734-31.5 155.5T763 858.316q-54 54.316-127 86Q563 976 480.266 976Z"/></svg>
            <% end_if %>
            <% if $Type == 'Warning' %>
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 96 960 960" width="24"><path d="M479.982 776q14.018 0 23.518-9.482 9.5-9.483 9.5-23.5 0-14.018-9.482-23.518-9.483-9.5-23.5-9.5-14.018 0-23.518 9.482-9.5 9.483-9.5 23.5 0 14.018 9.482 23.518 9.483 9.5 23.5 9.5ZM453 623h60V370h-60v253Zm27.266 353q-82.734 0-155.5-31.5t-127.266-86q-54.5-54.5-86-127.341Q80 658.319 80 575.5q0-82.819 31.5-155.659Q143 347 197.5 293t127.341-85.5Q397.681 176 480.5 176q82.819 0 155.659 31.5Q709 239 763 293t85.5 127Q880 493 880 575.734q0 82.734-31.5 155.5T763 858.316q-54 54.316-127 86Q563 976 480.266 976Z"/></svg>
            <% end_if %>
            <% if $Type == 'Notice' %>
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 96 960 960" fill="#ffffff" width="24"><path d="m40 936 440-760 440 760H40Zm444.175-117q12.825 0 21.325-8.675 8.5-8.676 8.5-21.5 0-12.825-8.675-21.325-8.676-8.5-21.5-8.5-12.825 0-21.325 8.675-8.5 8.676-8.5 21.5 0 12.825 8.675 21.325 8.676 8.5 21.5 8.5ZM454 708h60V484h-60v224Z"/></svg>
            <% end_if %>            
        </div>
        <div class="page-banner-content">
            <% loop $LinksTo %>
            <% if $LinkURL %>
            <a href="{$LinkURL}"{$TargetAttr} class="alert alert-{$Up.Type}" title="Click for more details">
                <% end_if %>
                <% end_loop %>
                $Text
                <% loop $LinksTo %>
                <% if $LinkURL %>
            </a>
            <% end_if %>
            <% end_loop %>
        </div>
        <div class="page-banner-control">
            <% if $Dismiss %>
            <button class="page-banner-close" aria-label="Close" data-id="$ID">X</button>
            <% end_if %>
        </div>
    </div>
    <% end_loop %>  
</div>             
<% end_if %>