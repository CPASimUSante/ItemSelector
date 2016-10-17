/**
 * Manages Path form
 */

import template from './../Partial/itemList.html'

export default class ItemListDirective {
  constructor() {
    this.restrict = 'E'
    this.replace = true
    this.controller = 'ItemController'
    this.controllerAs = 'itemController'
    this.template = template
    this.scope = {
      // path      : '=', // Data of the path
      // modified  : '@' // Is Path have pending modifications ?
    }
    this.bindToController = true
  }
}
