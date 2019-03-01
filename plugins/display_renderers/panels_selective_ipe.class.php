<?php

/**
 * Renderer class for Selective In-Place Editor (IPE) behavior.
 */
class panels_selective_ipe extends panels_renderer_ipe {

  public function render_region($region_id, $panes) {
    if (_panels_selective_ipe_region_is_ipe_enabled($region_id, $this->plugins)){
      return parent::render_region($region_id, $panes);
    }
    return panels_renderer_standard::render_region($region_id, $panes);
  }

  /**
   *  Check if region is IPE enabled.
   */
  public function render_pane(&$pane) {
    if (_panels_selective_ipe_region_is_ipe_enabled($pane->panel, $this->plugins)){
      return parent::render_pane($pane);
    }
    return panels_renderer_standard::render_pane($pane);
  }

  /**
   * AJAX entry point to create the controller form for an IPE.
   * Redirect IPE after save.
   */
  function ajax_save_form($break = NULL) {
    parent::ajax_save_form($break);
    foreach ($this->commands as $key => $cmd) {
      if ($cmd['command'] == 'endIPE') {
        // ctools_include('ajax');
        // ctools_add_js('ajax-responder');
        $this->commands[] = ctools_ajax_command_redirect(drupal_get_destination());
        // unset($this->command[$key]);
      }
    }
  }

  /**
   * Add own JS for appending new elements.
   */
  function add_meta() {
    parent::add_meta();
    ctools_add_js('ajax-responder');
    ctools_add_js('panels_selective_ipe', 'panels_selective_ipe');
  }
}
