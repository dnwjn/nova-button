<template>
  <NovaButtonPanelItem
    :field="currentField"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
    class="px-2 md:px-4"
  >
    <template #value class="mt-1 md:mt-0 pb-5 px-6 md:px-8 flex flex-col md:flex-row md:items-center justify-center md:justify-end space-y-2 md:space-y-0 space-x-3">
      <NovaButtonField v-for="(button, index) in field.buttons"
                       :key="index"
                       :field="button"
      >
      </NovaButtonField>
    </template>
  </NovaButtonPanelItem>
</template>

<script>
import { DependentFormField } from '@/mixins'
import NovaButtonField from "../Form/NovaButtonField.vue";
import NovaButtonDefaultField from "../NovaButtonDefaultField.vue";
import NovaButtonPanelItem from "../NovaButtonPanelItem.vue";
export default {
  components: {NovaButtonPanelItem, NovaButtonDefaultField, NovaButtonField},
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
  mixins: [DependentFormField],

  computed: {
    /**
     * Determine if the field has a value other than null.
     */
    hasValue() {
      return this.field.buttons
    },
    extraAttributes() {
      return {
        // Leave the default attributes even though we can now specify
        // whatever attributes we like because the old number field still
        // uses the old field attributes
        type: this.currentField.type || 'email',
        pattern: this.currentField.pattern,
        placeholder: this.currentField.placeholder || this.field.name,
        class: this.errorClasses,
        ...this.currentField.extraAttributes,
      }
    },
  },
}
</script>
