<template>
  <DefaultField
      :field="field"
      :errors="errors"
      :show-help-text="showHelpText"
      :full-width-content="fullWidthContent"
  >
    <template #field>

      <div class="relative gap-2 flex items-center">

        <div v-if="field.clearable" @click="value = 0" class="hover:cursor-pointer hover:opacity-75 text-red-500">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
            <path fill-rule="evenodd" d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z" clip-rule="evenodd"/>
          </svg>

        </div>

        <template v-for="index in field.outOf" :key="index">

          <div class="text-primary-500 hover:cursor-pointer hover:opacity-75" @click="value = index" v-if="value >= index">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
              <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/>
            </svg>
          </div>

          <div class="text-gray-200 dark:text-gray-700 hover:cursor-pointer hover:opacity-75" @click="value = index" v-else>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
              <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/>
            </svg>
          </div>

        </template>

        <input
            :id="field.attribute"
            type="text"
            class="hidden w-full form-control form-input form-control-bordered"
            :class="errorClasses"
            :placeholder="field.name"
            v-model="value"
        />

      </div>


    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue () {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill (formData) {
      formData.append(this.fieldAttribute, this.value || '')
    },
  },
}
</script>
