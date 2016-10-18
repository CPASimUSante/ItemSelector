/*global Routing*/
/*global Translator*/
//import documentSelectionTemplate from '../Partial/document_model_selection_modal.html'

export default class ItemSelectorService {
    constructor ($http, $uibModal) {
        this.$http = $http
        this.$uibModal = $uibModal
        this._mainResourceType = ItemSelectorService._getGlobal('mainResourceType')
        this._mainResource = ItemSelectorService._getGlobal('mainResourceType')
        this._itemSelector = ItemSelectorService._getGlobal('itemSelector')
        this._itemList = ItemSelectorService._getGlobal('itemList')
        this._itemCount = ItemSelectorService._getGlobal('itemCount')
    }

    getMainResourceType() {
        return this._mainResourceType
    }

    getMainResource() {
        return this._mainResource
    }

    getItemSelector() {
        return this._itemSelector
    }

    getItemList() {
        return this._itemList
    }

    getItemCount() {
        return this._itemCount
    }

    //defined in template script
    static _getGlobal (name) {
      if (typeof window[name] === 'undefined') {
        throw new Error(
          `Expected ${name} to be exposed in a window.${name} variable`
        )
      }
      return window[name]
    }
}
