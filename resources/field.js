import { queue } from './js/queue';

export default {
  data() {
    return {
      modalIsOpen: false,
    };
  },
  methods: {
    reload() {
      if (this.field.reload && queue.allowsReload()) {
        window.setTimeout(() => {
          this.$inertia.reload();
        }, 200);
      }
    },
    modalReload() {
      window.setTimeout(() => {
        this.modalIsOpen = false;
        this.reload();
      }, 400);
    },
  },
};
