import Filter from "@/core/filter";
import {mapState} from "vuex";

const DataListMixins = {
  data: function() {
    return {
      params          : new Filter(this.$route.query),
      pageNumbers     : [],
      showColumns     : [],
      lazyItem        : 10,
      total           : 0,
      totalPages      : -1,
      dataListEntity  : null
    }
  },
  methods: {
    indexCustom(index) {
      if (this.hasOwnProperty('lazyPage')) {
        index = index + 1
        const page = this.lazyPage
        const count = this.params.c
        return index + ((page - 1) * count);
      }
    },
    indexStatistic(index) {
      if (index == 0) {
        return
      }
      return index
    },
    tableHeaderColor(row) {
      return 'background-color: #f5f7fa'
    },
    async resetParamWithoutItemNumber() {
      this.lazyItem = await this.params.c
      await this.params.reset()
      this.params.c = this.lazyItem
    },
    mapListGroup(listGroup, returnEntity) {
      let currentGroup = listGroup.filter(i => {
        return i.value == this.user.group_id
      })
      let shareGroup = listGroup.filter( i => {
        return i.value != this.user.group_id
      })

      if (currentGroup.length > 0) {
        this[returnEntity].push({
          label: 'Shop chính',
          options: currentGroup,
        })
      }

      if (shareGroup.length > 0) {
        this[returnEntity].push({
          label: 'Shop chia sẻ',
          options: shareGroup,
        })
      }
    },
    withoutCurrentGroup(entity) {
      return this[entity].filter( i => {
        return i.value != this.user.group_id
      })
    },
    validateSaveFilter(filter, filterDefault) {
      let newFilter = Object.getOwnPropertyNames(filter);

      newFilter = newFilter.filter( i => {
        if (i != 'refresh' && i != 'gc') {
          return i
        }
      })

      if (newFilter.length != filterDefault.length) {
        return true;
      }

      if (filter.statuses.length > 0) {
        return true
      }

      return false
    },
  },
  computed: {
    columnsToShow() {
      let columns = this.showColumns.filter(function (i) {
        if (i) {
          return !i.is_default && i.is_shown == 1
        }
      })

      if (columns.length === 0) {
        columns.push({})
      }
      return columns
    },

    contentLoading() {
      if (this.firstFetched == false) {
        return 'Đang tải . . .';
      }

      if (this.firstFetched == true ) {
        return 'Không có dữ liệu';
      }
      return 'Đang tải . . .';
    },

    ...mapState({
      theme: state => state.theme,
    }),

    isSmallerScreen() {
      return this.theme.windowWidth < 768
    },
  },
}

export default DataListMixins
