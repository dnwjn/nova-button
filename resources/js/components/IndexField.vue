<template>
  <div v-if="field.visible">
    <span
      v-if="field.confirm == null"
      :class="{ 'block text-right': field.indexAlign === 'right' }"
    >
      <nova-button
        :field="field"
        :resourceName="resourceName"
        :resourceId="$parent.resource['id'].value"
        :disabled="field.disabled"
        @finished="reload"
      />
    </span>

    <div v-else :class="{ 'block text-right': field.indexAlign === 'right' }">
      <button
        class="whitespace-no-wrap"
        :class="field.classes"
        :disabled="field.disabled"
        v-html="field.text"
        @click.prevent.stop="modalIsOpen = true"
        type="button"
      />

      <modal
        v-if="modalIsOpen"
        :field="field"
        :resource="resource"
        :resource-name="resourceName"
        @finished="modalReload"
        @closed="modalIsOpen = false"
      />
    </div>
  </div>
</template>

<script>
import field from '../../field';
import NovaButton from './NovaButton';
import Modal from './Modal';

export default {
  components: { NovaButton, Modal },
  props: ['resource', 'resourceName', 'field'],
  mixins: [field],
};
</script>
