<template>
  <span v-if="field.visible" :class="ajaxClasses">
    <button
      ref="novabutton"
      type="button"
      class="nova-button"
      v-html="buttonText"
      :disabled="disabled"
      @click.prevent.stop="handleClick"
      :class="buttonClasses"
      :style="{ 'min-width': buttonWidth }"
      :title="field.title"
      :dusk="field.attribute"
    ></button>
  </span>
</template>

<style>
.nova-button {
  white-space: nowrap;
}

.nova-button-loading,
.nova-button-success,
.nova-button-error {
  pointer-events: none;
}
</style>

<script>
import { queue } from '../queue.js';

export default {
  props: ['resource', 'resourceName', 'resourceId', 'field', 'ajaxClasses', 'disabled'],
  data: () => ({
    buttonWidth: null,
    loading: false,
    success: false,
    error: false,
  }),
  mounted() {
    this.$nextTick(() => {
      this.buttonWidth = this.$refs.novabutton.clientWidth + 2 + 'px';
    });
  },
  methods: {
    async handleClick() {
      if (this.field.disabled) {
        return;
      }

      if (this.resourceId) {
        queue.add(this.resourceId);
      }

      this.$emit('clicked');

      try {
        await this.post();

        this.success = true;
        this.loading = false;

        queue.hasSuccess = true;

        if (this.resourceId) {
          queue.remove(this.resourceId);
        }

        this.$emit('success');
        this.$emit('finished');

        this.navigate();
      } catch (error) {
        this.error = true;
        this.loading = false;

        queue.hasError = true;

        if (this.resourceId) {
          queue.remove(this.resourceId);
        }

        this.$emit('error');
        this.$emit('finished');
      }
    },
    post() {
      this.$emit('loading');

      if (!this.resourceName || !this.field.key) {
        return;
      }

      window.setTimeout(() => {
        this.loading = true;
      }, 200);

      let route = `/nova-vendor/dnwjn/nova-button/${this.resourceName}/${this.field.key}`;
      if (this.resourceId) {
        route += `/${this.resourceId}`;
      }

      return Nova.request().post(route, { event: this.field.event });
    },
    navigate() {
      if (this.field.type === 'route') {
        this.$inertia.visit(this.field.route);
      }

      if (this.field.type === 'link') {
        window.open(this.field.link.href, this.field.link.target);
      }
    },
    globalEmit() {
      if (this.field.emit) {
        // I'm assuming that Nova.$emit and this.$emit have different scopes, quick testing agrees
        Nova.$emit(this.field.emit, this.field.emitArgs);
      }
    },
  },
  computed: {
    buttonText() {
      if (this.field.confirm && this.field.confirm.confirmButtonText) {
        return this.field.confirm.confirmButtonText;
      }

      if (this.field.link && this.field.link.target === '_blank') {
        return this.field.text;
      }

      if (this.error && this.field.errorText) {
        return this.field.errorText;
      }

      if (this.success && this.field.successText) {
        return this.field.successText;
      }

      if (this.loading && this.field.loadingText) {
        return this.field.loadingText;
      }

      return this.field.text;
    },
    buttonClasses() {
      if (this.field.link && this.field.link.target === '_blank') {
        return this.field.classes;
      }

      if (this.error) {
        return ['text-center', 'nova-button-error', this.field.errorClasses || ''].join(' ');
      }

      if (this.success) {
        return [
          'text-center',
          'nova-button-success',
          'inline-block',
          'pt-2',
          'leading-tight',
          this.field.successClasses || '',
        ].join(' ');
      }

      if (this.loading) {
        return ['text-center', 'nova-button-loading', this.field.loadingClasses || ''].join(' ');
      }

      return this.field.classes;
    },
  },
};
</script>
