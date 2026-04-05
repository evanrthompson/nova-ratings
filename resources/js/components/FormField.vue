<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div
                class="relative flex items-center gap-2"
                role="radiogroup"
                :aria-label="field.name"
            >
                <!-- Clear button -->
                <div
                    v-if="field.clearable && !isReadonly"
                    @click="value = 0"
                    class="hover:cursor-pointer hover:opacity-75 text-red-500"
                    role="button"
                    aria-label="Clear rating"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                        <path fill-rule="evenodd" d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z" clip-rule="evenodd" />
                    </svg>
                </div>

                <template v-for="index in outOf" :key="index">
                    <!-- Full filled -->
                    <div
                        v-if="isFullFilled(index, parseFloat(value) || 0)"
                        :class="[filledColorClass, interactionClasses]"
                        :style="filledColorStyle"
                        @click="handleClick($event, index)"
                        role="radio"
                        :aria-checked="true"
                        :aria-label="index + ' out of ' + outOf"
                    >
                        <span v-if="hasEmoji" class="text-2xl leading-none select-none">{{ field.emoji }}</span>
                        <span v-else-if="hasCustomSvg" class="w-8 h-8 block" v-html="field.svg"></span>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                            <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <!-- Half filled -->
                    <div
                        v-else-if="isHalfFilled(index, parseFloat(value) || 0)"
                        class="relative w-8 h-8"
                        :class="interactionClasses"
                        @click="handleClick($event, index)"
                        role="radio"
                        :aria-checked="true"
                        :aria-label="(index - 0.5) + ' out of ' + outOf"
                    >
                        <span class="absolute inset-0 text-gray-200 dark:text-gray-700">
                            <span v-if="hasEmoji" class="text-2xl leading-none select-none opacity-30">{{ field.emoji }}</span>
                            <span v-else-if="hasCustomSvg" class="w-8 h-8 block" v-html="field.svg"></span>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span
                            class="absolute inset-0"
                            :class="filledColorClass"
                            :style="{ ...filledColorStyle, clipPath: 'inset(0 50% 0 0)' }"
                        >
                            <span v-if="hasEmoji" class="text-2xl leading-none select-none">{{ field.emoji }}</span>
                            <span v-else-if="hasCustomSvg" class="w-8 h-8 block" v-html="field.svg"></span>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>

                    <!-- Empty -->
                    <div
                        v-else
                        class="text-gray-200 dark:text-gray-700"
                        :class="interactionClasses"
                        @click="handleClick($event, index)"
                        role="radio"
                        :aria-checked="false"
                        :aria-label="index + ' out of ' + outOf"
                    >
                        <span v-if="hasEmoji" class="text-2xl leading-none select-none opacity-30">{{ field.emoji }}</span>
                        <span v-else-if="hasCustomSvg" class="w-8 h-8 block" v-html="field.svg"></span>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                            <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                        </svg>
                    </div>
                </template>

                <input
                    :id="field.attribute"
                    type="text"
                    class="hidden"
                    :class="errorClasses"
                    v-model="value"
                />
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import RatingIcon from './RatingIcon'

export default {
    mixins: [FormField, HandlesValidationErrors, RatingIcon],

    props: ['resourceName', 'resourceId', 'field'],

    computed: {
        isReadonly() {
            return this.field.readonly;
        },

        interactionClasses() {
            if (this.isReadonly) {
                return '';
            }
            return 'hover:cursor-pointer hover:opacity-75';
        },
    },

    methods: {
        setInitialValue() {
            this.value = (parseFloat(this.field.value) || 0) * this.outOf;
        },

        fill(formData) {
            formData.append(this.fieldAttribute, (this.value || 0) / this.outOf);
        },

        handleClick(event, index) {
            if (this.isReadonly) return;

            if (this.allowHalf) {
                const rect = event.currentTarget.getBoundingClientRect();
                const clickX = event.clientX - rect.left;
                const midpoint = rect.width / 2;

                this.value = clickX < midpoint ? index - 0.5 : index;
            } else {
                this.value = index;
            }
        },
    },
}
</script>
