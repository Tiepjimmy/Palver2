const Crud = {
  methods: {
    /**
     * @public
     * @param action
     * @param callback
     */
    crudAction(action, callback) {
      // crudActions
      let saveAction = this.$route.meta.crudActions.find(i => i.name === action)
      if (saveAction != null) {
        saveAction.callback = callback
      }
    },
    pageAction(action, callback) {
      // pageActions
      let saveAction = this.$route.meta.pageActions.find(i => i.name === action)
      if (saveAction != null) {
        saveAction.onClick = callback
      }
    }
  }
}

export default Crud
