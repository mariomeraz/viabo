import preact from "@astrojs/preact"
import tailwind from "@astrojs/tailwind"
import { defineConfig } from "astro/config"
import path from "node:path"

const isDevMode = process.env.NODE_ENV === "development"

// https://astro.build/config
export default defineConfig({
	integrations: [tailwind(), preact()],
	base: isDevMode ? "/" : "/landing-pages/viabo",
	outDir: path.resolve("..", "viabo/backend/public/landing-pages/viabo"),
})
