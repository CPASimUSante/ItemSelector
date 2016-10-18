//the template for modals
//import addCategoryTemplate from '../Partial/modalAddCategory.html'

export default class ItemSelectorController {
    //no import of Angular stuff ($window, $scope…)
    constructor(ItemSelectorService) {
        /**
         * Configuration for the Claroline Resource Picker
         * @type {object}
         */
        this.resourcePicker = {
          // A step can allow be linked to one primary Resource, so disable multi-select
          isPickerMultiSelectAllowed: false,

          // Allows the type defined in the bundle configuration
          typeWhiteList: [ ItemSelectorService.getMainResourceType() ],

          // On select, set the resource of the ItemSelector
          callback: (nodes) => {
            if (angular.isObject(nodes)) {
              for (var nodeId in nodes) {
                if (nodes.hasOwnProperty(nodeId)) {
                  var node = nodes[nodeId]
  /*
                  // Initialize a new Resource object (parameters : claro type, mime type, id, name)
                  var resource = this.ResourceService.newResource(node[1], node[2], nodeId, node[0])
                  if (!this.ResourceService.exists(this.resources, resource)) {
                    // While only one resource is authorized, empty the resources array
                    this.resources.splice(0, this.resources.length)

                    // Resource is not in the list => add it
                    this.resources.push(resource)
                  }
  */
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
        this.errors = []
        this.errorMessage = null
        this._service = ItemSelectorService
    }
}
