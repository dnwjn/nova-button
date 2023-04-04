<template>
  <div class="modal">
    <div class="modal__inner">
      <transition name="fade">
        <div
          class="text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden"
          style="width: 460px"
        >
          <div class="p-8">
            <heading :level="2" class="mb-6" v-html="field.confirm.title"></heading>

            <p class="text-80 leading-normal" v-html="field.confirm.body"></p>
          </div>

          <div
            class="border-t border-50 border-gray-200 dark:border-gray-700 px-6 py-3 ml-auto flex items-center"
            style="min-height: 70px; flex-direction: row-reverse"
          >
            <button
              style="order: 2"
              class="cursor-pointer dim inline-block font-bold text-blue-500 hover:text-blue-400 mr-4"
              v-html="field.confirm.cancelButtonText"
              @click.prevent.stop="$emit('closed')"
              type="button"
            />

            <nova-button
              :field="field"
              :resource-name="resourceName"
              :resource-id="resourceId"
              :disabled="field.disabled"
              @finished="onFinished"
            />
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import field from '../../field';
import NovaButton from './NovaButton';

export default {
  components: { NovaButton },
  props: ['resource', 'resourceName', 'field'],
  mixins: [field],
  methods: {
    onFinished() {
      Nova.success('Success!');

      this.$emit('finished');
    },
  },
  computed: {
    resourceId() {
      if (this.resource && this.resource.id && this.resource.id.value) {
        return this.resource.id.value;
      }

      return 0;
    },
  },
};
</script>

<style>
.modal {
  position: fixed;
  z-index: 100;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(0, 0, 0, 0.5);
  cursor: initial;
}

.modal__inner {
  position: absolute;
  opacity: 1;
  z-index: 100;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
