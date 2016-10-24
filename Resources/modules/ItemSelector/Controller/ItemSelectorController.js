//the template for modals
//import addCategoryTemplate from '../Partial/modalAddCategory.html'

import errorTemplate from '../Partial/modalError.html'

export default class ItemSelectorController {
    //no import of Angular stuff ($window, $scope…)
    constructor($scope, url, ItemSelectorService) {
        this.scope = $scope
        this._service = ItemSelectorService
        this.UrlGenerator = url
        /**
         * Configuration for the Claroline Resource Picker
         * @type {object}
         */
        this.resourcePicker = {
          isPickerMultiSelectAllowed: false,
          // Allows the type defined in the bundle configuration
          typeWhiteList: [ ItemSelectorService.getMainResourceType() ],
          // On select, set the resource of the ItemSelector
          callback: (nodes) => {
            if (angular.isObject(nodes)) {
              for (var nodeId in nodes) {
                if (nodes.hasOwnProperty(nodeId)) {
                  var node = nodes[nodeId]

                  // Initialize a new Resource object (parameters : claro type, mime type, id, name)
                  var resource = ItemSelectorService.newResource(node[1], node[2], nodeId, node[0])
                  this.itemSelectorMain = resource
//console.log(node);
                }
              }

              this.scope.$apply()

              // Remove checked nodes for next time
              nodes = {}
            }
          }
        }

        //declaration of variables
        this.mainResourceType = ItemSelectorService.getMainResourceType()
        this.itemSelectorMain = ItemSelectorService.getItemSelectorMain()
        this.itemSelectorItems = ItemSelectorService.getItemSelectorItems()
        this.itemList = ItemSelectorService.getItemList()
        this.itemCountMax = ItemSelectorService.getItemCountMax()
        this.itemResourceTypeName = ItemSelectorService.getItemResourceTypeName()
        this.tabs = ""
        this.errors = []
        this.errorMessage = null
        this.itemShown = false
        this.showFS = true
        this.lastSaved = {}
        //item selected in the tab
        this.currentItem = null
        //resource to open
        this.currentClickedItemUrl = null

        // const items = this.itemSelectorItems
        // $scope.$watch(
        //     () => this.itemSelectorItems,
        //     true //to be updated when value change
        // );

console.log("this.itemSelectorMain");console.log(this.itemSelectorMain);
console.log("this.itemSelectorItems");console.log(this.itemSelectorItems);
    }

    //updates the array of item values
    changedValue(itemSelected, index) {
        this.itemSelectorItems.splice(index, 1)
        this.itemSelectorItems.splice(index, 0, itemSelected)
    }

    addItem() {
        let itemLength = this.itemSelectorItems.length
        if (this.itemCountMax > itemLength) {
            //let newItem = {"id":(itemLength+1), "resource":{}}
            let newItem = {}
            this.itemSelectorItems.push(newItem)
        }
    }

    removeItem(itemId) {
        this.itemSelectorItems.splice(itemId, 1)
    }

    saveItemSelector(form) {
        if (form.$valid) {
            this._service.saveItemSelector(
              this.itemSelectorMain,
              this.itemSelectorItems,
              () => this._modal(errorTemplate, 'simupoll_save_failure')
          )
        }
    }

    showItems() {
        this.itemShown = !this.itemShown
        console.log(this.itemShown)
    }

    openFullscreen() {
        this.showFS = false
    }

    closeFullscreen() {
        this.showFS = true
    }

    selectTab(tabId, nodeId) {
        this.currentItem = tabId
        //open resource
        this.currentClickedItemUrl = this.UrlGenerator(
            'claro_resource_open',
            { 'resourceType': this.itemResourceTypeName, 'node': nodeId }
        ) + '?iframe=1'
    }
}
