<template>
  <NovaButtonDefaultField
    :field="currentField"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
    class="px-2 md:px-4"
  >
    <template #field>
        <NovaButtonField v-for="(button, index) in field.buttons"
                         :key="index"
                         :field="button"
        >
        </NovaButtonField>
    </template>
  </NovaButtonDefaultField>
</template>

<script>
import { DependentFormField } from '@/mixins'
import NovaButtonField from "./NovaButtonField.vue";
import NovaButtonDefaultField from "../NovaButtonDefaultField.vue";
export default {
  components: {NovaButtonDefaultField, NovaButtonField},
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
