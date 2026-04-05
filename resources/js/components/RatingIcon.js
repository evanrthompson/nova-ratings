/**
 * Shared mixin for rating icon rendering across Index, Detail, and Form components.
 *
 * Provides computed properties and methods for rendering the correct icon type
 * (default star SVG, custom SVG, or emoji) with the configured color.
 */
export default {
    computed: {
        hasEmoji() {
            return !!this.field.emoji;
        },

        hasCustomSvg() {
            return !!this.field.svg;
        },

        /**
         * The default star SVG path (Heroicons solid star).
         */
        defaultStarPath() {
            return 'M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z';
        },

        /**
         * Inline style object for the filled icon color.
         * Returns empty object when no custom color is set (falls back to Tailwind class).
         */
        filledColorStyle() {
            if (this.field.color) {
                return { color: this.field.color };
            }
            return {};
        },

        /**
         * CSS class for filled icons when no custom color is set.
         */
        filledColorClass() {
            return this.field.color ? '' : 'text-primary-500';
        },

        outOf() {
            return this.field.outOf ?? 5;
        },

        allowHalf() {
            return this.field.allowHalf ?? false;
        },
    },

    methods: {
        /**
         * Determine if an icon at the given 1-based index should be fully filled.
         */
        isFullFilled(index, value) {
            return value >= index;
        },

        /**
         * Determine if an icon at the given 1-based index should be half filled.
         * Only applies when allowHalf is enabled.
         */
        isHalfFilled(index, value) {
            if (!this.allowHalf) return false;
            return value >= index - 0.5 && value < index;
        },

        /**
         * Determine if an icon at the given 1-based index is empty (unfilled).
         */
        isEmpty(index, value) {
            if (this.allowHalf) {
                return value < index - 0.5;
            }
            return value < index;
        },
    },
};
