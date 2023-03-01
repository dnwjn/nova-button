<template>
  <FieldWrapper :stacked="field.stacked" v-if="field.visible">
    <div
      class="px-6 md:px-8 mt-2 md:mt-0"
      :class="field.stacked ? 'md:pt-2 w-full' : 'w-full md:w-1/5 md:py-5'"
    >
      <FormLabel
        :label-for="labelFor || field.uniqueKey"
        :class="{ 'mb-2': shouldShowHelpText }"
        v-if="fieldLabel"
      >
        {{ fieldLabel }}
        <span v-if="field.required" class="text-red-500 text-sm">
          {{ __('*') }}
        </span>
      </FormLabel>
    </div>

    <div
      class="mt-1 md:mt-0 pb-5 px-6 md:px-8"
      :class="{
        'w-full md:w-1/5 md:py-5': !field.stacked,
        'w-full md:w-3/5 md:pt-2': field.stacked,
      }"
    >
      <span v-if="field.confirm == null">
        <nova-button
          :field="field"
          :resourceName="resourceName"
          :resourceId="resourceId"
          :disabled="field.disabled"
          @finished="reload"
        />
      </span>

      <div v-else>
        <button
          :class="field.classes"
          :disabled="field.disabled"
          v-html="field.text"
          @click.prevent.stop="modalIsOpen = true"
          type="button"
        />

        <confirm-modal
          v-if="modalIsOpen"
          :field="field"
          :resource="resource"
          :resource-name="resourceName"
          @finished="modalReload"
          @closed="modalIsOpen = false"
        />
      </div>

      <HelpText class="mt-2 help-text-error" v-if="showErrors && hasError">
        {{ firstError }}
      </HelpText>

      <HelpText class="help-text mt-2" v-if="shouldShowHelpText" v-html="field.helpText" />
    </div>
  </FieldWrapper>
</template>

<script>
import field from '../../field';
import NovaButton from './NovaButton';
import ConfirmModal from './ConfirmModal';
import FieldWrapper from 'laravel-nova/components/FieldWrapper';
import FormLabel from 'laravel-nova/components/FormLabel';
import HelpText from 'laravel-nova/components/HelpText';
import DependentFormField from 'laravel-nova/mixins/DependentFormField';

export default {
  components: { NovaButton, ConfirmModal, FieldWrapper, FormLabel, HelpText },
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  mixins: [field, DependentFormField],
  computed: {
    /**
     * Return the label that should be used for the field.
     */
    fieldLabel() {
      // If the field label is purposefully an empty string, then let's show it as such
      if (this.field.label === '') {
        return '';
      }

      return this.field.label || this.field.name;
    },

    /**
     * Determine help text should be shown.
     */
    shouldShowHelpText() {
      return (
        this.showHelpText && this.field && this.field.helpText && this.field.helpText.length > 0
      );
    },
  },
};
</script>
