<template>
  <div class="flex border-b border-40 -mx-6 px-6 nova-button-wrapper" v-if="field.visible">
    <div class="w-1/4 py-4">
      <label class="font-normal text-80">{{ field.label }}</label>
    </div>

    <div class="w-3/4 py-4 break-words">
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
    </div>
  </div>
</template>

<script>
import field from '../../../field';
import NovaButton from '../NovaButton';
import ConfirmModal from '../ConfirmModal';

export default {
  components: { NovaButton, ConfirmModal },
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  mixins: [field],
};
</script>
