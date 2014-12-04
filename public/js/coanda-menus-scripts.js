var oldMenuContainer

$("ol.sortable-menu").sortable({

    group: 'nested',
    afterMove: function (placeholder, container) {

        if(oldMenuContainer != container){
            if(oldMenuContainer)
                oldMenuContainer.el.removeClass("active");

            container.el.addClass("active");

            oldMenuContainer = container;
        }

    },

    onDrop: function (item, container, _super) {
    
        container.el.removeClass("active");
        _super(item);

    }

});