$(document).ready(function() {
    /**
     * Hide/Show drawer for the archives list
     */
    $(".div-table-content").on("click", function () {
        // If the drawer is out, close it.
        if ($(".div-table-drawer[data-id='"+$(this).attr("data-id")+"']").length > 0) {
            $(".div-table-drawer[data-id='"+$(this).attr("data-id")+"']").slideUp("normal", function() {
                $(this).remove();
            });
        } else {
            var id = $(this).attr("data-id");
            // Create the archetype elements,
            // that will be cloned, instead of
            // creating new elements.
            var div     = $("<div>");
            var link    = $("<a>");
            // The container
            var drawerContainer = div.clone().attr({
                "class": "div-table-row div-table-drawer",
                "data-id": id
            }).hide();
            // View button
            var viewDrawer  = div.clone().appendTo(drawerContainer);
            var viewLink    = link.clone().attr({
                "href": "/articles/view/" + id
            }).appendTo(viewDrawer);
            var fontIconV   = div.clone().attr({
                "class": "font-icon icon-front"
            }).appendTo(viewLink);
            viewLink.append("View");
            // edit button
            var editDrawer  = div.clone().appendTo(drawerContainer);
            var editLink    = link.clone().attr({
                "href": "/articles/edit/" + id
            }).appendTo(editDrawer);
            var fontIconE   = div.clone().attr({
                "class": "font-icon icon-pencil"
            }).appendTo(editLink);
            editLink.append("Edit");
            // Publish/unpublish
            var publishDrawer  = div.clone().appendTo(drawerContainer);
            var publishLink    = link.clone().attr({
                "href": "/articles/publish/" + id
            }).appendTo(publishDrawer);
            var fontIconE   = div.clone().attr({
                "class": "font-icon icon-cancel-circled"
            }).appendTo(publishLink);
            publishLink.append("Unpublish");

            var deleteDrawer  = div.clone().appendTo(drawerContainer);
            var deleteLink    = link.clone().attr({
                "href": "/articles/remove/" + id
            }).appendTo(deleteDrawer);
            var fontIconE   = div.clone().attr({
                "class": "font-icon icon-trash"
            }).appendTo(deleteLink);
            deleteLink.append("Delete");

            drawerContainer.insertAfter($(this));
            drawerContainer.slideDown();
        }
    });

});
