import animations from "@midudev/tailwind-animations"

/** @type {import('tailwindcss').Config} */
export default {
	content: ["./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}"],
	theme: {
		extend: {
			colors: {
				"primary": "var(--color-primary)",
				"primary-light": "var(--color-primary-light)",
				"primary-dark": "var(--color-primary-dark)",
				"secondary": "var(--color-secondary)",
				"twitch": "var(--color-twitch)",
			},
		},
	},
	darkMode: "class",
	plugins: [animations],
}
