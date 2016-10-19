//the template for modals
//import addCategoryTemplate from '../Partial/modalAddCategory.html'

export default class ItemSelectorController {
    //no import of Angular stuff ($window, $scope…)
    constructor($scope, ItemSelectorService) {
        this.scope = $scope
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
console.log(node);
                  this.mainResource = node[0]

                  break // We need only one node, so only the first one will be kept
                }
              }

              this.scope.$apply()

              // Remove checked nodes for next time
              nodes = {}
            }
          }
        }

        //declaration of variables
        this.mainResource = ItemSelectorService.getMainResource()
        this.itemSelector = ItemSelectorService.getItemSelector()
        this.itemList = ItemSelectorService.getItemList()
        this.itemCount = ItemSelectorService.getItemCount()
        this.tabs = this.itemSelector.items.length
        this.errors = []
        this.errorMessage = null
        this._service = ItemSelectorService
    }

    addItem() {
        if (this.itemCount > this.itemSelector.items.length) {
            let newItem = {"id":(this.itemSelector.items.length+1), "resource":{}}
            this.itemSelector.items.push(newItem)
        }
    }

    removeItem(itemId) {
        this.itemSelector.items.splice(itemId, 1)
    }
/*
    openFullscreen() {
        // $(".fullframe").css({"position":"fixed","top":0,"left":0,"width":"100%","height":"100%","background-color":"#FFFFFF","z-index":1e4})
        // $(this).hide();
        // $(".popin").show();
    }

    closeFullscreen {
        // $(".fullframe").css({"position":"relative"})
        // $(this).hide();
        // $(".popout").show();
    }*/
}
