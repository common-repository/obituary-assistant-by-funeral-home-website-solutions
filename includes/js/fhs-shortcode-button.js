(function () {
    tinymce.PluginManager.add('fhws_add_shortcode_button', function (editor, url) {
        editor.addButton('fhws_add_shortcode_button', {
            title: 'Add Recent Obituaries Widget',
            image: 'https://cdn.obituary-assistant.com/global/recent_obituaries_nxoxbj.svg',
            onclick: function () {
                // Open window
                editor.windowManager.open({
                    title: 'Add shortcode',
                    body: [{
                        type: 'listbox',
                        name: 'position',
                        label: 'Obituaries Position',
                        'values': [
                            {text: 'Left', value: 'left'},
                            {text: 'Right', value: 'right'}
                        ]
                    }, {
                        type: 'listbox',
                        name: 'orientation',
                        label: 'Obituaries Orientation',
                        'values': [
                            {text: 'Vertical', value: 'vertical'},
                            {text: 'Horizontal', value: 'horizontal'}
                        ]
                    },
                    {
                        type: 'listbox',
                        name: 'count',
                        label: 'Obituaries Number of Post',
                        'values': [
                            {text: '5', value: '5'},
                            {text: '6', value: '6'},
                            {text: '7', value: '7'},
                            {text: '8', value: '8'},
                            {text: '9', value: '9'},
                            {text: '10', value: '10'},
                            {text: '11', value: '11'},
                            {text: '12', value: '12'},
                            {text: '13', value: '13'},
                            {text: '14', value: '14'},
							{text: '15', value: '15'},
							{text: '16', value: '16'},
							{text: '17', value: '17'},
							{text: '18', value: '18'},
							{text: '19', value: '19'},
							{text: '20', value: '20'}
                        ]
                    }],
                    onsubmit: function (e) {
                        // Insert content when the window form is submitted
                        editor.insertContent('[obituary-assistant-show-recent-obituaries position="' + e.data.position + '" orientation="' + e.data.orientation + '" count="' + e.data.count + '"]');
                    },
                    width: 700,
                    height: 200
                });
            }
        });
    });

})();

/**************Custom_option****************/

(function() {
    tinymce.create("tinymce.plugins.green_button_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button
            ed.addButton("OBITUARY_SUBSCRIPTION_BTN", {
                title : "Add Obituary subscription Popup.",
                cmd : "subscribe_command",
                image : "https://cdn3.iconfinder.com/data/icons/softwaredemo/PNG/32x32/Circle_Green.png"
            });

            //button functionality.
            ed.addCommand("subscribe_command", function() {
                var selected_text = ed.selection.getContent();
                var return_text = "[OBITUARY_SUBSCRIPTION]";
                ed.execCommand("mceInsertContent", 0, return_text);
            });

        },

        createControl : function(n, cm) {
            return null;
        },

/*         getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "",
                version : "1"
            };
        } */
    });

    tinymce.PluginManager.add("green_button_plugin", tinymce.plugins.green_button_plugin);
})();
