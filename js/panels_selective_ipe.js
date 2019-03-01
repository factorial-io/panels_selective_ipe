// Ensure the $ alias is owned by jQuery.
(function($) {

$(function() {
  Drupal.ajax.prototype.commands.insertNewPane = function(ajax, data, status) {
    IPEContainerSelector = '#panels-ipe-regionid-' + data.regionId + ' div.panels-ipe-sort-container';
    lastPaneSelector = IPEContainerSelector + ' div.panels-ipe-portlet-wrapper:last';
    // Insert the new pane after the last pane in the region, if
    // any.
    if ($(lastPaneSelector).length) {
      insertData = {
        'method': 'after',
        'selector': lastPaneSelector,
        'data': data.renderedPane,
        'settings': null
      }
      Drupal.ajax.prototype.commands.insert(ajax, insertData, status);
    }
    // Else, insert it as a first child of the container. Doing so might fall
    // outside of the wrapping markup for the style, but it's the best we can
    // do.
    else {
      insertData = {
        'method': 'prepend',
        'selector': IPEContainerSelector,
        'data': data.renderedPane,
        'settings': null
      }
      Drupal.ajax.prototype.commands.insert(ajax, insertData, status);
    }
  };
});

})(jQuery);
