/*global Routing*/
/*global Translator*/
//import documentSelectionTemplate from '../Partial/document_model_selection_modal.html'

export default class ItemSelectorService {
    constructor ($http, $uibModal) {
        this.$http = $http
        this.$uibModal = $uibModal
        this._isid = ItemSelectorService._getGlobal('itemSelectorId')
        this._mainResourceType = ItemSelectorService._getGlobal('mainResourceType')
        this._itemSelectorMain = ItemSelectorService._getGlobal('itemSelectorMain')
        this._itemSelectorItems = ItemSelectorService._getGlobal('itemSelectorItems')
        this._itemList = ItemSelectorService._getGlobal('itemList')
        this._itemCountMax = ItemSelectorService._getGlobal('itemCountMax')
        this._itemResourceTypeName = ItemSelectorService._getGlobal('itemResourceTypeName')
    }

    getItemSelectorId() {
        return this._isid
    }

    getMainResourceType() {
        return this._mainResourceType
    }

    getItemSelectorMain() {
        return this._itemSelectorMain
    }

    getItemSelectorItems() {
        return this._itemSelectorItems
    }

    getItemList() {
        return this._itemList
    }

    getItemCountMax() {
        return this._itemCountMax
    }

    getItemResourceTypeName() {
        return this._itemResourceTypeName
    }

    saveItemSelector(mainResource, props, onFail) {

        const url = Routing.generate('cpasimusante_itemselector_save', {
          isid: this._isid
        })

        this.$http
          //pass variables to controller
          .post(url, { mainResource: mainResource, itemSelectorData:props })
          .then(
            response => {response.data},
            //and check if it's alright
            () => {
                onFail()
              }
          )
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

    /**
     * Create a new Resource object.
     *
     * @param   {string} [type]
     * @param   {string} [mimeType]
     * @param   {number} [id]
     * @param   {string} [name]
     *
     * @returns {Object}
     */
    newResource(type, mimeType, id, name) {
      return {
        id : id ? id : null,
        name : name ? name : null,
        type : type ? type : null,
        mimeType : mimeType ? mimeType : null,
        propagateToChildren : true
      }
    }
}
