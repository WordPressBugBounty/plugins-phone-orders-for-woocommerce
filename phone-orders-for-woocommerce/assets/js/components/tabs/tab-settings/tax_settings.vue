<template>
  <tr v-show="shown">
    <td colspan=2>
      <table class="form-table">
        <tbody>
        <tr>
          <td colspan=2>
            <b>{{ title }}</b>
          </td>
        </tr>

        <tr>
          <td>
            {{ showTaxTotalsLabel }}
          </td>
          <td>
            <input type="checkbox" class="option" v-model="elShowTaxTotals" name="show_tax_totals">
          </td>
        </tr>

        <tr>
          <td>
            {{ hideTaxLineProductItemLabel }}
          </td>
          <td>
            <input type="checkbox" class="option" v-model="elHideTaxLineProductItem" name="hide_tax_line_product_item">
          </td>
        </tr>

        <slot name="pro-tax-settings"/>

        </tbody>
      </table>
    </td>
  </tr>
</template>

<style>


</style>

<script>

export default {
  props: {
    title: {
      default: function () {
        return 'Tax';
      },
    },
    tabKey: {
      default: function () {
        return 'taxSettings';
      },
    },
    showTaxTotalsLabel: {
      default: function () {
        return 'Show detailed taxes';
      },
    },
    showTaxTotals: {
      default: function () {
        return false;
      },
    },
    hideTaxLineProductItemLabel: {
      default: function () {
        return "Hide tax line for item";
      },
    },
    hideTaxLineProductItem: {
      default: function () {
        return false;
      },
    },
  },
  mounted() {
    this.addSettingsTab(this.getTabsHeaders())
    this.setComponentsSettings(this.componentsSettings)
  },
  data() {
    return {
      elShowTaxTotals: this.showTaxTotals,
      elHideTaxLineProductItem: this.hideTaxLineProductItem,
    };
  },
  watch: {
    componentsSettings() {
      this.setComponentsSettings(this.componentsSettings)
    },
  },
  computed: {
    shown() {
      return this.getSettingsCurrentTab() === this.tabKey
    },
    componentsSettings() {
      return this.getSettings();
    },
  },
  methods: {
    getSettings() {

      var settings = {
        show_tax_totals: this.elShowTaxTotals,
        hide_tax_line_product_item: this.elHideTaxLineProductItem,
      };

      return settings;
    },
    getTabsHeaders() {
      return {
        key: this.tabKey,
        title: this.title,
      };
    },
    showOption(key) {
      this.shown = this.tabKey === key;
    },
  },
}
</script>
