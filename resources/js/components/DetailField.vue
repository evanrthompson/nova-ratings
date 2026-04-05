<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <span class="flex items-center gap-1">
                <template v-for="i in outOf" :key="i">
                    <!-- Full filled -->
                    <span
                        v-if="isFullFilled(i, ratingValue)"
                        :class="filledColorClass"
                        :style="filledColorStyle"
                    >
                        <span v-if="hasEmoji" class="text-sm leading-none">{{ field.emoji }}</span>
                        <span v-else-if="hasCustomSvg" class="w-4 h-4 block" v-html="field.svg"></span>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                        </svg>
                    </span>

                    <!-- Half filled -->
                    <span
                        v-else-if="isHalfFilled(i, ratingValue)"
                        class="relative w-4 h-4"
                    >
                        <span class="absolute inset-0 text-gray-200 dark:text-gray-600">
                            <span v-if="hasEmoji" class="text-sm leading-none opacity-30">{{ field.emoji }}</span>
                            <span v-else-if="hasCustomSvg" class="w-4 h-4 block" v-html="field.svg"></span>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span
                            class="absolute inset-0"
                            :class="filledColorClass"
                            :style="{ ...filledColorStyle, clipPath: 'inset(0 50% 0 0)' }"
                        >
                            <span v-if="hasEmoji" class="text-sm leading-none">{{ field.emoji }}</span>
                            <span v-else-if="hasCustomSvg" class="w-4 h-4 block" v-html="field.svg"></span>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>

                    <!-- Empty -->
                    <span v-else class="text-gray-200 dark:text-gray-600">
                        <span v-if="hasEmoji" class="text-sm leading-none opacity-30">{{ field.emoji }}</span>
                        <span v-else-if="hasCustomSvg" class="w-4 h-4 block" v-html="field.svg"></span>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                        </svg>
                    </span>
                </template>
            </span>
        </template>
    </PanelItem>
</template>

<script>
import RatingIcon from './RatingIcon'

export default {
    mixins: [RatingIcon],

    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    computed: {
        ratingValue() {
            return (parseFloat(this.field.value) || 0) * this.outOf;
        },
    },
}
</script>
