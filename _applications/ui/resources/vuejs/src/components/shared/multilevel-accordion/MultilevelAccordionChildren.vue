<template>
  <div class="accordion-children">
    <li>
      <!-- Upper Tab -->
      <div
        class="accordion"
        @click="togglePanel()"
      >
        <slot
          :tree="tree"
          :interleaved="interleaved"
          :expanded="expanded"
          :level="level"
          :leaf="leaf"
        ></slot>
      </div>

      <!-- Expandible Elements -->
      <div
        v-if="!leaf"
        class="panel expandible panel-transition"
        :ref="`panel-${reference}`"
        :style="panelStyle"
      >
        <ul :style="`margin-left: ${marginLeft}rem;`">
          <multilevel-accordion-children
            v-for="(child, index) in tree.children"
            :key="index"
            :tree="child"
            :reference="`${reference}-${index}`"
            :ref="`childs-${reference}`"
            :position="index"
            :interleaveOffset="interleaveOffset + position + 1"
            :level="level + 1"
            :marginLeft="marginLeft"
            @updateHeight="updateHeight"
          >
            <template slot-scope="_">
              <slot
                :tree="_.tree"
                :interleaved="_.interleaved"
                :expanded="_.expanded"
                :level="_.level"
                :leaf="_.leaf"
                
              ></slot>
            </template>
          </multilevel-accordion-children>
        </ul>
      </div>
    </li>
  </div>
</template>

<script>
//import MultilevelAccordionChildren from "./MultilevelAccordionChildren.vue";
export default {
    name: "multilevel-accordion-children",
    props: {
        tree: {
        type: Object
        },
        reference: {
        type: String,
        required: true
        },
        interleaveOffset: {
        type: Number,
        required: true
        },
        position: {
        type: Number,
        required: true
        },
        level: {
        type: Number,
        required: true
        },
        marginLeft: {
        type: Number,
        default: 0
        },
        levelExpanded: {
        type: Number,
        default: 0
        }
    },
    components: {
        //MultilevelAccordionChildren
    },
    data() {
        return {
        panelStyle: "",
        interleaved: ((this.interleaveOffset % 2) + this.position) % 2 == 0,
        expanded: false
        };
    },
    methods: {
        togglePanel() {
            if (!this.expanded) {
                this.expand();
            } else {
                this.shrink();
            }
        },
        expand() {
            if (this.leaf) return null;
            if (!this.expanded) {
                let el = this.$refs[`panel-${this.reference}`];
                this.panelStyle = `max-height: ${el.scrollHeight}px;`;
                this.expanded = true;
                // Inform to the parent the new height so it can re calculate its scroll height
                this.$emit("updateHeight", el.scrollHeight);
            }
        },
        shrink() {
            if (this.leaf) return null;
            this.panelStyle = "max-height: 0px;";
            this.expanded = false;
        },
        updateHeight(childrenHeight) {
            // Recalculate scroll height based on childrens height modification
            if (this.expanded) {
                let el = this.$refs[`panel-${this.reference}`];
                this.panelStyle = `max-height: ${el.scrollHeight + childrenHeight}px;`;
                this.$emit("updateHeight", el.scrollHeight + childrenHeight);
            }
            }
    },
    mounted() {
        if (this.level < this.levelExpanded)
        this.togglePanel();
    },
    computed: {
        leaf() {
        // Override by user
        if (this.tree.leaf != undefined) return this.tree.leaf;
        if (this.tree.children == undefined) return true;
        return this.tree.children.length == 0;
        }
    }
};
</script>

<style scoped>
    .accordion {
        text-align: left;
    }
    .accordion-children li{
        list-style: none;
    }
    .panel {
        max-height: 0;
        overflow: hidden;
    }
    .panel-transition {
        transition: max-height 0.2s ease-out;
    }
</style>