<template>
  <section>
    <div
      v-if="message && hide == 0 && type == 'error'"
      class="verifyEmailText"
    >
      <div
        class="bg-red-100 border border-red-400 text-red-700 pl-4 pr-6 py-3 rounded relative"
        role="alert"
      >
        <span class="block sm:inline text-lg">{{ message }}</span>
        <span
          class="absolute top-0 bottom-0 right-0 px-2 py-3"
          @click="hideMessage"
        >
          <svg
            class="fill-current h-6 w-6 text-red -500"
            role="button"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          ><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
        </span>
      </div>
    </div>
    <div
      v-if="message && hide == 0 && type == 'success'"
      class="verifyEmailText"
    >
      <div
        class="bg-green-100 border border-green-400 text-green-700 pl-4 pr-6 py-3 rounded relative"
        role="alert"
      >
        <span class="block sm:inline text-lg gallery-success-msg" v-html="message"></span>
        <span
          class="absolute top-0 bottom-0 right-0 px-2 py-3"
          @click="hideMessage"
        >
          <svg
            class="fill-current h-6 w-6 text-green -500"
            role="button"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          ><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
        </span>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Message',
  props: {
    message: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: '',
    },
    hide: {
      type: Number,
      default: 0,
    },
  },
  methods: {
    hideMessage() {
      this.$emit('hide',1);
    },
  },
};
</script>
