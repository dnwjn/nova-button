<template>
  <FieldWrapper :stacked="field.stacked" v-if="field.visible">
    <div
      class="px-2 md:px-4 mt-2 md:mt-0"
      :class="field.stacked ? 'md:pt-2 w-full' : 'w-full md:w-1/5 md:py-5'"
    >
      <slot>
        <FormLabel
          :label-for="labelFor || field.uniqueKey"
          :class="{ 'mb-2': shouldShowHelpText }"
        >
          {{ fieldLabel }}
          <span v-if="field.required" class="text-red-500 text-sm">
            {{ __('*') }}
          </span>
        </FormLabel>
      </slot>
    </div>

    <div
      class="mt-1 md:mt-0 pb-5 px-6 md:px-8 flex flex-col md:flex-row md:items-center justify-center md:justify-end space-y-2 md:space-y-0 space-x-3"
      :class="{
        'md:w-full': fullWidthContent,
        'md:w-4/5': !fullWidthContent,
        'w-full md:py-5': !field.stacked,
        'w-full md:pt-2': field.stacked,
      }"
    >
      <slot name="field" />

      <HelpText class="mt-2 help-text-error" v-if="showErrors && hasError">
        {{ firstError }}
      </HelpText>

      <HelpText
        class="help-text mt-2"
        v-if="shouldShowHelpText"
        v-html="field.helpText"
      />
    </div>
  </FieldWrapper>
</template>

<script>
import { HandlesValidationErrors, mapProps } from '@/mixins'

export default {
  mixins: [HandlesValidationErrors],

  props: {
    field: { type: Object, required: true },
    fieldName: { type: String },
    showErrors: { type: Boolean, default: true },
    fullWidthContent: { type: Boolean, default: false },
    labelFor: { default: null },
    ...mapProps(['showHelpText']),
  },

  computed: {
    /**
     * Return the label that should be used for the field.
     */
    fieldLabel() {
      // If the field name is purposefully an empty string, then let's show it as such
      if (this.fieldName === '') {
        return ''
      }

      return this.fieldName || this.field.name || this.field.singularLabel
    },

    /**
     * Determine help text should be shown.
     */
    shouldShowHelpText() {
      return this.showHelpText && this.field.helpText?.length > 0
    },
  },
}
</script>
