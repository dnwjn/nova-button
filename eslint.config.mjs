import globals from "globals";
import path from "node:path";
import { fileURLToPath } from "node:url";
import js from "@eslint/js";
import { FlatCompat } from "@eslint/eslintrc";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const compat = new FlatCompat({
    baseDirectory: __dirname,
    recommendedConfig: js.configs.recommended,
    allConfig: js.configs.all
});

export default [
    {
        files: ["**/*.{js,vue}"],
    },
    ...compat.extends("eslint:recommended", "plugin:vue/essential", "prettier"),
    {
        languageOptions: {
            globals: {
                ...globals.browser,
                ...globals.node,
                Nova: true,
                _: true,
            },

            ecmaVersion: 2017,
            sourceType: "module",
        },

        rules: {
            "vue/html-indent": ["error", 2],
            "vue/no-v-text-v-html-on-component": "off",
            "no-unused-vars": ["error", { caughtErrors: "none" }],
        },
    },
];