<template>
  <div
    class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0"
    :dusk="field.attribute"
  >
    <div class="md:w-1/4 md:py-3">
      <slot>
        <h4 class="font-normal">
          <span>{{ label }}</span>
        </h4>
      </slot>
    </div>
    <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 flex flex-col md:flex-row md:items-center justify-center md:justify-end space-y-2 md:space-y-0 space-x-3">
      <slot name="value">
          {{ fieldValue }}
      </slot>
    </div>
  </div>
</template>

<script>
import { CopiesToClipboard, FieldValue } from '@/mixins'

export default {
  mixins: [CopiesToClipboard, FieldValue],

  props: {
    // index: {
    //   type: Number,
    //   required: true,
    // },

    field: {
      type: Object,
      required: true,
    },

    fieldName: {
      type: String,
      default: '',
    },
  },

  methods: {
    copy() {
      this.copyValueToClipboard(this.field.value)
    },
  },

  computed: {
    label() {
      return this.fieldName || this.field.name
    },
  },
}
</script>
