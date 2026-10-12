<template>
  <div>
    <b-modal id="productDescription"
             ref="modal"
             :title="title"
             size="sm"
             :noCloseOnBackdrop="modalDontCloseOnBackdropClick"
             :teleport-disabled="true"
             :no-footer="true"
             v-model="showModal"
    >
      <div v-html="description"></div>
    </b-modal>
  </div>
</template>

<script>

export default {
  modalId: 'productDescription',
  created: function () {
    this.$root.bus.$on('show-product-description', (data) => {
      this.title = data.title;
      this.description = data.description;
      this.showModal = true;
    });
  },
  data: function () {
    return {
      title: '',
      description: '',
      showModal: false,
    };
  },
}
</script>
