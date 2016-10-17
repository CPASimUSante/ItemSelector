/**
 * Manages Path form
 */

import template from './../Partial/itemSelectorForm.html'

export default class ItemSelectorFormDirective {
  constructor(ItemSelectorController) {
    this.restrict = 'E'
    this.replace = true
    this.controller = 'ItemSelectorController'
    this.controllerAs = 'itemSelectorController'
    this.template = template
    this.scope = {
      // path      : '=', // Data of the path
      // modified  : '@' // Is Path have pending modifications ?
    }
    this.bindToController = true
  }
}
