(function ($) {
    'use strict';

    function handleAutocompleteChoice(e, ui) {
        var d = ui.item;

        if (null !== d) {
            $('#value').html(d.value);
            $('#category').html(d.category);
            $('#artist').html(d.artist);
            $('#musicTitle').html(d.musicTitle);
            $('#label').html('<pre>' + d.label + '</pre>');
            $('#data').html(d.data);
            $('#lastfm').html(JSON.stringify(d.lastfm));
        }
    }

    function bindLfmAutocomplete() {
        // Autocomplete options.
        var acOptions = {
            callback: handleAutocompleteChoice,
            modules: [],
            apiKey: 'f791703e02b30485a7059d19d7913e34'
        };

        // See what modules, among ['artist', 'album', 'track'], are checked.
        var modules = ['artist'];
;
        acOptions.modules = modules;

        // if lfmAutocomplete is already placed, remove it.
        if ($('#search').data('custom-lfmAutocomplete')) {
            $('#search').lfmAutocomplete("destroy");
            $('#search').removeData('custom-lfmAutocomplete');
        }

        // bind autocomplete.
        $('#search').lfmComplete(acOptions);
    }

    $(document).ready(function() {
        $('.music-type').on('change', function(e) {
            // rebind lfmAutocomplete when checkbox items changes.
            bindLfmAutocomplete();
        });

        // First time it binds lfmAutocomplete.
        bindLfmAutocomplete();
    });
}(jQuery));
